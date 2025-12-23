<?php

use App\Http\Controllers\Admin\AdminRewardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuFavoritController;
use App\Http\Controllers\FullBacaanController;
use App\Http\Controllers\GenreUserController;
use App\Http\Controllers\GenreAdminController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminForumController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\ReadingHistoryController;
use App\Http\Controllers\KelolaRiwayatBacaController;
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\BookSubmissionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AdminKomentarController;


// =====================================================
// AUTH PUBLIC
// =====================================================
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =====================================================
// CONTACT & ABOUT (PUBLIC)
// =====================================================
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

Route::get('/about-us', [AboutController::class, 'index'])->name('about.index');


// =====================================================
// ROUTES DENGAN AUTH
// =====================================================
Route::middleware('auth')->group(function () {

    // =====================================================
    // PROFILE USER
    // =====================================================
    Route::get('/profile/create', [ProfileController::class, 'create']);
    Route::post('/profile/store', [ProfileController::class, 'store']);
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/delete/{id}', [ProfileController::class, 'delete'])->name('profile.delete');


    // =====================================================
    // GENRE USER
    // =====================================================
    Route::get('/genre', [GenreUserController::class, 'index'])->name('genre.index');


    // =====================================================
    // FULL BACAAN
    // =====================================================
    Route::get('/buku/{id}/{page?}', [FullBacaanController::class, 'show'])->name('book.show');
    Route::get('/full-bacaan/{id}', [FullBacaanController::class, 'show'])->name('fullbacaan.show');


    // =====================================================
    // FAVORIT USER
    // =====================================================
     Route::get('/buku-favorit', [BukuFavoritController::class, 'index'])->name('favorite.index');
    Route::post('/buku-favorit/tambah', [BukuFavoritController::class, 'tambah'])->name('favorite.tambah');
    Route::post('/buku-favorit/hapus', [BukuFavoritController::class, 'hapus'])->name('favorite.hapus');

    // =====================================================
    // REWARD USER
    // =====================================================
Route::get('/reward', [RewardController::class, 'index'])->name('reward.index');



    // =====================================================
    // PEMBAYARAN / BELI POIN (USER)
    // =====================================================
    Route::get('/pembayaran', [PembayaranController::class, 'index'])
        ->name('pembayaran.index');

    Route::post('/pembayaran/proses', [PembayaranController::class, 'proses'])
        ->name('pembayaran.proses');


    // =====================================================
    // USER READING HISTORY
    // =====================================================
    Route::get('/riwayat-baca', [ReadingHistoryController::class, 'index'])->name('reading.history');
    Route::delete('/riwayat-baca/{id}', [ReadingHistoryController::class, 'destroy'])->name('reading.history.delete');


    // =====================================================
    // FORUM USER
    // =====================================================
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/topik/{id}', [ForumController::class, 'detail'])->name('forum.detail');
    Route::get('/forum/create/{genre_id}', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum/store', [ForumController::class, 'store'])->name('forum.store');
    Route::post('/forum/comment', [ForumController::class, 'comment'])->name('forum.comment');
    Route::get('/forum/topik/{id}/edit', [ForumController::class, 'edit'])->name('forum.edit');
    Route::post('/forum/topik/{id}/update', [ForumController::class, 'update'])->name('forum.update');
    Route::get('/forum/topik/{id}/delete', [ForumController::class, 'destroy'])->name('forum.destroy');


    // =====================================================
    // KOMENTAR USER
    // =====================================================
Route::get('/books/{book}/page/{page}/komentar', [KomentarController::class, 'index']);
Route::post('/komentar/simpan', [KomentarController::class, 'simpan']);

Route::get('/komentar/edit/{id}', [KomentarController::class, 'edit'])->name('komentar.edit');
Route::post('/komentar/update/{id}', [KomentarController::class, 'update'])->name('komentar.update');
Route::post('/komentar/hapus/{id}', [KomentarController::class, 'hapus'])->name('komentar.hapus');


    // =====================================================
    // ULASAN BUKU (USER)
    // =====================================================
    Route::get('/ulasan/{id}', [FullBacaanController::class, 'ulasan'])->name('ulasan.index');
    Route::post('/ulasan/{id}', [FullBacaanController::class, 'storeReview'])->name('ulasan.store');


    // =====================================================
    // ADMIN AREA
    // =====================================================
    Route::prefix('admin')->name('admin.')->group(function () {

        // DASHBOARD
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        // LOGOUT ADMIN
        Route::post('/logout', function () {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect('/login')->with('success', 'Berhasil logout!');
        })->name('logout');


        // =====================================================
        // KELOLA USER (ADMIN)
        // =====================================================
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


        // =====================================================
        // KELOLA REVIEW
        // =====================================================
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::get('/reviews/{id}', [AdminReviewController::class, 'show'])->name('reviews.show');
        Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');


        // =====================================================
        // KELOLA FORUM ADMIN
        // =====================================================
        Route::get('/forum', [AdminForumController::class, 'index'])->name('forum.index');
        Route::get('/forum/{id}', [AdminForumController::class, 'detail'])->name('forum.detail');
        Route::get('/forum/{id}/delete', [AdminForumController::class, 'destroy'])->name('forum.destroy');
        Route::get('/forum/topik/{id}/delete', [AdminForumController::class, 'hapusTopik'])->name('forum.topik.hapus');
        Route::get('/forum/komentar/{id}/delete', [AdminForumController::class, 'hapusKomentar'])->name('forum.komentar.hapus');


        // =====================================================
        // KELOLA GENRE & BUKU ADMIN
        // =====================================================
        Route::get('/genre', [GenreAdminController::class, 'index'])->name('genre.index');
        Route::get('/books/create', [GenreAdminController::class, 'create'])->name('books.create');
        Route::post('/books/store', [GenreAdminController::class, 'store'])->name('books.store');
        Route::get('/books/{id}/edit', [GenreAdminController::class, 'edit'])->name('books.edit');
        Route::post('/books/{id}/update', [GenreAdminController::class, 'update'])->name('books.update');
        Route::post('/books/delete', [GenreAdminController::class, 'destroy'])->name('books.delete');


        // =====================================================
        // VALIDASI BUKU USER
        // =====================================================
        Route::get('/validasi', [BookSubmissionController::class, 'indexAdmin'])->name('validasi.index');
        Route::post('/validasi/{id}/approve', [BookSubmissionController::class, 'approve'])->name('validasi.approve');
        Route::post('/validasi/{id}/reject', [BookSubmissionController::class, 'reject'])->name('validasi.reject');
    });


    // =====================================================
    // KELOLA RIWAYAT BACA ADMIN
    // =====================================================
    Route::get('/kelola-riwayat', [KelolaRiwayatBacaController::class, 'index'])->name('kelolariwayat.index');
    Route::get('/kelola-riwayat/create', [KelolaRiwayatBacaController::class, 'create'])->name('kelolariwayat.create');
    Route::post('/kelola-riwayat', [KelolaRiwayatBacaController::class, 'store'])->name('kelolariwayat.store');
    Route::get('/kelola-riwayat/{id}/edit', [KelolaRiwayatBacaController::class, 'edit'])->name('kelolariwayat.edit');
    Route::put('/kelola-riwayat/{id}', [KelolaRiwayatBacaController::class, 'update'])->name('kelolariwayat.update');
    Route::delete('/kelola-riwayat/{id}', [KelolaRiwayatBacaController::class, 'destroy'])->name('kelolariwayat.delete');


       Route::get('/admin/komentar', [AdminKomentarController::class, 'index'])->name('admin.komentar');
    Route::post('/admin/komentar/hapus/{id}', [AdminKomentarController::class, 'hapus'])->name('admin.komentar.hapus');

    // =====================================================
    // USER TULIS BUKU
    // =====================================================
    Route::get('/tulis-buku', [BookSubmissionController::class, 'create']);
    Route::post('/tulis-buku/store', [BookSubmissionController::class, 'store']);

});
