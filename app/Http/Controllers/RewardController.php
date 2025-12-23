<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\ReadingProgress;
use App\Models\PointHistory;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    // LEADERBOARD
    public function index()
    {
        // TOP 3 / CARD
        $ranking = User::orderBy('points', 'desc')
            ->take(3)
            ->get();

        // LIST 5 USER POINT TERBANYAK
        $topUsers = User::orderBy('points', 'desc')
            ->take(5)
            ->get();

        $currentUser = Auth::user();

        return view('reward.reward', compact(
            'ranking',
            'topUsers',
            'currentUser'
        ));
    }

    // SIMPAN DURASI BACA
    public function saveDuration(Book $book)
    {
        $user = Auth::user();

        ReadingProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'book_id' => $book->id
            ],
            [
                'duration' => 600 // 10 menit
            ]
        );

        return response()->json(['status' => 'ok']);
    }

    // SELESAI MEMBACA → CEK 10 MENIT → DAPAT POINT
    public function finishReading(Book $book)
    {
        $user = Auth::user();

        $progress = ReadingProgress::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        if (!$progress || $progress->duration < 600) {
            return back()->with('error', 'Baca minimal 10 menit dulu!');
        }

        $already = PointHistory::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->exists();

        if ($already) {
            return back()->with('info', 'Poin sudah pernah didapat.');
        }

        // TAMBAH POINT
        $user->increment('points', 5);

        PointHistory::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'points' => 5
        ]);

        return back()->with('success', '🎉 Kamu dapat 5 poin!');
    }
}
