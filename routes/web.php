<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    KaryawanController,
    AdminController,
    KaryawanDashboardController,
    CutiController
};
use App\Http\Controllers\Auth\KaryawanAuthController;
use App\Http\Middleware\{AdminMiddleware, KaryawanMiddleware};

// Welcome Route
Route::get('/', function () {
    return view('welcome');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    // Authentication Routes
    Route::controller(KaryawanAuthController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login')->name('login.post');
        Route::get('register', 'showRegisterForm')->name('register');
        Route::post('register', 'register')->name('register.post');
    });
});

// Auth Routes
Route::middleware('auth')->group(function () {
    // Logout Route
    Route::post('logout', [KaryawanAuthController::class, 'logout'])->name('logout');

    // Profile Routes
    Route::controller(KaryawanController::class)->group(function () {
        Route::get('/profile', 'editProfile')->name('karyawan.profile');
        Route::put('/profile', 'updateProfile')->name('karyawan.profile.update');
    });
});

// Admin Routes
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Cuti Management
        Route::controller(AdminController::class)->prefix('cuti')->name('cuti.')->group(function () {
            Route::get('/', 'dashboard')->name('index');
            Route::get('/{cuti}', 'cutiShow')->name('show');
            Route::post('/{cuti}/approve', 'cutiApprove')->name('approve');
            Route::post('/{cuti}/reject', 'cutiReject')->name('reject');
        });

        // Karyawan Management
        Route::controller(AdminController::class)->group(function () {
            Route::get('/add-email', 'showAddEmailForm')->name('add-email');
            Route::post('/store-email', 'storeEmail')->name('store-email');
            Route::get('/karyawan/{karyawan}', 'show')->name('karyawan.show');
            Route::put('/karyawan/{karyawan}', 'updateKaryawan')->name('update-karyawan');
            Route::delete('/karyawan/{karyawan}', 'deleteKaryawan')->name('delete-karyawan');
        });

        // Jabatan Management
        Route::controller(AdminController::class)->prefix('jabatan')->name('jabatan.')->group(function () {
            Route::get('/', 'jabatanIndex')->name('index');
            Route::post('/', 'jabatanStore')->name('store');
            Route::put('/{jabatan}', 'jabatanUpdate')->name('update');
            Route::delete('/{jabatan}', 'jabatanDestroy')->name('destroy');
        });
    });

// Karyawan Routes
Route::middleware(['auth', KaryawanMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/karyawan/dashboard', [KaryawanDashboardController::class, 'dashboard'])
        ->name('karyawan.dashboard');

    // Cuti Management
    Route::controller(CutiController::class)->prefix('cuti')->name('cuti.')->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{cuti}', 'show')->name('show');
        Route::delete('/{cuti}', 'destroy')->name('destroy'); // Move this inside the group
    });
});

// Access Denied Route
Route::get('/access-denied', function () {
    return view('access-denied');
})->name('access.denied');
