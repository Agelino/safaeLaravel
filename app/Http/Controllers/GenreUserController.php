<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class GenreUserController extends Controller
{
    public function index(Request $request)
    {
        // ambil query dari URL
        $genre  = $request->query('genre');
        $search = $request->query('search');

        // ambil semua genre dari buku yang sudah approved
        $allGenres = Book::where('status', 'approved')
            ->select('genre')
            ->distinct()
            ->pluck('genre');

        // query dasar buku (approved)
        $query = Book::where('status', 'approved');

        // filter genre
        if (!empty($genre)) {
            $query->where('genre', $genre);
        }

        // filter search judul buku
        if (!empty($search)) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        // ambil data buku
        $books_to_show = $query->orderBy('created_at', 'desc')->get();

        return view('books.genre', [
            'books_to_show' => $books_to_show,
            'all_genres'    => $allGenres,
            'current_genre' => $genre,
            'search'        => $search,
        ]);
    }
}
