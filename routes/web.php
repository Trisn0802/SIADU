<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Mail;

// Redirect root ke login
Route::get('/', [LandingPageController::class, 'landingPage'])->name('landing.page');

// Fallback route - redirect semua route yang tidak terdaftar ke login
Route::fallback(function () {
    return redirect()->route('backend.login');
});

Route::get('/send-test-email', function () {
    Mail::raw('Ini adalah email test dari aplikasi SIADU.', function ($message) {
        $message->to('trisnahomie@gmail.com')
                ->from(env('MAIL_FROM_ADDRESS'))
                ->subject('Test Email dari SIADU');
    });

    return "Email telah dikirim!";
});

Route::get('backend/v_error/404', function () {
    return view('backend.v_error.error-404');
})->name('backend.error.404');

// Redirect root ke login
Route::get('backend/login', [LoginController::class, 'loginBackend'])->name('backend.login');

// Logout
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout')->middleware('auth');

// Login
Route::get('backend/login', [LoginController::class, 'loginBackend'])->name('backend.login')->middleware('guest');
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login')->middleware('guest');

// Register
Route::get('backend/register', [RegisterController::class, 'passwordDebug'])->name('backend.register')->middleware('guest');
Route::post('backend/register', [RegisterController::class, 'storeRegisterBackend'])->name('backend.register')->middleware('guest');

// Halaman user (role = 0)
Route::middleware(['auth', 'user'])->group(function () {
    // Beranda (dashboard user)
    Route::get('backend/user/beranda', [UserController::class, 'berandaUserBackend'])->name('backend.beranda.user');

    // Untuk Notifikasi
    Route::get('backend/user/notifikasi', [UserController::class, 'getNotifikasi'])->name('backend.user.getnotifikasi');
    Route::get('/user/notifikasi/unread', [UserController::class, 'countNotifikasiUnread'])->name('backend.user.countnotifikasiunread');
    Route::post('/user/notifikasi/read', [UserController::class, 'readAllNotifikasi'])->name('backend.user.readnotifikasi');
    Route::delete('/user/notifikasi/{id}', [UserController::class, 'deleteNotifikasi'])->name('backend.user.deletenotifikasi');
    Route::delete('/user/notifikasi', [UserController::class, 'deleteAllNotifikasi'])->name('backend.user.deleteallnotifikasi');

    // Edit profil untuk user
    Route::get('backend/user/profile/{id}/edit', [UserController::class, 'edit'])->name('backend.user.edit');
    Route::put('backend/user/profile/{id}', [UserController::class, 'update'])->name('backend.user.update');
    Route::get('backend/user/profile/{id}/changepassword', [UserController::class, 'gantiPassword'])->name('backend.user.gantipassword');
    Route::put('backend/user/profile/{id}/changepassword', [UserController::class, 'updatePassword'])->name('backend.user.updatepassword');

    // Halaman aduan
    Route::post('backend/user/aduan', [UserController::class, 'storeAduan'])->name('backend.user.storeaduan');
    Route::get('backend/user/riwayataduan', [UserController::class, 'riwayatAduan'])->name('backend.user.riwayataduan');
    Route::get('backend/user/aduan/{id_pengaduan}/detail', [UserController::class, 'detailAduan'])->name('backend.user.detailaduan');
    Route::post('backend/user/aduan/{id_pengaduan}/chat', [UserController::class, 'sendChat'])->name('backend.user.sendchat');
    Route::delete('backend/user/aduan/{id_pengaduan}', [UserController::class, 'destroyAduan'])->name('backend.user.aduan.destroy');

    // Halaman Tindak Lanjut (User)
    Route::get('backend/user/riwayat-tindaklanjut', [UserController::class, 'riwayatTindakLanjut'])->name('backend.user.riwayat_tindaklanjut');
    Route::get('backend/user/tindaklanjut/{id_tindak}/detail', [UserController::class, 'detailTindakLanjut'])->name('backend.user.detail_tindaklanjut');
});

