<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdmissionPageController;
use App\Http\Controllers\ApplicantController;

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

Route::view('/', 'welcome')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::middleware('guest')->group(function () {
    Route::get('apply', [ApplicationController::class, 'create'])
    ->name('apply');

    Route::post('apply', [ApplicationController::class, 'store'])->name('apply.post');
});

Route::get('/get-provinces/{regionCode}', [ProvinceController::class, 'getProvinces']);
Route::get('/get-cities/{provinceCode}', [CityController::class, 'getCities']);
Route::get('/get-barangays/{cityCode}', [BarangayController::class, 'getBarangays']);

Route::post('/login', [LoginController::class, 'store'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/admin/{currentRoute}', [AdmissionPageController::class, 'AdmissionDashboard'])->middleware('auth:admin')->where('currentRoute', 'dashboard|applicants|exam|attendance|result')->name('admin.page');

Route::get('/applicant/dashboard', function () {
    $routeSegment = request()->segment(1);
    return view('pages.applicant.dashboard', compact('routeSegment'));
})->name('user.dashboard');