<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstallerController;
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

require __DIR__.'/auth.php';
