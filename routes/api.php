<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ReadingController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\PointController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PembayaranController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReadingHistoryController;
use App\Http\Controllers\Api\KomentarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ====================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/contact', [ContactController::class, 'store']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/books/popular/list', [BookController::class, 'popular']);
Route::get('/books/latest/list', [BookController::class, 'latest']);

Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{id}', [GenreController::class, 'show']);


// ==================== AUTHENTICATED USER ====================
Route::middleware('auth:sanctum')->group(function () {

    // ===== AUTH =====
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // ===== TOPIC =====
    Route::apiResource('topics', TopicController::class);

    // ===== REVIEW =====
    Route::get('/reviews/my/list', [ReviewController::class, 'myReviews']);
    Route::apiResource('reviews', ReviewController::class);

    // ===== COMMENT =====
    Route::apiResource('comments', CommentController::class);

    // ==================== READING (USER) ====================
    Route::get('/reading/history', [ReadingController::class, 'history']);
    Route::get('/reading/history/book/{bookId}', [ReadingController::class, 'getBookHistory']);
    Route::post('/reading/history', [ReadingController::class, 'updateHistory']);
    Route::delete('/reading/history/{id}', [ReadingController::class, 'deleteHistory']);

    Route::get('/reading/progress', [ReadingController::class, 'progress']);
    Route::post('/reading/progress', [ReadingController::class, 'recordDuration']);
    Route::get('/reading/duration', [ReadingController::class, 'totalDuration']);

    // komentar

    Route::get('/komentar/{bookId}/{page}',[KomentarController::class, 'index']);
    Route::post('/komentar',[KomentarController::class, 'simpan']);
    Route::put('/komentar/{id}',[KomentarController::class, 'update']);
    Route::delete('/komentar/{id}', [KomentarController::class, 'hapus']);

    // ==================== READING HISTORY (USER) ====================
    // 🔵 USER hanya bisa kelola history MILIK SENDIRI
    Route::get('/reading-histories', [ReadingHistoryController::class, 'index']);        // list
    Route::get('/reading-histories/{id}', [ReadingHistoryController::class, 'show']);   // detail
    Route::post('/reading-histories', [ReadingHistoryController::class, 'store']);      // create / update
    Route::put('/reading-histories/{id}', [ReadingHistoryController::class, 'update']); // edit
    Route::delete('/reading-histories/{id}', [ReadingHistoryController::class, 'destroy']); // delete

    // ==================== FAVORITE ====================
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);
    Route::get('/favorites/check/{bookId}', [FavoriteController::class, 'check']);

    // ==================== POINT ====================
    Route::get('/points/history', [PointController::class, 'history']);
    Route::get('/points/total', [PointController::class, 'total']);
    Route::get('/points/leaderboard', [PointController::class, 'leaderboard']);
    Route::post('/points/add', [PointController::class, 'addPoints']);
    Route::post('/points/deduct', [PointController::class, 'deductPoints']);

    // ==================== NOTIFICATION ====================
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread', [NotificationController::class, 'unread']);
    Route::get('/notifications/unread/count', [NotificationController::class, 'unreadCount']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/read/all', [NotificationController::class, 'markAllAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

    // ==================== PAYMENT (USER) ====================
    Route::get('/payments', [PembayaranController::class, 'index']);
    Route::get('/payments/{id}', [PembayaranController::class, 'show']);
    Route::post('/payments', [PembayaranController::class, 'store']);
});


// ==================== ADMIN ONLY ====================
Route::middleware(['auth:sanctum', 'admin.api'])->group(function () {

    // ===== BOOK =====
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    // ===== GENRE =====
    Route::post('/genres', [GenreController::class, 'store']);
    Route::put('/genres/{id}', [GenreController::class, 'update']);
    Route::delete('/genres/{id}', [GenreController::class, 'destroy']);

    // ===== USER MANAGEMENT =====
    Route::apiResource('users', UserController::class);

    // ==================== READING HISTORY (ADMIN) ====================
    Route::get(
        '/admin/users/{userId}/reading-histories',
        [ReadingHistoryController::class, 'historiesByUser']
    ); // list by user

    Route::get(
        '/admin/reading-histories/{id}',
        [ReadingHistoryController::class, 'adminShow']
    ); // detail

    Route::put(
        '/admin/reading-histories/{id}',
        [ReadingHistoryController::class, 'adminUpdate']
    ); // edit

    Route::delete(
        '/admin/reading-histories/{id}',
        [ReadingHistoryController::class, 'adminDestroy']
    ); // delete

    // ===== PAYMENT ADMIN =====
    Route::get('/payments/admin/all', [PembayaranController::class, 'all']);
    Route::get('/payments/admin/statistics', [PembayaranController::class, 'statistics']);
    Route::delete('/payments/{id}', [PembayaranController::class, 'destroy']);

    // ===== CONTACT ADMIN =====
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::get('/contacts/{id}', [ContactController::class, 'show']);
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
});
