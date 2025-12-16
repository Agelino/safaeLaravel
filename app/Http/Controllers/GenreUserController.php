<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class GenreUserController extends Controller
{
    public function index(Request $request)
    {
        // ambil input dari URL (?genre=...&search=...)
        $genre = $request->genre;
        $search = $request->search;

        // ambil semua genre (buat filter)
        $allGenres = Book::where('status', 'approved')
            ->pluck('genre')
            ->unique();

        // ambil semua buku yang sudah approved
        $books_to_show = Book::where('status', 'approved')->get();

        // kalau user pilih genre
        if ($genre) {
            $books_to_show = $books_to_show->where('genre', $genre);
        }

        // kalau user search judul
        if ($search) {
            $books_to_show = $books_to_show->filter(function ($book) use ($search) {
                return stripos($book->title, $search) !== false;
            });
        }

        return view('books.genre', [
            'books_to_show' => $books_to_show,
            'all_genres'    => $allGenres,
            'genre'         => $genre,
            'search'        => $search,
        ]);
    }
}
