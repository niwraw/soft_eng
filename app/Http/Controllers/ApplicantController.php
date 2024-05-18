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
use Org_Heigl\Ghostscript\Ghostscript;
use Spatie\PdfToImage\Pdf;
use Barryvdh\DomPDF\Facade\Pdf as gen;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

        $routeSegment = request()->segment(1);
        return view('pages.applicant.applicant', compact('currentRoute', 'routeSegment', 'personalInfo', 'selectionInfo', 'schoolInfo', 'document', 'applicantId'));
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
            ]
        ]);

        $personalInfo = ApplicantPersonalInformation::where('applicant_id', $applicantId)->first();

        $file = $request->file('form137');
        $extension = $file->getClientOriginalExtension();

        $form = $applicantId . '_Form137.' . $extension;
        $pathCert = 'uploads/Form_137/';

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
        $personalInfo = ApplicantPersonalInformation::where('applicant_id', $applicantId)->first();

        $data = [
            'title' => 'Application_Form',
            'age' => 20,
        ];

        $pdf = gen::loadView('documents.applicationform', $data);
        return $pdf->download('application.pdf');
    }
}
