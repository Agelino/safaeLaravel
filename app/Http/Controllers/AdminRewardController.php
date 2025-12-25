<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\PointHistory;
use Illuminate\Http\Request;

class AdminRewardController extends Controller
{
 public function index()
{
    $users = User::where('role', 'user') 
                 ->orderBy('points', 'desc')
                 ->get();

    return view('admin.rewards.index', compact('users'));
}

    // ➕ TAMBAH POINT
    public function add(Request $request, User $user)
    {
        $request->validate([
            'points' => 'required|integer|min:1'
        ]);

        // tambah point user
        $user->points += $request->points;
        $user->save();

        $book = Book::first(); // BOOK WAJIB ADA

        PointHistory::updateOrCreate(
            [
                'user_id' => $user->id,
                'book_id' => $book->id,
            ],
            [
                'points' => ($request->points),
            ]
        );

        return back()->with('success', 'Poin berhasil ditambahkan');
    }

    // ➖ KURANGI POINT
    public function remove(Request $request, User $user)
    {
        $request->validate([
            'points' => 'required|integer|min:1'
        ]);

        $user->points = max(0, $user->points - $request->points);
        $user->save();

        $book = Book::first();

        PointHistory::updateOrCreate(
            [
                'user_id' => $user->id,
                'book_id' => $book->id,
            ],
            [
                'points' => -$request->points,
            ]
        );

        return back()->with('success', 'Poin berhasil dikurangi');
    }
}
