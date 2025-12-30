<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\ReadingProgress;
use App\Models\PointHistory;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    public function index()
    {
        $ranking = User::orderBy('points', 'desc')->take(3)->get();

        $topUsers = User::orderBy('points', 'desc')->take(5)->get();

      
        $currentUser = Auth::user();

        return view('reward.reward', [
            'ranking' => $ranking,
            'topUsers' => $topUsers,
            'currentUser' => $currentUser
        ]);
    }

   
    public function saveDuration(Book $book)
    {
        $user = Auth::user();

        ReadingProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'book_id' => $book->id
            ],
            [
                'duration' => 600 
            ]
        );

        return response()->json(['status' => 'ok']);
    }

    
    public function finishReading(Book $book)
    {
        $user = Auth::user();

        $progress = ReadingProgress::where('user_id', $user->id)->where('book_id', $book->id)->first();

        if (!$progress) {
            return back()->with('error', 'Baca minimal 10 menit dulu!');
        }

        if ($progress->duration < 600) {
            return back()->with('error', 'Baca minimal 10 menit dulu!');
        }

        
        $sudahDapat = PointHistory::where('user_id', $user->id)->where('book_id', $book->id)->exists();

        if ($sudahDapat) {
            return back()->with('info', 'Poin sudah pernah didapat.');
        }

        $user->points = $user->points + 5;
        $user->save();

        PointHistory::create([
            'user_id' => $user->id,
            'points' => 5
        ]);

        return back()->with('success', '🎉 Kamu dapat 5 poin!');
    }
}
