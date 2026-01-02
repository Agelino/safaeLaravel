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
use App\Http\Controllers\AdminRewardController;
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
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminBukuFavoritController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminNotificationController;
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
| CONTACT & ABOUT
|--------------------------------------------------------------------------
*/
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');
Route::get('/about-us', [AboutController::class, 'index'])->name('about.index');

/*
|--------------------------------------------------------------------------
| USER AREA (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete');

    // GENRE USER
    Route::get('/genre', [GenreUserController::class, 'index'])->name('genre.index');

    // BACA BUKU
    Route::get('/buku/{id}/{page?}', [FullBacaanController::class, 'show'])->name('book.show');
    Route::get('/full-bacaan/{id}', [FullBacaanController::class, 'show'])->name('fullbacaan.show');

    // FAVORIT
    Route::get('/buku-favorit', [BukuFavoritController::class, 'index'])->name('favorite.index');
    Route::post('/buku-favorit/tambah', [BukuFavoritController::class, 'tambah'])->name('favorite.tambah');
    Route::post('/buku-favorit/hapus', [BukuFavoritController::class, 'hapus'])->name('favorite.hapus');

    // REWARD
    Route::get('/reward', [RewardController::class, 'index'])->name('reward.index');

    // PEMBAYARAN
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/proses', [PembayaranController::class, 'proses'])->name('pembayaran.proses');

    // RIWAYAT BACA
    Route::get('/riwayat-baca', [ReadingHistoryController::class, 'index'])->name('reading.history');
    Route::delete('/riwayat-baca/{id}', [ReadingHistoryController::class, 'destroy'])
        ->name('reading.history.delete');

    // FORUM
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/{id}', [ForumController::class, 'detail'])->name('forum.detail');
    Route::get('/forum/create/{genre_id}', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum/store', [ForumController::class, 'store'])->name('forum.store');
    Route::post('/forum/comment', [ForumController::class, 'comment'])->name('forum.comment');
    Route::get('/forum/{id}/edit', [ForumController::class, 'edit'])->name('forum.edit');
    Route::post('/forum/{id}/update', [ForumController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{id}', [ForumController::class, 'destroy'])->name('forum.destroy');

    // KOMENTAR
    Route::post('/komentar/simpan', [KomentarController::class, 'simpan'])->name('komentar.simpan');
    Route::post('/komentar/update/{id}', [KomentarController::class, 'update'])->name('komentar.update');
    Route::post('/komentar/hapus/{id}', [KomentarController::class, 'hapus'])->name('komentar.hapus');

    // ULASAN
    Route::get('/ulasan/{id}', [FullBacaanController::class, 'ulasan'])->name('ulasan.index');
    Route::post('/ulasan/{id}', [FullBacaanController::class, 'storeReview'])->name('ulasan.store');

    // TULIS BUKU
    Route::get('/tulis-buku', [BookSubmissionController::class, 'create'])->name('tulis-buku.create');
    Route::post('/tulis-buku/store', [BookSubmissionController::class, 'store'])->name('tulis-buku.store');

    // NOTIFIKASI USER
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/read/{id}', [NotificationController::class, 'markAsRead'])
        ->name('notifikasi.read');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminOnly::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        // PEMBAYARAN
        Route::get('/pembayaran', [PembayaranAdminController::class, 'index'])
            ->name('pembayaran.index');

        // RIWAYAT BACA
        Route::prefix('riwayat-baca')->name('kelolariwayat.')->group(function () {
            Route::get('/', [KelolaRiwayatBacaController::class, 'index'])->name('index');
            Route::get('/create', [KelolaRiwayatBacaController::class, 'create'])->name('create');
            Route::post('/', [KelolaRiwayatBacaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KelolaRiwayatBacaController::class, 'edit'])->name('edit');
            Route::post('/{id}', [KelolaRiwayatBacaController::class, 'update'])->name('update');
            Route::delete('/{id}', [KelolaRiwayatBacaController::class, 'destroy'])->name('destroy');
        });

        // USER
        Route::resource('/users', UserController::class);

        // REVIEW
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        // FORUM
        Route::get('/forum', [AdminForumController::class, 'index'])->name('forum.index');

        // GENRE & BUKU
        Route::get('/genre', [GenreAdminController::class, 'index'])->name('genre.index');
        Route::get('/books/create', [GenreAdminController::class, 'create'])->name('books.create');
        Route::post('/books/store', [GenreAdminController::class, 'store'])->name('books.store');
        Route::get('/books/{id}/edit', [GenreAdminController::class, 'edit'])->name('books.edit');
        Route::post('/books/{id}/update', [GenreAdminController::class, 'update'])->name('books.update');
        Route::post('/books/delete', [GenreAdminController::class, 'destroy'])->name('books.delete');

        // VALIDASI
        Route::get('/validasi', [BookSubmissionController::class, 'indexAdmin'])->name('validasi.index');
        Route::post('/validasi/{id}/approve', [BookSubmissionController::class, 'approve'])->name('validasi.approve');
        Route::post('/validasi/{id}/reject', [BookSubmissionController::class, 'reject'])->name('validasi.reject');

        // KOMENTAR
        Route::get('/komentar', [AdminKomentarController::class, 'index'])->name('komentar.index');
        Route::delete('/komentar/{id}', [AdminKomentarController::class, 'hapus'])->name('komentar.hapus');

        // REWARD
        Route::get('/rewards', [AdminRewardController::class, 'index'])->name('rewards.index');
        Route::post('/rewards/{user}/add', [AdminRewardController::class, 'add'])->name('reward.add');
        Route::post('/rewards/{user}/remove', [AdminRewardController::class, 'remove'])->name('reward.remove');

        // FAVORIT
        Route::get('/favorit', [AdminBukuFavoritController::class, 'index'])->name('favorit.index');
        Route::get('/favorit/{id}', [AdminBukuFavoritController::class, 'show'])->name('favorit.show');
        Route::delete('/favorit/{id}', [AdminBukuFavoritController::class, 'destroy'])->name('favorit.destroy');

        // NOTIFIKASI ADMIN
        Route::get('/notifications', [AdminNotificationController::class, 'index'])
            ->name('notifications.index');
        Route::post('/notifications/{id}/read', [AdminNotificationController::class, 'markAsRead'])
            ->name('notifications.read');
        Route::delete('/notifications/{id}', [AdminNotificationController::class, 'destroy'])
            ->name('notifications.destroy');
    });
