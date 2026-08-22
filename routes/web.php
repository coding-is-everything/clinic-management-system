<?php

use App\Http\Controllers\AccessRestrictedController;
use App\Http\Controllers\Admin\PlatformOverviewController;
use App\Http\Controllers\ClinicsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\ModulePlaceholderController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\OtpVerificationController;
use App\Http\Controllers\Teams\TeamInvitationController;
use App\Http\Middleware\EnsureSuperAdmin;
use App\Http\Middleware\EnsureTeamMembership;
use App\Support\ClinicModules;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => auth()->check() ? redirect(config('fortify.home')) : redirect()->route('login'))->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('verify-otp', [OtpVerificationController::class, 'show'])->name('otp.verify');
    Route::post('verify-otp', [OtpVerificationController::class, 'verify'])->name('otp.verify.store');
    Route::post('verify-otp/resend', [OtpVerificationController::class, 'resend'])->name('otp.resend');
    Route::get('verify-otp/cancel', [OtpVerificationController::class, 'cancel'])->name('otp.cancel');

    Route::get('access-restricted', [AccessRestrictedController::class, 'show'])->name('access-restricted.show');
    Route::get('access-restricted/exit', [AccessRestrictedController::class, 'exit'])->name('access-restricted.exit');

    Route::get('onboarding', [OnboardingController::class, 'show'])->name('onboarding.show');
    Route::post('onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
    Route::get('onboarding/setup', [OnboardingController::class, 'next'])->name('onboarding.next');
});

Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');

        Route::get('clinics', [ClinicsController::class, 'index'])->name('clinics.index');
        Route::post('clinics', [ClinicsController::class, 'store'])->name('clinics.store');
        Route::patch('clinics/{clinic}', [ClinicsController::class, 'update'])->name('clinics.update');

        Route::get('search', GlobalSearchController::class)->name('search');

        Route::get('{module}', ModulePlaceholderController::class)
            ->name('modules.show')
            ->where('module', implode('|', array_map('preg_quote', ClinicModules::keys())));
    });

Route::middleware(['auth'])->group(function () {
    Route::post('invitations/{invitation}/accept', [TeamInvitationController::class, 'accept'])->name('invitations.accept');
    Route::delete('invitations/{invitation}', [TeamInvitationController::class, 'decline'])->name('invitations.decline');
});

Route::prefix('admin')
    ->middleware(['auth', 'verified', EnsureSuperAdmin::class])
    ->name('admin.')
    ->group(function () {
        Route::get('/', PlatformOverviewController::class)->name('overview');
    });

require __DIR__.'/settings.php';
