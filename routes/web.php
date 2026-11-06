<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\GalleryPublicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewsPublicController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectPublicController;
use Illuminate\Support\Facades\Route;

// ---------- Publik ----------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [PageController::class, 'profile'])->name('profil');
Route::get('/kontak', [PageController::class, 'contact'])->name('kontak');
Route::get('/cari', [PageController::class, 'search'])->name('cari');            // UC-07
Route::get('/berita', [NewsPublicController::class, 'index'])->name('berita');
Route::get('/berita/{slug}', [NewsPublicController::class, 'show'])->name('berita.show');
Route::get('/berita/{slug}/lampiran', [NewsPublicController::class, 'attachment'])->name('berita.lampiran');
Route::get('/portofolio', [ProjectPublicController::class, 'index'])->name('portofolio');
Route::get('/portofolio/{id}/unduh', [ProjectPublicController::class, 'download'])->whereNumber('id')->name('portofolio.unduh');
Route::get('/galeri', [GalleryPublicController::class, 'index'])->name('galeri');
Route::get('/media/{id}', [MediaController::class, 'show'])->whereNumber('id')->name('media');
Route::get('/bahasa/{lang}', LocaleController::class)->whereIn('lang', ['id', 'en'])->name('bahasa'); // UC-08

// ---------- API ----------
Route::prefix('api/v1')->middleware('throttle:60,1')->group(function () {
    Route::get('content', [ApiController::class, 'content']);   // ?sdg=7
    Route::get('search', [ApiController::class, 'search']);     // ?q=
});

// ---------- Admin ----------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:20,1')->name('login.post');

    Route::middleware('admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');   // UC-09
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('profil', [ProfileController::class, 'edit'])->name('profil');
        Route::put('profil', [ProfileController::class, 'update'])->name('profil.update');
        Route::post('pengurus', [ProfileController::class, 'storeMember'])->name('pengurus.store');
        Route::put('pengurus/{id}', [ProfileController::class, 'updateMember'])->name('pengurus.update');
        Route::delete('pengurus/{id}', [ProfileController::class, 'destroyMember'])->name('pengurus.destroy');

        Route::get('berita', [NewsController::class, 'index'])->name('berita');
        Route::get('berita/baru', [NewsController::class, 'create'])->name('berita.create');
        Route::post('berita', [NewsController::class, 'store'])->name('berita.store');
        Route::get('berita/{id}/ubah', [NewsController::class, 'edit'])->name('berita.edit');
        Route::put('berita/{id}', [NewsController::class, 'update'])->name('berita.update');
        Route::post('berita/{id}/unpublish', [NewsController::class, 'unpublish'])->name('berita.unpublish');
        Route::delete('berita/{id}', [NewsController::class, 'destroy'])->name('berita.destroy');

        Route::get('proyek', [ProjectController::class, 'index'])->name('proyek');
        Route::get('proyek/baru', [ProjectController::class, 'create'])->name('proyek.create');
        Route::post('proyek', [ProjectController::class, 'store'])->name('proyek.store');
        Route::get('proyek/{id}/ubah', [ProjectController::class, 'edit'])->name('proyek.edit');
        Route::put('proyek/{id}', [ProjectController::class, 'update'])->name('proyek.update');
        Route::delete('proyek/{id}', [ProjectController::class, 'destroy'])->name('proyek.destroy');

        Route::get('galeri', [GalleryController::class, 'index'])->name('galeri');
        Route::post('galeri', [GalleryController::class, 'storeAlbum'])->name('galeri.store');
        Route::post('galeri/{id}/media', [GalleryController::class, 'upload'])->name('galeri.upload');
        Route::delete('galeri/{id}', [GalleryController::class, 'destroyAlbum'])->name('galeri.destroy');
        Route::delete('media/{id}', [GalleryController::class, 'destroyMedia'])->name('media.destroy');
    });
});
