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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/contact', [ContactController::class, 'store']);

// Public book routes (browsing)
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/books/popular/list', [BookController::class, 'popular']);
Route::get('/books/latest/list', [BookController::class, 'latest']);

// Public genre routes
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{id}', [GenreController::class, 'show']);

// Protected routes (requires authentication)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // Book management (Admin only - add middleware as needed)
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    // Genre management (Admin only)
    Route::post('/genres', [GenreController::class, 'store']);
    Route::put('/genres/{id}', [GenreController::class, 'update']);
    Route::delete('/genres/{id}', [GenreController::class, 'destroy']);

    // Topic routes
    Route::get('/topics', [TopicController::class, 'index']);
    Route::get('/topics/{id}', [TopicController::class, 'show']);
    Route::post('/topics', [TopicController::class, 'store']);
    Route::put('/topics/{id}', [TopicController::class, 'update']);
    Route::delete('/topics/{id}', [TopicController::class, 'destroy']);

    // Review routes
    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::get('/reviews/{id}', [ReviewController::class, 'show']);
    Route::get('/reviews/my/list', [ReviewController::class, 'myReviews']);
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

    // Comment routes
    Route::get('/comments', [CommentController::class, 'index']);
    Route::get('/comments/{id}', [CommentController::class, 'show']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

    // Reading history & progress routes
    Route::get('/reading/history', [ReadingController::class, 'history']);
    Route::get('/reading/history/book/{bookId}', [ReadingController::class, 'getBookHistory']);
    Route::post('/reading/history', [ReadingController::class, 'updateHistory']);
    Route::delete('/reading/history/{id}', [ReadingController::class, 'deleteHistory']);
    
    Route::get('/reading/progress', [ReadingController::class, 'progress']);
    Route::post('/reading/progress', [ReadingController::class, 'recordDuration']);
    Route::get('/reading/duration', [ReadingController::class, 'totalDuration']);

    // Favorite routes
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);
    Route::get('/favorites/check/{bookId}', [FavoriteController::class, 'check']);

    // Point routes
    Route::get('/points/history', [PointController::class, 'history']);
    Route::get('/points/total', [PointController::class, 'total']);
    Route::post('/points/add', [PointController::class, 'addPoints']);
    Route::post('/points/deduct', [PointController::class, 'deductPoints']);
    Route::get('/points/leaderboard', [PointController::class, 'leaderboard']);

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread', [NotificationController::class, 'unread']);
    Route::get('/notifications/unread/count', [NotificationController::class, 'unreadCount']);
    Route::get('/notifications/{id}', [NotificationController::class, 'show']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/read/all', [NotificationController::class, 'markAllAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

    // Payment routes
    Route::get('/payments', [PembayaranController::class, 'index']);
    Route::get('/payments/{id}', [PembayaranController::class, 'show']);
    Route::post('/payments', [PembayaranController::class, 'store']);
    
    // Admin payment routes
    Route::get('/payments/admin/all', [PembayaranController::class, 'all']);
    Route::get('/payments/admin/statistics', [PembayaranController::class, 'statistics']);
    Route::delete('/payments/{id}', [PembayaranController::class, 'destroy']);

    // Admin contact routes
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::get('/contacts/{id}', [ContactController::class, 'show']);
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
});
