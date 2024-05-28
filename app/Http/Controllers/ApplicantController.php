<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ApplicantPersonalInformation;
use App\Models\ApplicantSchoolInformation;
use App\Models\ApplicantSelectionInformation;
use App\Models\DocumentALS;
use App\Models\DocumentOLD;
use App\Models\DocumentSHS;
use App\Models\DocumentTRANSFER;
use App\Models\CourseModel;
use App\Models\ApplicantLoginCreds;
use App\Models\ApplicationForm;
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
            ->setIncludePath('C:\Program Files\nodejs')
            ->format('A4')
            ->pdf();

        return response()->download($pdf);
    }
}