// Halaman admin (role = 1)
Route::middleware(['auth', 'admin'])->group(function () {
    // Beranda (dashboard admin)
    Route::get('backend/admin/beranda', [AdminController::class, 'index'])->name('backend.beranda');

    // Notifikasi Admin
    Route::get('backend/admin/notifikasi', [AdminController::class, 'getNotifikasi'])->name('backend.admin.getnotifikasi');
    Route::get('backend/admin/notifikasi/unread', [AdminController::class, 'countNotifikasiUnread'])->name('backend.admin.countnotifikasiunread');
    Route::post('backend/admin/notifikasi/read', [AdminController::class, 'readAllNotifikasi'])->name('backend.admin.readnotifikasi');
    Route::delete('/admin/notifikasi/{id}', [AdminController::class, 'deleteNotifikasi'])->name('backend.admin.deletenotifikasi');
    Route::delete('/admin/notifikasi', [AdminController::class, 'deleteAllNotifikasi'])->name('backend.admin.deleteallnotifikasi');

    // Halaman statistik
    Route::get('backend/admin/dashboard/data', [AdminController::class, 'dashboardData'])->name('backend.admin.dashboard.data');

    // Halaman aduan admin
    Route::get('backend/admin/pengaduan', [AdminController::class, 'pengaduanList'])->name('backend.admin.pengaduan');
    Route::post('backend/admin/pengaduan/{id}/status', [AdminController::class, 'updatePengaduanStatus'])->name('backend.admin.pengaduan.status');
    Route::delete('backend/admin/pengaduan/{id_pengaduan}', [AdminController::class, 'destroyPengaduan'])->name('backend.admin.pengaduan.destroy');

    // Halaman detail aduan
    Route::get('backend/admin/pengaduan/{id}/detail', [AdminController::class, 'detailAduan'])->name('backend.admin.detailaduan');
    Route::post('backend/admin/pengaduan/{id_pengaduan}/chat', [AdminController::class, 'sendChat'])->name('backend.admin.sendchat');

    // Laporan per 1 aduan user
    Route::get('backend/admin/pengaduan/{id}/cetak', [AdminController::class, 'cetakAduan'])->name('backend.admin.pengaduan.cetak');

    // Tindak lanjut Admin
    Route::get('backend/admin/tindaklanjut', [AdminController::class, 'tindaklanjutIndex'])->name('backend.tindaklanjut.index');
    Route::get('backend/admin/tindaklanjut/create/{id_pengaduan}', [AdminController::class, 'tindaklanjutCreate'])->name('backend.tindaklanjut.create');
    Route::post('backend/admin/tindaklanjut', [AdminController::class, 'tindaklanjutStore'])->name('backend.tindaklanjut.store');

    // Tindak lanjut Petugas (Admin)
    Route::get('backend/admin/tindaklanjut/belum-selesai', [AdminController::class, 'tindaklanjutBelumSelesai'])->name('backend.admin.tindaklanjut.belumselesai');
    Route::get('backend/admin/tindaklanjut/petugas', [AdminController::class, 'tindaklanjutPetugas'])->name('backend.admin.tindaklanjut.petugas');
    Route::get('backend/admin/tindaklanjut/{id_tindak}/detail', [AdminController::class, 'detailTindakLanjut'])->name('backend.admin.detail_tindaklanjut');
    Route::delete('backend/admin/tindaklanjut/{id_tindak}', [AdminController::class, 'destroyTindakLanjut'])->name('backend.admin.tindaklanjut.destroy');

    // Resource routes
    Route::get('backend/admin/user', [AdminController::class, 'showUser'])->name('backend.user.showUser');
    Route::get('backend/admin/user/create', [AdminController::class, 'createUser'])->name('backend.user.create');
    Route::post('backend/admin/user/post', [AdminController::class, 'storeUser'])->name('backend.user.store');
    Route::post('backend/admin/user/{id}/delete', [AdminController::class, 'destroyUser'])->name('backend.user.destroy');

    // Laporan user
    Route::get('backend/admin/laporan/formuser', [AdminController::class, 'formUser'])->name('backend.laporan.formuser');
    Route::post('backend/admin/laporan/cetakuser', [AdminController::class, 'cetakUser'])->name('backend.laporan.cetakuser');

    // Edit profil untuk admin
    Route::get('backend/admin/user/{id}/edit', [AdminController::class, 'editUser'])->name('backend.admin.edit');
    Route::put('backend/admin/user/{id}', [AdminController::class, 'updateUser'])->name('backend.admin.update');
    Route::get('backend/admin/user/{id}/changepassword', [AdminController::class, 'gantiPassword'])->name('backend.admin.gantipassword');
    Route::put('backend/admin/user/{id}/changepassword', [AdminController::class, 'updatePassword'])->name('backend.admin.updatepassword');

    // CRUD Masyarakat
    Route::get('backend/admin/user/masyarakat', [AdminController::class, 'showUserMasyarakat'])->name('backend.user.masyarakat');
    Route::post('backend/admin/user/{id}/ban', [AdminController::class, 'banUser'])->name('backend.user.ban'); // Route untuk ban user

    // Form laporan
    Route::get('backend/admin/laporan/user', [AdminController::class, 'formLaporanUser'])->name('backend.laporan.user');
    Route::get('backend/admin/laporan/petugasadmin', [AdminController::class, 'formLaporanPetugasAdmin'])->name('backend.laporan.petugasadmin');
    Route::get('backend/admin/laporan/pengaduan', [AdminController::class, 'formLaporanPengaduan'])->name('backend.laporan.pengaduan');
    Route::get('backend/admin/laporan/tindaklanjut', [AdminController::class, 'formLaporanTindakLanjut'])->name(name: 'backend.laporan.tindaklanjut');

    // Cetak laporan
    Route::post('backend/admin/laporan/cetakuser', [AdminController::class, 'cetakLaporanUser'])->name('backend.laporan.cetakuser');
    Route::post('backend/admin/laporan/cetakpetugasadmin', [AdminController::class, 'cetakLaporanPetugasAdmin'])->name('backend.laporan.cetakpetugasadmin');
    Route::post('backend/admin/laporan/cetakpengaduan', [AdminController::class, 'cetakLaporanPengaduan'])->name('backend.laporan.cetakpengaduan');
    Route::post('backend/admin/laporan/cetaktindaklanjut', [AdminController::class, 'cetakLaporanTindakLanjut'])->name('backend.laporan.cetaktindaklanjut');
});

