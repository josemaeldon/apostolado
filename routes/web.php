<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstallerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberRegistrationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\PrayerIntentionController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\MediaGalleryController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MemberRegistrationController as AdminMemberRegistrationController;
use App\Http\Controllers\Admin\FeatureCardController;
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

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Content Pages
Route::get('/intencoes-oracao', [App\Http\Controllers\PublicController::class, 'prayerIntentions'])->name('public.prayer-intentions');
Route::get('/intencoes-oracao/{prayerIntention}', [App\Http\Controllers\PublicController::class, 'showPrayerIntention'])->name('public.prayer-intention.show');
Route::get('/artigos', [App\Http\Controllers\PublicController::class, 'articles'])->name('public.articles');
Route::get('/artigos/{article}', [App\Http\Controllers\PublicController::class, 'showArticle'])->name('public.article.show');
Route::get('/eventos', [App\Http\Controllers\PublicController::class, 'events'])->name('public.events');
Route::get('/eventos/{event}', [App\Http\Controllers\PublicController::class, 'showEvent'])->name('public.event.show');
Route::get('/galeria', [App\Http\Controllers\PublicController::class, 'mediaGallery'])->name('public.media-gallery');
Route::get('/pagina/{page:slug}', [App\Http\Controllers\PublicController::class, 'showPage'])->name('public.page.show');

// Member Registration
Route::get('/cadastro-membro', [MemberRegistrationController::class, 'create'])->name('member.register');
Route::post('/cadastro-membro', [MemberRegistrationController::class, 'store'])->name('member.store');

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
    Route::resource('sliders', SliderController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('member-registrations', AdminMemberRegistrationController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::get('member-registrations-export-pdf', [AdminMemberRegistrationController::class, 'exportPdf'])->name('member-registrations.export-pdf');
    Route::resource('feature-cards', FeatureCardController::class);
    
    // Storage Settings
    Route::get('storage-settings', [App\Http\Controllers\Admin\StorageSettingsController::class, 'index'])->name('storage-settings.index');
    Route::put('storage-settings', [App\Http\Controllers\Admin\StorageSettingsController::class, 'update'])->name('storage-settings.update');
    Route::post('storage-settings/test', [App\Http\Controllers\Admin\StorageSettingsController::class, 'test'])->name('storage-settings.test');
});

require __DIR__.'/auth.php';
