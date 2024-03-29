<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ApplicantFatherInformation;
use App\Models\SchoolModel;
use App\Models\ApplicantOtherInformation;
use App\Models\ApplicantPersonalInformation;
use App\Models\ApplicantMotherInformation;
use App\Models\ApplicantSchoolInformation;
use App\Models\ApplicantSelectionInformation;
use App\Models\ApplicantGuardianInformation;
use App\Models\CourseModel;
use App\Models\Regions;
use App\Models\ApplicantDocumentBirthCert;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Helper\Helper;
use Illuminate\Support\Facades\Redirect;
use Org_Heigl\Ghostscript\Ghostscript;
use Spatie\PdfToImage\Pdf;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

function laplacianVariance($imagePath) {
    $image = imagecreatefromjpeg($imagePath);
    $width = imagesx($image);
    $height = imagesy($image);

    $laplacian = [
        [-1, -1, -1],
        [-1,  8, -1],
        [-1, -1, -1]
    ];

    $variance = 0;
    for ($x = 1; $x < $width - 1; $x++) {
        for ($y = 1; $y < $height - 1; $y++) {
            $sum = 0;
            for ($i = -1; $i <= 1; $i++) {
                for ($j = -1; $j <= 1; $j++) {
                    $rgb = imagecolorat($image, $x + $i, $y + $j);
                    $gray = ($rgb >> 16) & 0xFF;
                    $sum += $gray * $laplacian[$i + 1][$j + 1];
                }
            }
            $variance += $sum * $sum;
        }
    }

    imagedestroy($image);
    return $variance / (($width - 2) * ($height - 2));
}

function calculateContrast($imagePath) {
    $image = imagecreatefromjpeg($imagePath);
    $width = imagesx($image);
    $height = imagesy($image);

    $mean = 0;
    $totalPixels = $width * $height;
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $rgb = imagecolorat($image, $x, $y);
            $gray = ($rgb >> 16) & 0xFF;
            $mean += $gray;
        }
    }
    $mean /= $totalPixels;

    $sumOfSquares = 0;
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $rgb = imagecolorat($image, $x, $y);
            $gray = ($rgb >> 16) & 0xFF;
            $sumOfSquares += pow($gray - $mean, 2);
        }
    }

    imagedestroy($image);
    return sqrt($sumOfSquares / $totalPixels);
}

class ApplicationController extends Controller
{
    public function create(): View
    {
        $schools = SchoolModel::all()->pluck('school_name');
        $courses = CourseModel::get(['course_code', 'course']);
        $regions = Regions::get(['region_code', 'region_name']);

        // dd($regions);
        return view('pages.application', compact('schools', 'courses', 'regions'));
    }

    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            // Application Information
            'lastName' => ['required', 'string', 'max:20'],
            'firstName' => ['required', 'string', 'max:20'],
            'middleName' => ['required', 'string', 'max:20'],
            'suffix' => ['nullable', Rule::in(['None', 'Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V'])],
            'email' => ['required', 'email', 'unique:applicant_personal_information',
                        function ($attribute, $value, $fail) {
                            if (str_ends_with($value, '@plm.edu.ph')) {
                                $fail('Invalid Email!');
                            }
                        },
                    ],
            'contactNum' => ['required', 'string', 'max:11', 'unique:applicant_personal_information', 'regex:/^09\d{9}$/'],
            'applicationType' => ['required'],
            'gender' => ['required'],

            // Other Information
            'maidenName' => ['nullable', 'string', 'max:75'],
            'birthDate' => ['required', 'date'],
            'birthPlace' => ['required', 'string', 'max:75'],
            'address' => ['required', 'string', 'max:255'],
            'region' => ['required'],
            'city' => ['required'],
            'barangay' => ['required'],
            // 'zip' => ['required', 'string', 'max:4'],

