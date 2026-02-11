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
Route::get('/cadastro-membro', [MemberRegistrationController::class, 'showTokenForm'])->name('member.token-form');
Route::post('/cadastro-membro/validar-token', [MemberRegistrationController::class, 'validateToken'])->name('member.validate-token');
Route::get('/cadastro-membro/formulario', [MemberRegistrationController::class, 'create'])->name('member.register');
Route::post('/cadastro-membro/formulario', [MemberRegistrationController::class, 'store'])->name('member.store');
Route::get('/cadastro-membro/sucesso/{id}', [MemberRegistrationController::class, 'success'])->name('member.success');
Route::get('/cadastro-membro/download-pdf/{id}', [MemberRegistrationController::class, 'downloadPdf'])->name('member.download-pdf');
Route::post('/cadastro-membro/check-cpf', [MemberRegistrationController::class, 'checkCpf'])->name('member.check-cpf');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes - Editor and Admin can access these
Route::middleware(['auth', 'verified', 'editor'])->prefix('admin')->name('admin.')->group(function () {
    Route::middleware('editor:pages')->group(function () {
        Route::resource('pages', PageController::class);
    });
    
    Route::middleware('editor:articles')->group(function () {
        Route::resource('articles', ArticleController::class);
    });
    
    Route::middleware('editor:prayer-intentions')->group(function () {
        Route::resource('prayer-intentions', PrayerIntentionController::class);
    });
    
    Route::middleware('editor:events')->group(function () {
        Route::resource('events', EventController::class);
    });
    
    Route::middleware('editor:media-gallery')->group(function () {
        Route::resource('media-gallery', MediaGalleryController::class);
    });
    
    Route::middleware('editor:categories')->group(function () {
        Route::resource('categories', CategoryController::class);
    });
    
    Route::middleware('editor:member-registrations')->group(function () {
        Route::resource('member-registrations', AdminMemberRegistrationController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
        Route::get('member-registrations-export-pdf', [AdminMemberRegistrationController::class, 'exportPdf'])->name('member-registrations.export-pdf');
    });
});

// Admin-only routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('sliders', SliderController::class);
    Route::resource('feature-cards', FeatureCardController::class);
    Route::resource('homepage-sections', App\Http\Controllers\Admin\HomepageSectionController::class);
    
    // Registration Tokens - Admin only
    Route::resource('registration-tokens', App\Http\Controllers\Admin\RegistrationTokenController::class);
    
    // Storage Settings
    Route::get('storage-settings', [App\Http\Controllers\Admin\StorageSettingsController::class, 'index'])->name('storage-settings.index');
    Route::put('storage-settings', [App\Http\Controllers\Admin\StorageSettingsController::class, 'update'])->name('storage-settings.update');
    Route::post('storage-settings/test', [App\Http\Controllers\Admin\StorageSettingsController::class, 'test'])->name('storage-settings.test');
    
    // API Settings
    Route::get('api-settings', [App\Http\Controllers\Admin\ApiSettingsController::class, 'index'])->name('api-settings.index');
    
    // Site Settings
    Route::get('site-settings', [App\Http\Controllers\Admin\SiteSettingsController::class, 'index'])->name('site-settings.index');
    Route::post('site-settings', [App\Http\Controllers\Admin\SiteSettingsController::class, 'update'])->name('site-settings.update');
    Route::delete('site-settings/logo', [App\Http\Controllers\Admin\SiteSettingsController::class, 'deleteLogo'])->name('site-settings.delete-logo');
    
    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});

require __DIR__.'/auth.php';