// Role petugas 2
Route::middleware(['auth', 'petugas'])->prefix('backend/petugas')->group(function() {
    // Halaman Dashboard Petugas
    Route::get('/dashboard', [PetugasController::class, 'index'])->name('backend.petugas.dashboard');
    Route::get('/dashboard/data', [PetugasController::class, 'dashboardData'])->name('backend.petugas.dashboard.data');

    // Notifikasi Petugas
    Route::get('/notifikasi', [PetugasController::class, 'getNotifikasi'])->name('backend.petugas.getnotifikasi');
    Route::get('/notifikasi/unread', [PetugasController::class, 'countNotifikasiUnread'])->name('backend.petugas.countnotifikasiunread');
    Route::post('/notifikasi/read', [PetugasController::class, 'readAllNotifikasi'])->name('backend.petugas.readnotifikasi');
    Route::delete('/notifikasi/{id}', [PetugasController::class, 'deleteNotifikasi'])->name('backend.petugas.deletenotifikasi');
    Route::delete('/notifikasi', [PetugasController::class, 'deleteAllNotifikasi'])->name('backend.petugas.deleteallnotifikasi');

    // Pengaduan Petugas
    Route::get('/pengaduan', [PetugasController::class, 'pengaduanList'])->name('backend.petugas.pengaduan');
    Route::get('/pengaduan/{id_pengaduan}/detail', [PetugasController::class, 'detailAduan'])->name('backend.petugas.detailaduan');
    Route::post('/pengaduan/{id_pengaduan}/chat', [PetugasController::class, 'sendChat'])->name('backend.petugas.sendchat');
    Route::post('/pengaduan/{id_pengaduan}/aksi', [PetugasController::class, 'aksiPengaduan'])->name('backend.petugas.aduan.aksi');

    // Tindak Lanjut Petugas
    Route::get('/tindaklanjut', [PetugasController::class, 'tindaklanjutIndex'])->name('backend.petugas.tindaklanjut');
    Route::get('/tindaklanjut/create/{id_pengaduan}', [PetugasController::class, 'tindaklanjutCreate'])->name('backend.petugas.tindaklanjut.create');
    Route::post('/tindaklanjut/store', [PetugasController::class, 'tindaklanjutStore'])->name('backend.petugas.tindaklanjut.store');
    Route::get('/tindaklanjut/{id_tindak}/detail', [PetugasController::class, 'detailTindakLanjut'])->name('backend.petugas.detail_tindaklanjut');
    Route::delete('/tindaklanjut/{id_tindak}', [PetugasController::class, 'destroyTindakLanjut'])->name('backend.petugas.tindaklanjut.destroy');

    // Edit profile petugas
    Route::get('/edit', [PetugasController::class, 'edit'])->name('backend.petugas.edit');
    Route::put('/update', [PetugasController::class, 'update'])->name('backend.petugas.update');
    Route::get('/gantipassword', [PetugasController::class, 'gantiPassword'])->name('backend.petugas.gantipassword');
    Route::put('/updatepassword', [PetugasController::class, 'updatePassword'])->name('backend.petugas.updatepassword');
});
