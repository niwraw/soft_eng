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
use App\Models\DocumentSHS;
use App\Models\DocumentALS;
use App\Models\DocumentOLD;
use App\Models\DocumentTRANSFER;
use App\Models\ApplicantLoginCreds;
use App\Models\CourseModel;
use App\Models\Regions;
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
use Illuminate\Support\Facades\Mail;
use App\Mail\CredentialsMail;
use Illuminate\Support\Facades\Hash;

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
        $year = date('Y');

        $student_id = Helper::IDGenerator(new ApplicantPersonalInformation, 'applicant_id', 5, $year);
        
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
            'province' => ['required'],
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
            'schoolAdd' => ['required', 'string', 'max:255'],
            'schoolReg' => ['required'],
            'schoolProv' => ['required'],
            'schoolMun' => ['required'],

            // Selection Information
            'choice1' => ['required'],
            'choice2' => ['required'],
            'choice3' => ['required'],

            // Files
            'birthCert' => [
                'required',
                'mimes:pdf',
                function($attribute, $value, $fail) {
                    $year = date('Y');
                    $student_id = Helper::IDGenerator(new ApplicantPersonalInformation, 'applicant_id', 5, $year);
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "Birth Certificate";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . $student_id . '-test' . '.jpeg';

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
                    $year = date('Y');
                    $student_id = Helper::IDGenerator(new ApplicantPersonalInformation, 'applicant_id', 5, $year);
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "Form 137";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . $student_id . 'test' . '.jpeg';

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
                    $year = date('Y');
                    $student_id = Helper::IDGenerator(new ApplicantPersonalInformation, 'applicant_id', 5, $year);
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "ALS Certification";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . $student_id . '-test' . '.jpeg';

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
                    $year = date('Y');
                    $student_id = Helper::IDGenerator(new ApplicantPersonalInformation, 'applicant_id', 5, $year);
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "Approval Letter";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . $student_id . '-test' . '.jpeg';

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
                    $year = date('Y');
                    $student_id = Helper::IDGenerator(new ApplicantPersonalInformation, 'applicant_id', 5, $year);
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "Report Card";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . $student_id . '-test' . '.jpeg';

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
                    $year = date('Y');
                    $student_id = Helper::IDGenerator(new ApplicantPersonalInformation, 'applicant_id', 5, $year);
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "Transcript of Record";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . $student_id . '-test' . '.jpeg';

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

        $personalInfoData = [
            'applicant_id' => $student_id,
            'lastName' => $validated['lastName'],
            'firstName' => $validated['firstName'],
            'middleName' => $validated['middleName'],
            'suffix' => $validated['suffix'],
            'email' => $validated['email'],
            'contactNum' => $validated['contactNum'],
            'applicationType' => $validated['applicationType'],
            'gender' => $validated['gender']
        ];
        ApplicantPersonalInformation::create($personalInfoData);

        $otherInfoData = [
            'applicant_id' => $student_id,
            'maidenName' => $validated['maidenName'],
            'birthDate' => $validated['birthDate'],
            'birthPlace' => $validated['birthPlace'],
            'address' => $validated['address'],
            'region' => $validated['region'],
            'province' => $validated['province'],
            'city' => $validated['city'],
            'barangay' => $validated['barangay']
        ];
        ApplicantOtherInformation::create($otherInfoData);

        $fatherInfoData = [
            'applicant_id' => $student_id,
            'fatherLast' => $validated['fatherLast'],
            'fatherFirst' => $validated['fatherFirst'],
            'fatherMiddle' => $validated['fatherMiddle'],
            'fatherSuffix' => $validated['fatherSuffix'],
            'fatherAddress' => $validated['fatherAddress'],
            'fatherContact' => $validated['fatherContact'],
            'fatherJob' => $validated['fatherJob'],
            'fatherIncome' => $validated['fatherIncome']
        ];
        ApplicantFatherInformation::create($fatherInfoData);

        $motherInfoData = [
            'applicant_id' => $student_id,
            'motherLast' => $validated['motherLast'],
            'motherFirst' => $validated['motherFirst'],
            'motherMiddle' => $validated['motherMiddle'],
            'motherSuffix' => $validated['motherSuffix'],
            'motherAddress' => $validated['motherAddress'],
            'motherContact' => $validated['motherContact'],
            'motherJob' => $validated['motherJob'],
            'motherIncome' => $validated['motherIncome']
        ];
        ApplicantMotherInformation::create($motherInfoData);

        if(!empty($validated['guardianLast']) && !empty($validated['guardianFirst']) && !empty($validated['guardianMiddle']) && !empty($validated['guardianSuffix']) && !empty($validated['guardianAddress']) && !empty($validated['guardianContact']) && !empty($validated['guardianJob']) && !empty($validated['guardianIncome'])){
            $guardianInfoData = [
                'applicant_id' => $student_id,
                'guardianLast' => $validated['guardianLast'],
                'guardianFirst' => $validated['guardianFirst'],
                'guardianMiddle' => $validated['guardianMiddle'],
                'guardianSuffix' => $validated['guardianSuffix'],
                'guardianAddress' => $validated['guardianAddress'],
                'guardianContact' => $validated['guardianContact'],
                'guardianJob' => $validated['guardianJob'],
                'guardianIncome' => $validated['guardianIncome']
            ];
            ApplicantGuardianInformation::create($fatherInfoData);
        }

        $schoolInfoData = [
            'applicant_id' => $student_id,
            'lrn' => $validated['lrn'],
            'school' => $validated['school'],
            'schoolEmail' => $validated['schoolEmail'],
            'schoolType' => $validated['schoolType'],
            'strand' => $validated['strand'],
            'gwa' => $validated['gwa'],
            'schoolAddress' => $validated['schoolAdd'],
            'schoolRegion' => $validated['schoolReg'],
            'schoolProvince' => $validated['schoolProv'],
            'schoolCity' => $validated['schoolMun']
        ];
        ApplicantSchoolInformation::create($schoolInfoData);

        $selectionInfoData = [
            'applicant_id' => $student_id,
            'choice1' => $validated['choice1'],
            'choice2' => $validated['choice2'],
            'choice3' => $validated['choice3']
        ];
        ApplicantSelectionInformation::create($selectionInfoData);

        $file = $request->file('birthCert');
        $extension = $file->getClientOriginalExtension();

        $birth = $student_id . '_birthCert.' . $extension;
        $pathCert = 'uploads/Birth_Certificate/';
        $file->move($pathCert, $birth);

        if ($validated['applicationType'] == "SHS")
        {
            $file = $request->file('form137');
            $extension = $file->getClientOriginalExtension();

            $form137 = $student_id . '_Form137.' . $extension;
            $pathForm = 'uploads/Form_137/';
            $file->move($pathForm, $form137);

            $documents = [
                'applicant_id' => $student_id,
                'birthCert' => $pathCert . $birth,
                'others' => $pathForm . $form137
            ];

            DocumentSHS::create($documents);
        }
        else if ($validated['applicationType'] == "ALS")
        {
            $file = $request->file('certificate');
            $extension = $file->getClientOriginalExtension();

            $certificate = $student_id . '_ALS_Cert.' . $extension;
            $pathCert = 'uploads/ALS_Cert/';
            $file->move($pathCert, $certificate);

            $documents = [
                'applicant_id' => $student_id,
                'birthCert' => $pathCert . $birth,
                'others' => $pathCert . $certificate
            ];

            DocumentALS::create($documents);
        }
        else if ($validated['applicationType'] == "OLD")
        {
            $file = $request->file('approvalLetter');
            $extension = $file->getClientOriginalExtension();

            $approval = $student_id . '_Approval_Letter.' . $extension;
            $pathApproval = 'uploads/Approval_Letter/';
            $file->move($pathApproval, $approval);

            $file = $request->file('highSchoolCard');
            $extension = $file->getClientOriginalExtension();

            $card = $student_id . '_Report_Card.' . $extension;
            $pathCard = 'uploads/Report_Card/';
            $file->move($pathCard, $card);

            $documents = [
                'applicant_id' => $student_id,
                'birthCert' => $pathCert . $birth,
                'approvalLetter' => $pathApproval . $approval,
                'highSchoolCard' => $pathCard . $card
            ];

            DocumentOLD::create($documents);
        }
        else if ($validated['applicationType'] == "TRANSFER")
        {
            $file = $request->file('transcriptRecord');
            $extension = $file->getClientOriginalExtension();

            $transcript = $student_id . '_Transcript_Record.' . $extension;
            $pathTranscript = 'uploads/Transcript_Record/';
            $file->move($pathTranscript, $transcript);

            $documents = [
                'applicant_id' => $student_id,
                'birthCert' => $pathCert . $birth,
                'others' => $pathTranscript . $transcript
            ];

            DocumentTRANSFER::create($documents);
        }

        $subject = 'Thank you for applying to PLMAT!';

        $body = 'Hello! Thank you for applying to PLMAT. 
        
                Your application has been received and is currently being processed.

                To check the status of your application, please visit the PLMAT website and log in using the following credentials:
                
                Email: ' . $validated['email'] . '
                
                Password: ' . $student_id . '';

        $credentials = [
            'applicant_id' => $student_id,
            'email' => $validated['email'],
            'password' => Hash::make($student_id)
        ];

        ApplicantLoginCreds::create($credentials);

        Mail::to($validated['email'])->send(new CredentialsMail($subject, $body));

        return redirect(RouteServiceProvider::HOME);
    }

    public function back(): RedirectResponse
    {
        return redirect()->intended('/home');
    }
}
