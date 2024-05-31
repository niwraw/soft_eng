<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ApplicantPersonalInformation;
use App\Models\ApplicantOtherInformation;
use App\Models\ApplicantFatherInformation;
use App\Models\ApplicantMotherInformation;
use App\Models\ApplicantGuardianInformation;
use App\Models\ApplicantSchoolInformation;
use App\Models\ApplicantSelectionInformation;
use App\Models\DocumentALS;
use App\Models\DocumentOLD;
use App\Models\DocumentSHS;
use App\Models\DocumentTRANSFER;
use App\Models\CourseModel;
use App\Models\ApplicantLoginCreds;
use App\Models\ApplicationForm;
use App\Models\SchoolModel;
use App\Models\Regions;
use App\Models\Provinces;
use App\Models\Cities;
use App\Models\Barangays;
use Org_Heigl\Ghostscript\Ghostscript;
use Spatie\PdfToImage\Pdf;
use Spatie\Browsershot\Browsershot;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

function laplacianVariance($imagePath) {
    $image = imagecreatefrompng($imagePath);
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
    $image = imagecreatefrompng($imagePath);
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

class ApplicantController extends Controller
{
    public function ApplicantPage($currentRoute, $applicantId, Request $request)
    {
        $personalInfo = ApplicantPersonalInformation::where('applicant_id', $applicantId)->first();
        $schoolInfo = ApplicantSchoolInformation::where('applicant_id', $applicantId)->first();
        $selectionInfo = ApplicantSelectionInformation::where('applicant_id', $applicantId)->first();
        
        $course1 = CourseModel::where('course_code', $selectionInfo->choice1)->first();
        $course2 = CourseModel::where('course_code', $selectionInfo->choice2)->first();
        $course3 = CourseModel::where('course_code', $selectionInfo->choice3)->first();

        $selectionInfo->choice1 = $course1->course;
        $selectionInfo->choice2 = $course2->course;
        $selectionInfo->choice3 = $course3->course;

        if ($personalInfo->applicationType == 'SHS'){
            $document = DocumentSHS::where('applicant_id', $applicantId)->first();
        } elseif ($personalInfo->applicationType == 'ALS'){
            $document = DocumentALS::where('applicant_id', $applicantId)->first();
        } elseif ($personalInfo->applicationType == 'TRANSFER'){
            $document = DocumentTRANSFER::where('applicant_id', $applicantId)->first();
        } elseif ($personalInfo->applicationType == 'OLD'){
            $document = DocumentOLD::where('applicant_id', $applicantId)->first();
        }

        if($document->birthCertStatus == 'pending' || $document->formStatus == 'pending'){
            $overallStatus = 'pending';
        } else if ($document->birthCertStatus == 'resubmission' || $document->formStatus == 'resubmission') {
            $overallStatus = 'resubmission';
        } else if ($document->birthCertStatus == 'approved' && $document->formStatus == 'approved') {
            $overallStatus = 'approved';
        }

        if ($personalInfo->status == "approved") {
            $applicationForm = "Available";
        } else {
            $applicationForm = "Not Available";
        }

        $form = ApplicationForm::where('applicant_id', $applicantId)->first();

        if($form == null) {
            $appStatus = "Not Submitted";
        } else {
            $appStatus = "Submitted";
        }

        $routeSegment = request()->segment(1);
        return view('pages.applicant.applicant', compact('currentRoute', 'routeSegment', 'personalInfo', 'selectionInfo', 'schoolInfo', 'document', 'applicantId', 'applicationForm', 'appStatus', 'form'));
    }

    public function ResubmitBirthCert($currentRoute, $applicantId, Request $request)
    {
        // return dd($currentRoute, $applicantId, $request->all());
        $validated = $request->validate([
            'birthCert' => [
                'required',
                'mimes:pdf',
                function($attribute, $value, $fail) use ($applicantId) {
                    $student_id = $applicantId;
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "Birth Certificate";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . $student_id . '-test' . '.png';

                    $pdf->setOutputFormat('png')->saveImage($file_path);

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
            ]
        ]);

        $personalInfo = ApplicantPersonalInformation::where('applicant_id', $applicantId)->first();

        $file = $request->file('birthCert');
        $extension = $file->getClientOriginalExtension();

        $birth = $applicantId . '_birthCert.' . $extension;
        $pathCert = 'uploads/Birth_Certificate/';

        $fullPath = $pathCert . $birth;

        if (Storage::exists($fullPath)) {
            Storage::delete($fullPath);
        }

        $file->move($pathCert, $birth);

        if ($personalInfo->applicationType == "SHS")
        {
            $document = DocumentSHS::where('applicant_id', $applicantId)->first()->update([
                'birthCert' => $pathCert . $birth,
                'birthCertStatus' => 'pending',
                'birthCertComment' => 'Waiting for approval'
            ]);
        }

        $document = DocumentSHS::where('applicant_id', $applicantId)->first();

        if ($document->othersStatus == 'pending' || $document->birthCertStatus == 'pending') {
            $personalInfo->update([
                'status' => 'pending'
            ]);
        }

        // return dd($currentRoute, $applicantId);
        return redirect()->route('applicant.page', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]);
    }

    public function ResubmitForm137($currentRoute, $applicantId, Request $request)
    {
        $validated = $request->validate([
            'form137' => [
                'required',
                'mimes:pdf',
                function($attribute, $value, $fail) use ($applicantId) {
                    $student_id = $applicantId;
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $type = ApplicantPersonalInformation::where('applicant_id', $applicantId)->first()->applicationType;

                    if ($type == 'SHS') {
                        $uploadedFile = "Form 137";
                    } else if ($type == 'ALS') {
                        $uploadedFile = "ALS Certificate";
                    } else if ($type == 'TRANSFER') {
                        $uploadedFile = "TOR";
                    } else if ($type == 'OLD') {
                        $uploadedFile = "Approval Letter";
                    }

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . $student_id . 'test' . '.png';

                    $pdf->setOutputFormat('png')->saveImage($file_path);

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

                    if ($type == 'SHS') {
                        $keyword = "permanent";
                    } else if ($type == 'ALS') {
                        $keyword = "certificate";
                    } else if ($type == 'TRANSFER') {
                        $keyword = "transcript";
                    } else if ($type == 'OLD') {
                        $keyword = "approval";
                    }

                    if(strpos($file_read, $keyword) === false) {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }
                }
            ]
        ]);

        $personalInfo = ApplicantPersonalInformation::where('applicant_id', $applicantId)->first();
        $appType = ApplicantPersonalInformation::where('applicant_id', $applicantId)->first()->applicationType;

        $file = $request->file('form137');
        $extension = $file->getClientOriginalExtension();

        if($appType == "SHS"){
            $form = $applicantId . '_Form137.' . $extension;
            $pathCert = 'uploads/Form_137/';
        } else if ($appType == "ALS") {
            $form = $applicantId . '_ALS_Cert.' . $extension;
            $pathCert = 'uploads/ALS_Cert/';
        } else if ($appType == "TRANSFER") {
            $form = $applicantId . '_Transcript_Record.' . $extension;
            $pathCert = 'uploads/Transcript_Record/';
        } else if ($appType == "OLD") {
            $form = $applicantId . '_Approval_Letter.' . $extension;
            $pathCert = 'uploads/Approval_Letter/';
        }
        

        $fullPath = $pathCert . $form;

        if (Storage::exists($fullPath)) {
            Storage::delete($fullPath);
        }

        $file->move($pathCert, $form);

        if ($personalInfo->applicationType == "SHS")
        {
            $document = DocumentSHS::where('applicant_id', $applicantId)->first()->update([
                'others' => $pathCert . $form,
                'othersStatus' => 'pending',
                'othersComment' => 'Waiting for approval'
            ]);

            $document = DocumentSHS::where('applicant_id', $applicantId)->first();

            if ($document->othersStatus == 'pending' && $document->birthCertStatus == 'pending') {
                $personalInfo->update([
                    'status' => 'pending'
                ]);
            }
        } else if ($personalInfo->applicationType == "ALS")
        {
            $document = DocumentALS::where('applicant_id', $applicantId)->first()->update([
                'others' => $pathCert . $form,
                'othersStatus' => 'pending',
                'othersComment' => 'Waiting for approval'
            ]);

            $document = DocumentALS::where('applicant_id', $applicantId)->first();

            if ($document->othersStatus == 'pending' && $document->birthCertStatus == 'pending') {
                $personalInfo->update([
                    'status' => 'pending'
                ]);
            }
        } else if ($personalInfo->applicationType == "TRANSFER")
        {
            $document = DocumentTRANSFER::where('applicant_id', $applicantId)->first()->update([
                'others' => $pathCert . $form,
                'othersStatus' => 'pending',
                'othersComment' => 'Waiting for approval'
            ]);

            $document = DocumentTRANSFER::where('applicant_id', $applicantId)->first();

            if ($document->othersStatus == 'pending' && $document->birthCertStatus == 'pending') {
                $personalInfo->update([
                    'status' => 'pending'
                ]);
            }
        } else if ($personalInfo->applicationType == "OLD")
        {
            $document = DocumentOLD::where('applicant_id', $applicantId)->first()->update([
                'approvalLetter' => $pathCert . $form,
                'approvalLetterStatus' => 'pending',
                'approvalLetterComment' => 'Waiting for approval'
            ]);

            $document = DocumentOLD::where('applicant_id', $applicantId)->first();

            if ($document->approvalLetterStatus == 'pending' && $document->birthCertStatus == 'pending' && $document->highSchoolCardStatus == 'pending') {
                $personalInfo->update([
                    'status' => 'pending'
                ]);
            }
        }

        // return dd($currentRoute, $applicantId);
        return redirect()->route('applicant.page', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]);
    }

    public function ResubmitHighSchoolCard($currentRoute, $applicantId, Request $request)
    {
        $validated = $request->validate([
            'card' => [
                'required',
                'mimes:pdf',
                function($attribute, $value, $fail) use ($applicantId) {
                    $student_id = $applicantId;
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "High School Card";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . $student_id . '-test' . '.png';

                    $pdf->setOutputFormat('png')->saveImage($file_path);

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
            ]
        ]);

        $personalInfo = ApplicantPersonalInformation::where('applicant_id', $applicantId)->first();

        $file = $request->file('card');
        $extension = $file->getClientOriginalExtension();

        $birth = $applicantId . 'Report_Card.' . $extension;
        $pathCert = 'uploads/Report_Card/';

        $fullPath = $pathCert . $birth;

        if (Storage::exists($fullPath)) {
            Storage::delete($fullPath);
        }

        $file->move($pathCert, $birth);

        if ($personalInfo->applicationType == "OLD")
        {
            $document = DocumentOLD::where('applicant_id', $applicantId)->first()->update([
                'highSchoolCard' => $pathCert . $birth,
                'highSchoolCardStatus' => 'pending',
                'highSchoolCardComment' => 'Waiting for approval'
            ]);
        }

        $document = DocumentOLD::where('applicant_id', $applicantId)->first();

        if ($document->approvalLetterStatus == 'pending' && $document->birthCertStatus == 'pending' && $document->highSchoolCardStatus == 'pending') {
            $personalInfo->update([
                'status' => 'pending'
            ]);
        }

        // return dd($currentRoute, $applicantId);
        return redirect()->route('applicant.page', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]);
    }

    public function SubmitApplicationForm($currentRoute, $applicantId, Request $request)
    {
        $validated = $request->validate([
            'appform' => [
                'required',
                'mimes:pdf',
                function($attribute, $value, $fail) use ($applicantId) {
                    $student_id = $applicantId;
                    $upload_dir = 'uploads/';
                    $file_read = "";
                    $manager = new ImageManager(new Driver());

                    $uploadedFile = "Application Form";

                    $folder = base_path('public/' . $upload_dir . 'test/');
                    Ghostscript::setGsPath('C:\Program Files\gs\gs10.02.1\bin\gswin64c.exe');
                    $pdf = new Pdf($value);

                    $file_path = $folder . $student_id . 'test' . '.png';

                    $pdf->setOutputFormat('png')->saveImage($file_path);

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

                    if(strpos($file_read, $applicantId) === false) {
                        $fail('The file cannot be recognized as a '. $uploadedFile . '. Please upload a valid '. $uploadedFile . '.');
                    }
                }
            ]
        ]);

        $file = $request->file('appform');
        $extension = $file->getClientOriginalExtension();

        $birth = $applicantId . '_applicationForm.' . $extension;
        $pathCert = 'uploads/Application_Form/';

        $fullPath = $pathCert . $birth;

        $ifExist = ApplicationForm::where('applicant_id', $applicantId)->first();

        if($ifExist == null) 
        {
            $collection = [
                'applicant_id' => $applicantId,
                'applicationForm' => $pathCert . $birth,
                'applicationFormStatus' => 'pending',
                'applicationFormComment' => 'Waiting for approval'
            ];
            
            $file->move($pathCert, $birth);

            ApplicationForm::create($collection);
        } 
        else
        {
            if (Storage::exists($fullPath)) {
                Storage::delete($fullPath);
            }
    
            $file->move($pathCert, $birth);

            $document = ApplicationForm::where('applicant_id', $applicantId)->first()->update([
                'applicationForm' => $pathCert . $birth,
                'applicationFormStatus' => 'pending',
                'applicationFormComment' => 'Waiting for approval'
            ]);
        }


        // return dd($currentRoute, $applicantId);
        return redirect()->route('applicant.page', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]);
    }

    public function ChangePassword($currentRoute, $applicantId, Request $request)
    {
        $validated = $request->validate([
            'curPass' => 'required',
            'newPass' => 'required|min:8|confirmed',
        ], [
            'curPass.required' => 'Current password is required.',
            'newPass.required' => 'New password is required.',
            'newPass.min' => 'New password must be at least 8 characters.',
            'newPass.confirmed' => 'Passwords do not match.',
        ]);

        $personalInfo = ApplicantLoginCreds::where('applicant_id', $applicantId)->first();

        if (!Hash::check($request->curPass, $personalInfo->password)) {
            return redirect()->back()->withErrors(['curPass' => 'Current password is incorrect.']);
        }

        $personalInfo->update([
            'password' => bcrypt($validated['newPass'])
        ]);

        return redirect()->route('applicant.page', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId])->with('changed', 'Password successfully changed.');
    }

    public function GenerateApplication($currentRoute, $applicantId, Request $request)
    {
        return view('documents.applicationform');

        $html = view('documents.applicationform')->render();
        
        $pdf = Browsershot::html($html)
            ->newHeadless()
            ->setNpmBinary('C:\Program Files\nodej\npm')
            ->setNodeBinary('C:\Program Files\nodejs\node.exe')
            ->format('A4')
            ->pdf();

            return view('documents.applicationform');

        return response()->download($pdf);
    }

    public function EditInformation($currentRoute, $applicantId, Request $request)
    {
        $schools = SchoolModel::all()->pluck('school_name');
        $regions = Regions::get(['region_code', 'region_name']);
        $personal = ApplicantPersonalInformation::where('applicant_id', $applicantId)->first();
        $other = ApplicantOtherInformation::where('applicant_id', $applicantId)->first();
        $father = ApplicantFatherInformation::where('applicant_id', $applicantId)->first();
        $mother = ApplicantMotherInformation::where('applicant_id', $applicantId)->first();
        $guardian = ApplicantGuardianInformation::where('applicant_id', $applicantId)->first();
        $school = ApplicantSchoolInformation::where('applicant_id', $applicantId)->first();

        if($personal->applicationType == "SHS"){
            $personal->applicationType = "Senior High School";
        } else if($personal->applicationType == "ALS"){
            $personal->applicationType = "Alternative Learning System";
        } else if($personal->applicationType == "OLD"){
            $personal->applicationType = "Old Curriculum";
        } else if($personal->applicationType == "TRANSFER"){
            $personal->applicationType = "Transfer Student";
        }

        $region = Regions::where('region_code', $other->region)->first()->region_name;
        $province = Provinces::where('province_code', $other->province)->first()->province_name;
        $city = Cities::where('city_code', $other->city)->first()->city_name;
        $barangay = Barangays::where('brgy_code', $other->barangay)->first()->brgy_name;

        $schoolReg = Regions::where('region_code', $school->schoolRegion)->first()->region_name;
        $schoolProv = Provinces::where('province_code', $school->schoolProvince)->first()->province_name;
        $schoolCity = Cities::where('city_code', $school->schoolCity)->first()->city_name;
        
        if($school->strand == "ABM"){
            $strand = "Accountancy, Business, and Management";
        } else if($school->strand == "HUMSS"){
            $strand= "Humanities and Social Sciences";
        } else if($school->strand == "STEM"){
            $strand = "Science, Technology, Engineering, and Mathematics";
        } else if($school->strand == "GAS"){
            $strand = "General Academic Strand";
        } else if($school->strand == "TVL"){
            $strand = "Technical-Vocational-Livelihood";
        } else if($school->strand == "SPORTS"){
            $strand = "Sports Track";
        } else if($school->strand == "ADT"){
            $strand = "Arts and Design Track";
        } else if($school->strand == "PBM"){
            $strand = "Personal Development Track";
        }

        // dd($regions);
        return view('pages.applicant.edit', compact('schools', 'regions', 'personal', 'other', 'father', 'mother', 'guardian', 'school', 'region', 'province', 'city', 'barangay', 'schoolReg', 'schoolProv', 'schoolCity', 'strand', 'currentRoute', 'applicantId'));
    }

    public function ConfirmInformation($currentRoute, $applicantId, Request $request)
    {
        $validated = $request->validate([
            'lastName' => 'required',
            'firstName' => 'required',
            'middleName' => 'nullable',
            'suffix' => 'nullable',
            'gender' => 'required',
            'maidenName' => 'nullable',
            'birthDate' => 'required',
            'birthPlace' => 'required',
            'address' => 'required',
            'region' => 'required',
            'province' => 'required',
            'city' => 'required',
            'barangay' => 'required',
            'fatherLast' => 'required',
            'fatherFirst' => 'required',
            'fatherMiddle' => 'required',
            'fatherSuffix' => 'nullable',
            'fatherAddress' => 'required',
            'fatherJob' => 'required',
            'fatherContact' => 'required',
            'fatherIncome' => 'required',
            'motherLast' => 'required',
            'motherFirst' => 'required',
            'motherMiddle' => 'required',
            'motherSuffix' => 'nullable',
            'motherAddress' => 'required',
            'motherJob' => 'required',
            'motherContact' => 'required',
            'motherIncome' => 'required',
            'guardianLast' => 'nullable',
            'guardianFirst' => 'nullable',
            'guardianMiddle' => 'nullable',
            'guardianSuffix' => 'nullable',
            'guardianAddress' => 'nullable',
            'guardianJob' => 'nullable',
            'guardianContact' => 'nullable',
            'guardianIncome' => 'nullable',
            'lrn' => 'required',
            'school' => 'required',
            'schoolEmail' => 'required',
            'schoolType' => 'required',
            'schoolAdd' => 'required',
            'schoolReg' => 'required',
            'schoolProv' => 'required',
            'schoolMun' => 'required',
            'strand' => 'required',
            'gwa' => 'required',
        ]);

        $personal = ApplicantPersonalInformation::where('applicant_id', $applicantId)->first();
        $other = ApplicantOtherInformation::where('applicant_id', $applicantId)->first();
        $father = ApplicantFatherInformation::where('applicant_id', $applicantId)->first();
        $mother = ApplicantMotherInformation::where('applicant_id', $applicantId)->first();
        $guardian = ApplicantGuardianInformation::where('applicant_id', $applicantId)->first();
        $school = ApplicantSchoolInformation::where('applicant_id', $applicantId)->first();

        if($validated['gender'] == "Male"){
            $gender = "male";
        } else if($validated['gender'] == "Female"){
            $gender = "female";
        }

        $personalInfo = [
            'lastName' => $validated['lastName'],
            'firstName' => $validated['firstName'],
            'middleName' => $validated['middleName'],
            'suffix' => $validated['suffix'],
            'gender' => $gender
        ];

        $region = Regions::where('region_name', $validated['region'])->first()->region_code;
        $province = Provinces::where('province_name', $validated['province'])->first()->province_code;
        $city = Cities::where('city_name', $validated['city'])->first()->city_code;
        $barangay = Barangays::where('brgy_name', $validated['barangay'])->first()->brgy_code;

        $otherInfo = [
            'maidenName' => $validated['maidenName'],
            'birthDate' => $validated['birthDate'],
            'birthPlace' => $validated['birthPlace'],
            'address' => $validated['address'],
            'region' => $region,
            'province' => $province,
            'city' => $city,
            'barangay' => $barangay
        ];

        $fatherInfo = [
            'fatherLast' => $validated['fatherLast'],
            'fatherFirst' => $validated['fatherFirst'],
            'fatherMiddle' => $validated['fatherMiddle'],
            'fatherSuffix' => $validated['fatherSuffix'],
            'fatherAddress' => $validated['fatherAddress'],
            'fatherJob' => $validated['fatherJob'],
            'fatherContact' => $validated['fatherContact'],
            'fatherIncome' => $validated['fatherIncome']
        ];

        $motherInfo = [
            'motherLast' => $validated['motherLast'],
            'motherFirst' => $validated['motherFirst'],
            'motherMiddle' => $validated['motherMiddle'],
            'motherSuffix' => $validated['motherSuffix'],
            'motherAddress' => $validated['motherAddress'],
            'motherJob' => $validated['motherJob'],
            'motherContact' => $validated['motherContact'],
            'motherIncome' => $validated['motherIncome']
        ];

        if($validated['guardianLast'] != null) {
            $guardianInfo = [
                'guardianLast' => $validated['guardianLast'],
                'guardianFirst' => $validated['guardianFirst'],
                'guardianMiddle' => $validated['guardianMiddle'],
                'guardianSuffix' => $validated['guardianSuffix'],
                'guardianAddress' => $validated['guardianAddress'],
                'guardianJob' => $validated['guardianJob'],
                'guardianContact' => $validated['guardianContact'],
                'guardianIncome' => $validated['guardianIncome']
            ];
        } 

        $schoolReg = Regions::where('region_name', $validated['schoolReg'])->first()->region_code;
        $schoolProv = Provinces::where('province_name', $validated['schoolProv'])->first()->province_code;
        $schoolCity = Cities::where('city_name', $validated['schoolMun'])->first()->city_code;

        if ($validated['schoolType'] == "Public") {
            $schoolType = "public";
        } else if ($validated['schoolType'] == "Private") {
            $schoolType = "private";
        }

        if ($validated['strand'] == "Accountancy, Business, and Management") {
            $strand = "ABM";
        } else if ($validated['strand'] == "Humanities and Social Sciences") {
            $strand = "HUMSS";
        } else if ($validated['strand'] == "Science, Technology, Engineering, and Mathematics") {
            $strand = "STEM";
        } else if ($validated['strand'] == "General Academic Strand") {
            $strand = "GAS";
        } else if ($validated['strand'] == "Technical-Vocational-Livelihood") {
            $strand = "TVL";
        } else if ($validated['strand'] == "Sports Track") {
            $strand = "SPORTS";
        } else if ($validated['strand'] == "Arts and Design Track") {
            $strand = "ADT";
        } else if ($validated['strand'] == "Personal Development Track") {
            $strand = "PBM";
        }


        $schoolInfo = [
            'lrn' => $validated['lrn'],
            'school' => $validated['school'],
            'schoolEmail' => $validated['schoolEmail'],
            'schoolType' => $schoolType,
            'schoolAddress' => $validated['schoolAdd'],
            'schoolRegion' => $schoolReg,
            'schoolProvince' => $schoolProv,
            'schoolCity' => $schoolCity,
            'strand' => $strand,
            'gwa' => $validated['gwa']
        ];

        $personal->update($personalInfo);
        $other->update($otherInfo);
        $father->update($fatherInfo);
        $mother->update($motherInfo);

        if ($guardian != null) {
            if($validated['guardianLast'] != null) {
                $guardian->update($guardianInfo);
            }
        } else {
            if($validated['guardianLast'] != null) {
                $guardianInfo['applicant_id'] = $applicantId;
                ApplicantGuardianInformation::create($guardianInfo);
            }
        }

        $school->update($schoolInfo);

        return redirect()->route('applicant.page', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]);
    }
}
