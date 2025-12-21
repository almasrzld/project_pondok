<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SantriController;
use App\Http\Controllers\Dashboard\PembayaranController as DashboardPembayaranController;
use App\Http\Controllers\Dashboard\JenisPembayaranController;
use App\Http\Controllers\Dashboard\GalleryController as DashboardGalleryController;
use App\Http\Controllers\Dashboard\RapotController;
use App\Http\Controllers\Dashboard\AkunController;
use App\Http\Controllers\Base\GalleryController as BaseGalleryController;
use App\Http\Controllers\Base\PendaftaranController;
use App\Http\Controllers\Base\PembayaranController as BasePembayaranController;
use App\Http\Controllers\Base\ProfilController;
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

    Route::get('/gallery', [BaseGalleryController::class, 'index'])
    ->name('gallery');

    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])
        ->name('pendaftaran');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])
        ->name('pendaftaran.store');

    Route::get('/pembayaran', [BasePembayaranController::class, 'index'])
        ->name('pembayaran');
    Route::post('/pembayaran', [BasePembayaranController::class, 'store'])
        ->name('pembayaran.store');

    Route::get('/profile', [ProfilController::class, 'index'])
        ->name('profile.index');
    Route::get('/profile/edit', [ProfilController::class, 'edit'])
        ->name('profile.edit');
    Route::put('/profile', [ProfilController::class, 'update'])
        ->name('profile.update');

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

        Route::resource(
            'pembayaran',
            DashboardPembayaranController::class
        )->except(['show']);

        Route::get(
            '/pembayaran/{id}/download',
            [DashboardPembayaranController::class, 'download']
        )->name('pembayaran.download');

        Route::resource(
            'jenis-pembayaran',
            JenisPembayaranController::class
        )->except(['show', 'edit', 'create']);

        Route::resource('gallery', DashboardGalleryController::class)
            ->except(['show', 'create']);

        Route::get('/rapot', [RapotController::class, 'index'])
            ->name('rapot.index');

        Route::get('/akun', [AkunController::class, 'index'])
            ->name('akun.index');
    });
