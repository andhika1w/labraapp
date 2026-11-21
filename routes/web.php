<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MahasiswaController as AdminMahasiswaController;

Route::get('/', function () {
    return redirect('/login');
});

// ==== AUTH ROUTES ====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==== SHARED AUTH ROUTES (PROFILE) ====
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.update_password');
    Route::get('/admin/profil', fn() => redirect('/profil'));
});

// ==== USER (MAHASISWA) ROUTES ====
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/pengaduan/riwayat', [UserReportController::class, 'index'])->name('user.reports.index');
    Route::get('/pengaduan/buat', [UserReportController::class, 'create'])->name('user.reports.create');
    Route::post('/pengaduan/buat', [UserReportController::class, 'store'])->name('user.reports.store');
    Route::get('/pengaduan/detail/{id}', [UserReportController::class, 'show'])->name('user.reports.show');
});

// ==== ADMIN ROUTES ====
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengaduan', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/pengaduan/detail/{id}', [AdminReportController::class, 'show'])->name('reports.show');
    Route::post('/pengaduan/detail/{id}/status', [AdminReportController::class, 'updateStatus'])->name('reports.update_status');

    // Statistik Sarpras
    Route::get('/statistik', [AdminDashboardController::class, 'statistik'])->name('statistik');

    // Kategori
    Route::get('/kategori', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/kategori/tambah', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/kategori/tambah', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/kategori/edit/{category}', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/kategori/edit/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::post('/kategori/hapus/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Mahasiswa
    Route::get('/mahasiswa', [AdminMahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/mahasiswa/tambah', [AdminMahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('/mahasiswa/tambah', [AdminMahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::get('/mahasiswa/edit/{user}', [AdminMahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::post('/mahasiswa/edit/{user}', [AdminMahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::post('/mahasiswa/hapus/{user}', [AdminMahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
});
