<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    AdminController,
    KaryawanController,
};
use App\Http\Controllers\Auth\KaryawanAuthController;
use App\Http\Middleware\{AdminMiddleware, KaryawanMiddleware};

// Welcome Route
// Route::get('/', function () {
//     return view('welcome');
// });

// Guest Routes
Route::middleware('guest')->group(function () {
    // Authentication Routes
    Route::controller(KaryawanAuthController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
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
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'editProfile')->name('karyawan.profile');
        Route::put('/profile', 'updateProfile')->name('karyawan.profile.update');
    });
});

//Root Route
$router->aliasMiddleware('AdminMiddleware', AdminMiddleware::class);
Route::get('/', [AdminController::class, 'dashboard'])
    ->middleware('AdminMiddleware')
    ->name('admin.dashboard');

// Admin Routes
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/calendar', [AdminController::class, 'calendar'])->name('calendar');

        // Cuti Management
        Route::controller(AdminController::class)->prefix('cuti')->name('cuti.')->group(function () {
            Route::get('/{cuti:cuti_id}', 'cutiShow')->name('show');
            Route::post('/{cuti:cuti_id}/approve', 'cutiApprove')->name('approve');
            Route::post('/{cuti:cuti_id}/reject', 'cutiReject')->name('reject');
        });

        // Karyawan Management
    Route::get('/karyawan', [AdminController::class, 'showAddEmailForm'])->name('karyawan.index');
    Route::get('/karyawan/{karyawan:karyawan_id}', [AdminController::class, 'show'])->name('karyawan.show');
    Route::post('/karyawan', [AdminController::class, 'storeEmail'])->name('store-email');
    Route::put('/karyawan/{karyawan:karyawan_id}', [AdminController::class, 'updateKaryawan'])->name('update-karyawan');
    Route::delete('/karyawan/{karyawan:karyawan_id}', [AdminController::class, 'destroyKaryawan'])->name('karyawan.destroy');

        // Jabatan Management
        Route::prefix('jabatan')->name('jabatan.')->group(function () {
            Route::get('/', [AdminController::class, 'jabatanIndex'])->name('index');
            Route::post('/', [AdminController::class, 'jabatanStore'])->name('store');
            Route::put('/{jabatan:jabatan_id}', [AdminController::class, 'jabatanUpdate'])->name('update');
            Route::delete('/{jabatan:jabatan_id}', [AdminController::class, 'jabatanDestroy'])->name('destroy');
        });
    });

// Karyawan Routes
Route::middleware(['auth', KaryawanMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/karyawan/dashboard', [KaryawanController::class, 'dashboard'])
        ->name('karyawan.dashboard');

    Route::get('/karyawan/calendar', [KaryawanController::class, 'calendar'])->name('karyawan.calendar');


    // Cuti Management
    Route::controller(KaryawanController::class)->prefix('cuti')->name('cuti.')->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/view/{cuti:cuti_id}', 'show')->name('show');
        Route::delete('/{cuti:cuti_id}', 'destroy')->name('destroy'); // Move this inside the group
    });
});

// Access Denied Route
Route::get('/access-denied', function () {
    return view('access-denied');
})->name('access.denied');
