<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\MainSiteController\AboutUsController;
use App\Http\Controllers\MainSiteController\ContactController;
use App\Http\Controllers\MainSiteController\DonationController;
use App\Http\Controllers\MainSiteController\HomepageController;
use App\Http\Controllers\MainSiteController\TakeSurveyController;
use App\Http\Controllers\SignUpController;

Route::get('/', [HomepageController::class, 'index'])->name('home.page');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about.page');
Route::get('/donation', [DonationController::class, 'index'])->name('donation.page');
Route::get('/survey', [TakeSurveyController::class, 'index'])->name('survey.page');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.page');
Route::post('/send-message', [ContactController::class, 'createmessage'])->name('send.message');

// Custom student login page route
Route::get('/login', [StudentLoginController::class, 'showLoginForm'])->name('student.login');
Route::post('/login', [StudentLoginController::class, 'login'])->name('login');
Route::get('/logout', [StudentDashboardController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('student-dashboard.layouts.sign-up'); // This will return the view located at resources/views/auth/register.blade.php
});
Route::post('/send-register', [SignUpController::class, 'store'])->name('register');

Route::middleware(['auth:student'])->group(function () {
    Route::get('/survey', [TakeSurveyController::class, 'index'])->name('survey.page');
    Route::post('/survey/send', [TakeSurveyController::class, 'storeSurvey'])->name('send.survey');
});

use App\Filament\Resources\AccountSettingResource\Pages\EditAccountSetting;

Route::get('/admin/account-settings/{record}/edit', [EditAccountSetting::class, '__invoke'])
    ->name('filament.resources.account-settings.edit');
