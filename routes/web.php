<?php

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
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\BookSubmissionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AdminKomentarController;
use App\Http\Controllers\PembayaranAdminController;
use App\Http\Controllers\KelolaRiwayatBacaController;
use App\Http\Middleware\AdminOnly;

/*
|--------------------------------------------------------------------------
| AUTH PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| CONTACT & ABOUT (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');
Route::get('/about-us', [AboutController::class, 'index'])->name('about.index');

/*
|--------------------------------------------------------------------------
| ROUTES DENGAN AUTH (USER & ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ===================== PROFILE =====================
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete');


    // ===================== GENRE USER =====================
    Route::get('/genre', [GenreUserController::class, 'index'])->name('genre.index');

    // ===================== FULL BACAAN =====================
    Route::get('/buku/{id}/{page?}', [FullBacaanController::class, 'show'])->name('book.show');
    Route::get('/full-bacaan/{id}', [FullBacaanController::class, 'show'])->name('fullbacaan.show');

    // ===================== FAVORIT =====================
    Route::get('/buku-favorit', [BukuFavoritController::class, 'index'])->name('favorite.index');
    Route::post('/buku-favorit/tambah', [BukuFavoritController::class, 'tambah'])->name('favorite.tambah');
    Route::post('/buku-favorit/hapus', [BukuFavoritController::class, 'hapus'])->name('favorite.hapus');

    // ===================== REWARD =====================
    Route::get('/reward', [RewardController::class, 'index'])->name('reward.index');

    // ===================== PEMBAYARAN USER =====================
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/proses', [PembayaranController::class, 'proses'])->name('pembayaran.proses');

    // ===================== RIWAYAT BACA USER =====================
    Route::get('/riwayat-baca', [ReadingHistoryController::class, 'index'])->name('reading.history');
    Route::delete('/riwayat-baca/{id}', [ReadingHistoryController::class, 'destroy'])->name('reading.history.delete');

    // ===================== FORUM USER =====================
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/topik/{id}', [ForumController::class, 'detail'])->name('forum.detail');
    Route::get('/forum/create/{genre_id}', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum/store', [ForumController::class, 'store'])->name('forum.store');
    Route::post('/forum/comment', [ForumController::class, 'comment'])->name('forum.comment');

    // ===================== KOMENTAR USER =====================
    Route::get('/books/{book}/page/{page}/komentar', [KomentarController::class, 'index']);
    Route::post('/komentar/simpan', [KomentarController::class, 'simpan']);
    Route::get('/komentar/edit/{id}', [KomentarController::class, 'edit'])->name('komentar.edit');
    Route::post('/komentar/update/{id}', [KomentarController::class, 'update'])->name('komentar.update');
    Route::post('/komentar/hapus/{id}', [KomentarController::class, 'hapus'])->name('komentar.hapus');

    // ===================== ULASAN =====================
    Route::get('/ulasan/{id}', [FullBacaanController::class, 'ulasan'])->name('ulasan.index');
    Route::post('/ulasan/{id}', [FullBacaanController::class, 'storeReview'])->name('ulasan.store');

    // ===================== USER TULIS BUKU =====================
    Route::get('/tulis-buku', [BookSubmissionController::class, 'create']);
    Route::post('/tulis-buku/store', [BookSubmissionController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN AREA (AUTH + ADMIN ONLY)
    |--------------------------------------------------------------------------
    */
    Route::middleware(AdminOnly::class)
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/', [AdminController::class, 'index'])->name('dashboard');

            // ===================== PEMBAYARAN ADMIN =====================
            Route::get('/pembayaran', [PembayaranAdminController::class, 'index'])
                ->name('pembayaran.index');

            // ===================== KELOLA RIWAYAT BACA (ADMIN) =====================
            Route::prefix('riwayat-baca')->name('kelolariwayat.')->group(function () {
                Route::get('/', [KelolaRiwayatBacaController::class, 'index'])->name('index');
                Route::get('/create', [KelolaRiwayatBacaController::class, 'create'])->name('create');
                Route::post('/', [KelolaRiwayatBacaController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [KelolaRiwayatBacaController::class, 'edit'])->name('edit');
                Route::post('/{id}', [KelolaRiwayatBacaController::class, 'update'])->name('update');
                Route::delete('/{id}', [KelolaRiwayatBacaController::class, 'destroy'])->name('destroy');
            });

            // KELOLA USER
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
            Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

            // KELOLA REVIEW
            Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
            Route::get('/reviews/{id}', [AdminReviewController::class, 'show'])->name('reviews.show');
            Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

            // KELOLA FORUM
            Route::get('/forum', [AdminForumController::class, 'index'])->name('forum.index');
            Route::get('/forum/{id}', [AdminForumController::class, 'detail'])->name('forum.detail');
            Route::get('/forum/{id}/delete', [AdminForumController::class, 'destroy'])->name('forum.destroy');
            Route::get('/forum/topik/{id}/delete', [AdminForumController::class, 'hapusTopik'])->name('forum.topik.hapus');
            Route::get('/forum/komentar/{id}/delete', [AdminForumController::class, 'hapusKomentar'])->name('forum.komentar.hapus');

            // GENRE & BUKU
            Route::get('/genre', [GenreAdminController::class, 'index'])->name('genre.index');
            Route::get('/books/create', [GenreAdminController::class, 'create'])->name('books.create');
            Route::post('/books/store', [GenreAdminController::class, 'store'])->name('books.store');
            Route::get('/books/{id}/edit', [GenreAdminController::class, 'edit'])->name('books.edit');
            Route::post('/books/{id}/update', [GenreAdminController::class, 'update'])->name('books.update');
            Route::post('/books/delete', [GenreAdminController::class, 'destroy'])->name('books.delete');

            // VALIDASI BUKU
            Route::get('/validasi', [BookSubmissionController::class, 'indexAdmin'])->name('validasi.index');
            Route::post('/validasi/{id}/approve', [BookSubmissionController::class, 'approve'])->name('validasi.approve');
            Route::post('/validasi/{id}/reject', [BookSubmissionController::class, 'reject'])->name('validasi.reject');

            // KOMENTAR ADMIN
            Route::get('/komentar', [AdminKomentarController::class, 'index'])->name('komentar');
            Route::post('/komentar/hapus/{id}', [AdminKomentarController::class, 'hapus'])->name('komentar.hapus');
        });
});
