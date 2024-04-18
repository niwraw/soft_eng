<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdmissionPageController;
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

require __DIR__.'/auth.php';

Route::get('/admission/{currentRoute}', [AdmissionPageController::class, 'AdmissionDashboard'])->name('admin.page');

Route::get('/admin/admission/restore', [ActionController::class, 'restore'])->name('admin.restore');
Route::get('/admin/admission/archive', [ActionController::class, 'archive'])->name('admin.archive');
Route::get('/admin/admission/delete', [ActionController::class, 'delete'])->name('admin.delete');