            // Father Information
            'fatherLast' => ['required', 'string', 'max:20'],
            'fatherFirst' => ['required', 'string', 'max:20'],
            'fatherMiddle' => ['required', 'string', 'max:20'],
            'fatherSuffix' => ['nullable', Rule::in(['None', 'Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V'])],
            'fatherAddress' => ['required', 'string', 'max:255'],
            'fatherContact' => ['required', 'string', 'max:11', 'regex:/^09\d{9}$/'],
            'fatherJob' => ['required', 'string', 'max:75'],
            'fatherIncome' => ['required', 'numeric'],

            // Mother Information
            'motherLast' => ['required', 'string', 'max:20'],
            'motherFirst' => ['required', 'string', 'max:20'],
            'motherMiddle' => ['required', 'string', 'max:20'],
            'motherSuffix' => ['nullable', Rule::in(['None', 'Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V'])],
            'motherAddress' => ['required', 'string', 'max:255'],
            'motherContact' => ['required', 'string', 'max:11', 'regex:/^09\d{9}$/'],
            'motherJob' => ['required', 'string', 'max:75'],
            'motherIncome' => ['required', 'numeric'],

            // Guardian Information
            'guardianLast' => ['nullable', 'string', 'max:20'],
            'guardianFirst' => ['nullable', 'string', 'max:20'],
            'guardianMiddle' => ['nullable', 'string', 'max:20'],
            'guardianSuffix' => ['nullable'],
            'guardianAddress' => ['nullable', 'string', 'max:255'],
            'guardianContact' => ['nullable', 'string', 'max:11', 'regex:/^09\d{9}$/'],
            'guardianJob' => ['nullable', 'string', 'max:75'],
            'guardianIncome' => ['nullable', 'numeric'],

            // School Information
            'lrn' => ['required', 'string', 'max:12'],
            'school' => ['required', 'string', 'max:75'],
            'schoolEmail' => ['required', 'email'],
            'schoolType' => ['required'],
            'strand' => ['required'],
            'gwa' => ['required'],

            // Selection Information
            'choice1' => ['required'],
            'choice2' => ['required'],
            'choice3' => ['required'],

