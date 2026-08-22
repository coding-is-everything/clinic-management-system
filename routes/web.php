<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OtpVerificationController;
use App\Http\Controllers\Teams\TeamInvitationController;
use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => auth()->check() ? redirect(config('fortify.home')) : redirect()->route('login'))->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('verify-otp', [OtpVerificationController::class, 'show'])->name('otp.verify');
    Route::post('verify-otp', [OtpVerificationController::class, 'verify'])->name('otp.verify.store');
    Route::post('verify-otp/resend', [OtpVerificationController::class, 'resend'])->name('otp.resend');
    Route::get('verify-otp/cancel', [OtpVerificationController::class, 'cancel'])->name('otp.cancel');
});

Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');
    });

Route::middleware(['auth'])->group(function () {
    Route::post('invitations/{invitation}/accept', [TeamInvitationController::class, 'accept'])->name('invitations.accept');
    Route::delete('invitations/{invitation}', [TeamInvitationController::class, 'decline'])->name('invitations.decline');
});

require __DIR__.'/settings.php';
