<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SantriController;
use App\Http\Controllers\Dashboard\PembayaranController;
use App\Http\Controllers\Dashboard\JenisPembayaranController;
use App\Http\Controllers\Dashboard\RapotController;
use App\Http\Controllers\Dashboard\AkunController;
use App\Http\Controllers\Base\PendaftaranController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return view('pages.landing');
})->name('landing');

Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'authenticate'])->name('login.process');

Route::get('/auth/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth/register', [AuthController::class, 'registerProcess'])->name('register.process');

Route::get('/auth/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/auth/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/auth/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Calon santri (wajib login)
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('pages.base.home');
    })->name('home');

    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])
        ->name('pendaftaran');

    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])
    ->name('pendaftaran.store');

    Route::get('/profile', function () {
        return view('pages.profile.index');
    })->name('profile');

    Route::post('/auth/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('landing');
    })->name('logout');
});

// Admin only
Route::middleware(['auth', 'role:admin'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('index');

        Route::get('/santri', [SantriController::class, 'index'])
            ->name('santri.index');

        Route::post('/santri/{id}/verify', [SantriController::class, 'verify'])
            ->name('santri.verify');

        Route::post('/santri/{id}/reject', [SantriController::class, 'reject'])
            ->name('santri.reject');

        Route::get('/pembayaran', [PembayaranController::class, 'index'])
            ->name('pembayaran.index');

        Route::get('/pembayaran/create', [PembayaranController::class, 'create'])
            ->name('pembayaran.create');

        Route::post('/pembayaran', [PembayaranController::class, 'store'])
            ->name('pembayaran.store');

        Route::resource(
            'jenis-pembayaran',
            JenisPembayaranController::class
        )->except(['show', 'edit', 'create']);

        Route::get('/rapot', [RapotController::class, 'index'])
            ->name('rapot.index');

        Route::get('/akun', [AkunController::class, 'index'])
            ->name('akun.index');
    });
