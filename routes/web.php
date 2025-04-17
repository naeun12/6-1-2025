<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\landingPageController;
use App\Http\Middleware\AfterRegistrationMiddleware;

use App\Http\Controllers\tenant\accountprocessController;
//view landingpage and register
Route::get('/', [landingPageController::class, 'landingPage'])->name('landingpage');
Route::get('/tenantLogin', [accountprocessController::class, 'login'])->name('login-tenant');
Route::get('/tenantRegister', [accountprocessController::class, 'register'])->name('register-tenant');

//Route::get('/verify', [accountprocessController::class, 'startVerification'])->name('verify-otp');

Route::post('/verify-registration', [accountprocessController::class, 'verifyRegistration'])->name('verify.registration');


//creating tenants account

Route::match(['get', 'post'], '/SendOtp', [accountprocessController::class, 'SendOtp'])->name('SendOtp');
Route::match(['get', 'post'], '/resendOtp', [accountprocessController::class, 'resendOtp'])->name('resendOtp');


Route::match(['get', 'post'], '/registerTenant', [accountprocessController::class, 'registerTenant'])->name('registerTenant');