            // Files
            'birthCert' => [
                'required',
                'mimes:pdf',
                function($attribute, $value, $fail) {
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "Birth Certificate";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . 'test' . '.jpeg';

                    $pdf->saveImage($file_path);

                    $image = $manager->read($file_path);

                    $image->greyscale()->save($file_path);

                    try
                    {
                        $file_read = (new TesseractOCR($file_path))->run();
                    }
                    catch (\Exception $e)
                    {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }

                    $file_read = strtolower($file_read);

                    $laplacianVariance = laplacianVariance($file_path);
                    if ($laplacianVariance < 100) {
                        $fail('The file is too blurry. Please upload a properly scanned PDF.');
                    }

                    $contrast = calculateContrast($file_path);
                    if ($contrast < 1.5) {
                        $fail('The file contrast is too low. Please upload a properly scanned PDF.');
                    }

                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }

                    if(strpos($file_read, 'birth') === false) {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }
                }
            ],

            'form137' => [
                $request->applicationType == 'SHS' ? 'required' : 'nullable', 
                'mimes:pdf',
                function($attribute, $value, $fail) {
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "Form 137";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . 'test' . '.jpeg';

                    $pdf->saveImage($file_path);

                    $image = $manager->read($file_path);

                    $image->greyscale()->save($file_path);

                    try
                    {
                        $file_read = (new TesseractOCR($file_path))->run();
                    }
                    catch (\Exception $e)
                    {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }

                    $file_read = strtolower($file_read);

                    $laplacianVariance = laplacianVariance($file_path);
                    if ($laplacianVariance < 100) {
                        $fail('The file is too blurry. Please upload a properly scanned PDF.');
                    }

                    $contrast = calculateContrast($file_path);
                    if ($contrast < 1.5) {
                        $fail('The file contrast is too low. Please upload a properly scanned PDF.');
                    }

                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }

                    if(strpos($file_read, 'permanent') === false) {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }
                }
            ],

            'certificate' => [
                $request->applicationType == 'ALS' ? 'required' : 'nullable', 
                'mimes:pdf',
                function($attribute, $value, $fail) {
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "ALS Certification";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . 'test' . '.jpeg';

                    $pdf->saveImage($file_path);

                    $image = $manager->read($file_path);

                    $image->greyscale()->save($file_path);

                    try
                    {
                        $file_read = (new TesseractOCR($file_path))->run();
                    }
                    catch (\Exception $e)
                    {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }

                    $file_read = strtolower($file_read);

                    $laplacianVariance = laplacianVariance($file_path);
                    if ($laplacianVariance < 100) {
                        $fail('The file is too blurry. Please upload a properly scanned PDF.');
                    }

                    $contrast = calculateContrast($file_path);
                    if ($contrast < 1.5) {
                        $fail('The file contrast is too low. Please upload a properly scanned PDF.');
                    }

                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }

                    if(strpos($file_read, 'alternative') === false) {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }
                }
            ],

            'approvalLetter' => [
                $request->applicationType == 'OLD' ? 'required' : 'nullable', 
                'mimes:pdf',
                function($attribute, $value, $fail) {
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "Approval Letter";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . 'test' . '.jpeg';

                    $pdf->saveImage($file_path);

                    $image = $manager->read($file_path);

                    $image->greyscale()->save($file_path);

                    try
                    {
                        $file_read = (new TesseractOCR($file_path))->run();
                    }
                    catch (\Exception $e)
                    {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }

                    $file_read = strtolower($file_read);

                    $laplacianVariance = laplacianVariance($file_path);
                    if ($laplacianVariance < 100) {
                        $fail('The file is too blurry. Please upload a properly scanned PDF.');
                    }

                    $contrast = calculateContrast($file_path);
                    if ($contrast < 1.5) {
                        $fail('The file contrast is too low. Please upload a properly scanned PDF.');
                    }

                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }

                    if(strpos($file_read, 'letter') === false) {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }
                }
            ],

            'highSchoolCard' => [
                $request->applicationType == 'OLD' ? 'required' : 'nullable', 
                'mimes:pdf',
                function($attribute, $value, $fail) {
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "Report Card";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . 'test' . '.jpeg';

                    $pdf->saveImage($file_path);

                    $image = $manager->read($file_path);

                    $image->greyscale()->save($file_path);

                    try
                    {
                        $file_read = (new TesseractOCR($file_path))->run();
                    }
                    catch (\Exception $e)
                    {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }

                    $file_read = strtolower($file_read);

                    $laplacianVariance = laplacianVariance($file_path);
                    if ($laplacianVariance < 100) {
                        $fail('The file is too blurry. Please upload a properly scanned PDF.');
                    }

                    $contrast = calculateContrast($file_path);
                    if ($contrast < 1.5) {
                        $fail('The file contrast is too low. Please upload a properly scanned PDF.');
                    }

                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }

                    if(strpos($file_read, 'report') === false) {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }
                }
            ],

            'transcriptRecord' => [
                $request->applicationType == 'TRANSFER' ? 'required' : 'nullable', 
                'mimes:pdf',
                function($attribute, $value, $fail) {
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "Transcript of Record";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . 'test' . '.jpeg';

                    $pdf->saveImage($file_path);

                    $image = $manager->read($file_path);

                    $image->greyscale()->save($file_path);

                    try
                    {
                        $file_read = (new TesseractOCR($file_path))->run();
                    }
                    catch (\Exception $e)
                    {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }

                    $file_read = strtolower($file_read);

                    $laplacianVariance = laplacianVariance($file_path);
                    if ($laplacianVariance < 100) {
                        $fail('The file is too blurry. Please upload a properly scanned PDF.');
                    }

                    $contrast = calculateContrast($file_path);
                    if ($contrast < 1.5) {
                        $fail('The file contrast is too low. Please upload a properly scanned PDF.');
                    }

                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }

                    if(strpos($file_read, 'record') === false) {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }
                }
            ],
        ], [
            'contactNum.regex' => 'Invalid contact number format! Should start with \'09\'',
            'fatherContact.regex' => 'Invalid contact number format! Should start with \'09\'',
            'motherContact.regex' => 'Invalid contact number format! Should start with \'09\'',
            'guardianContact.regex' => 'Invalid contact number format! Should start with \'09\'',
        ]);

        $year = date('Y');

        $student_id = Helper::IDGenerator(new ApplicantPersonalInformation, 'applicant_id', 5, $year);
        $user = new ApplicantPersonalInformation();

        $user->applicant_id = $student_id;

        $user->lastName = $request->lastName;
        $user->firstName = $request->firstName;
        $user->middleName = $request->middleName;
        $user->suffix = $request->suffix;
        $user->email = $request->email;
        $user->contactNum = $request->contactNum;
        $user->applicationType = $request->applicationType;
        $user->gender = $request->gender;

        $other = new ApplicantOtherInformation();

        $other->applicant_id = $student_id;
        $other->maidenName = $request->maidenName;
        $other->birthDate = $request->birthDate;
        $other->birthPlace = $request->birthPlace;
        $other->address = $request->address;
        $other->region = $request->region;
        $other->city = $request->city;
        $other->barangay = $request->barangay;
        // $other->zip = $request->zip;

        $father = new ApplicantFatherInformation();

        $father->applicant_id = $student_id;
        $father->fatherLast = $request->fatherLast;
        $father->fatherFirst = $request->fatherFirst;
        $father->fatherMiddle = $request->fatherMiddle;
        $father->fatherSuffix = $request->fatherSuffix;
        $father->fatherAddress = $request->fatherAddress;
        $father->fatherContact = $request->fatherContact;
        $father->fatherJob = $request->fatherJob;
        $father->fatherIncome = $request->fatherIncome;

        $mother = new ApplicantMotherInformation();

        $mother->applicant_id = $student_id;
        $mother->motherLast = $request->motherLast;
        $mother->motherFirst = $request->motherFirst;
        $mother->motherMiddle = $request->motherMiddle;
        $mother->motherSuffix = $request->motherSuffix;
        $mother->motherAddress = $request->motherAddress;
        $mother->motherContact = $request->motherContact;
        $mother->motherJob = $request->motherJob;
        $mother->motherIncome = $request->motherIncome;

        $guardian = new ApplicantGuardianInformation();

        $guardian->applicant_id = $student_id;
        $guardian->guardianLast = $request->guardianLast;
        $guardian->guardianFirst = $request->guardianFirst;
        $guardian->guardianMiddle = $request->guardianMiddle;
        $guardian->guardianSuffix = $request->guardianSuffix;
        $guardian->guardianAddress = $request->guardianAddress;
        $guardian->guardianContact = $request->guardianContact;
        $guardian->guardianJob = $request->guardianJob;
        $guardian->guardianIncome = $request->guardianIncome;

        $school = new ApplicantSchoolInformation();

        $school->applicant_id = $student_id;
        $school->lrn = $request->lrn;
        $school->school = $request->school;
        $school->schoolEmail = $request->schoolEmail;
        $school->schoolType = $request->schoolType;
        $school->strand = $request->strand;
        $school->gwa = $request->gwa;

        $selection = new ApplicantSelectionInformation();

        $selection->applicant_id = $student_id;
        $selection->choice1 = $request->choice1;
        $selection->choice2 = $request->choice2;
        $selection->choice3 = $request->choice3;

        // $user->save();
        // $other->save();
        // $father->save();
        // $mother->save();
        // $guardian->save();
        // $school->save();
        // $selection->save();

        if($request->has('birthCert')) {



        }

        return redirect(RouteServiceProvider::HOME);
    }
}
