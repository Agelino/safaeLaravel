<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\FavoriteBook;
use Illuminate\Support\Facades\Auth;

class GenreUserController extends Controller
{
    public function index(Request $request)
    {
        // ambil input dari URL (?genre=...&search=...)
        $genre  = $request->genre;
        $search = $request->search;

        // ambil semua genre (buat filter)
        $allGenres = Book::where('status', 'approved')
            ->pluck('genre')
            ->unique();

        // query awal buku approved
        $query = Book::where('status', 'approved');

        // filter genre
        if ($genre) {
            $query->where('genre', $genre);
        }

        // search judul
        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $books_to_show = $query->get();

        // =========================
        // FAVORITE BOOK ID USER
        // =========================
        $favorites = [];

        if (Auth::check()) {
            $favorites = FavoriteBook::where('user_id', Auth::id())
                ->pluck('book_id')
                ->toArray();
        }

        return view('books.genre', [
            'books_to_show' => $books_to_show,
            'all_genres'    => $allGenres,
            'genre'         => $genre,
            'search'        => $search,
            'favorites'     => $favorites, // ⬅️ PENTING
        ]);
    }
}
