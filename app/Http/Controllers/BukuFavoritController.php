<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\FavoriteBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuFavoritController extends Controller
{
    public function index()
    {
        $books = Book::where('status', 'approved')->get();

        $favorites = FavoriteBook::with('book')
            ->where('user_id', Auth::id())
            ->get();

        return view('books.bukuFavorit', compact('books', 'favorites'));
    }

    public function tambah(Request $request)
    {
        FavoriteBook::firstOrCreate([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id
        ]);

        return back();
    }

    public function hapus(Request $request)
    {
        FavoriteBook::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->delete();

        return back();
    }
}
