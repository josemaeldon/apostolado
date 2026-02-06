<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstallerController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\PrayerIntentionController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\MediaGalleryController;
use Illuminate\Support\Facades\Route;

// Rotas do Instalador
Route::prefix('install')->name('installer.')->group(function () {
    Route::get('/', [InstallerController::class, 'welcome'])->name('welcome');
    Route::get('/requirements', [InstallerController::class, 'requirements'])->name('requirements');
    Route::get('/permissions', [InstallerController::class, 'permissions'])->name('permissions');
    Route::get('/database', [InstallerController::class, 'database'])->name('database');
    Route::post('/test-database', [InstallerController::class, 'testDatabase'])->name('test-database');
    Route::post('/save-database', [InstallerController::class, 'saveDatabase'])->name('save-database');
    Route::get('/admin', [InstallerController::class, 'admin'])->name('admin');
    Route::post('/install', [InstallerController::class, 'install'])->name('install');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('pages', PageController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('prayer-intentions', PrayerIntentionController::class);
    Route::resource('events', EventController::class);
    Route::resource('media-gallery', MediaGalleryController::class);
});

require __DIR__.'/auth.php';
