<?php

use Illuminate\Support\Facades\Route;

// Public Controllers
use App\Http\Controllers\Public\BerandaController;
use App\Http\Controllers\Public\ProfilController;
use App\Http\Controllers\Public\BeritaController;
use App\Http\Controllers\Public\UmkmController;
use App\Http\Controllers\Public\GaleriController;
use App\Http\Controllers\Public\KukertaController;

// Auth Controller
use App\Http\Controllers\Auth\LoginController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KeluargaController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\UmkmController as AdminUmkmController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\KukertaController as AdminKukertaController;
use App\Http\Controllers\Admin\PengaturanController;

/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
| Route yang dapat diakses oleh masyarakat umum tanpa autentikasi.
*/

Route::name('public.')->group(function () {
    Route::get('/', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

    Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
    Route::get('/umkm/{umkm}', [UmkmController::class, 'show'])->name('umkm.show');

    Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');

    Route::get('/kukerta', [KukertaController::class, 'index'])->name('kukerta.index');
    Route::get('/kukerta/{slug}', [KukertaController::class, 'show'])->name('kukerta.show');
});

/*
|--------------------------------------------------------------------------
| Autentikasi Admin
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard Admin
|--------------------------------------------------------------------------
| Route yang dilindungi middleware 'admin'. Hanya dapat diakses
| oleh administrator yang sudah terautentikasi.
*/

Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {

    // Dashboard Utama
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ── Manajemen Kependudukan ──────────────────────────────────────
    Route::resource('keluarga', KeluargaController::class);
    Route::resource('warga', WargaController::class);
    Route::get('warga-import', [WargaController::class, 'showImport'])->name('warga.import');
    Route::post('warga-import', [WargaController::class, 'import'])->name('warga.import.store');
    Route::get('warga-download-template', [WargaController::class, 'downloadTemplate'])->name('warga.download-template');
    Route::get('warga-export', [WargaController::class, 'export'])->name('warga.export');

    // ── Manajemen Konten ────────────────────────────────────────────
    Route::patch('berita/{beritum}/publish', [AdminBeritaController::class, 'publish'])->name('berita.publish');
    Route::resource('berita', AdminBeritaController::class);
    Route::resource('umkm', AdminUmkmController::class);
    Route::resource('galeri', AdminGaleriController::class)->except(['show']);

    // ── KuKerTa ─────────────────────────────────────────────────────
    Route::patch('kukerta/{kukertum}/publish', [AdminKukertaController::class, 'publish'])->name('kukerta.publish');
    Route::resource('kukerta', AdminKukertaController::class)->except(['show']);

    // ── Pengaturan ──────────────────────────────────────────────────
    Route::get('pengaturan/profil', [PengaturanController::class, 'profil'])->name('pengaturan.profil');
    Route::put('pengaturan/profil', [PengaturanController::class, 'updateProfil'])->name('pengaturan.profil.update');

    Route::get('pengaturan/visi-misi', [PengaturanController::class, 'visiMisi'])->name('pengaturan.visi-misi');
    Route::put('pengaturan/visi-misi', [PengaturanController::class, 'updateVisiMisi'])->name('pengaturan.visi-misi.update');

    Route::get('pengaturan/struktur', [PengaturanController::class, 'struktur'])->name('pengaturan.struktur');
    Route::put('pengaturan/struktur', [PengaturanController::class, 'updateStruktur'])->name('pengaturan.struktur.update');



    Route::get('pengaturan/akun', [PengaturanController::class, 'akun'])->name('pengaturan.akun');
    Route::put('pengaturan/akun', [PengaturanController::class, 'updateAkun'])->name('pengaturan.akun.update');
});
