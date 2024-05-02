<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdmissionPageController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\WelcomePageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/home');
Route::redirect('/logout', '/home');

Route::get('/{currentRoute}', [WelcomePageController::class, 'index'])->name('welcome.page')->defaults('currentRoute', 'home');

require __DIR__.'/auth.php';

Route::middleware('guest')->group(function () {
    Route::get('/applicant/apply', [ApplicationController::class, 'create'])
    ->name('apply');

    Route::post('/applicant/apply', [ApplicationController::class, 'store'])->name('apply.post');
});

Route::get('/get-provinces/{regionCode}', [ProvinceController::class, 'getProvinces']);
Route::get('/get-cities/{provinceCode}', [CityController::class, 'getCities']);
Route::get('/get-barangays/{cityCode}', [BarangayController::class, 'getBarangays']);

Route::post('/applicant/login', [LoginController::class, 'store'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/admin/{currentRoute}', [AdmissionPageController::class, 'AdmissionDashboard'])->name('admin.page');

Route::get('/applicant/{currentRoute}/{applicantId}',[ApplicantController::class, 'ApplicantPage'])->name('applicant.page');

Route::get('/admin/admission/restore', [ActionController::class, 'restore'])->name('admin.restore');
Route::get('/admin/admission/archive', [ActionController::class, 'archive'])->name('admin.archive');
Route::get('/admin/admission/delete', [ActionController::class, 'delete'])->name('admin.delete');