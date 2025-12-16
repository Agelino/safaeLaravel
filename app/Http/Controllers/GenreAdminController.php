<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class GenreAdminController extends Controller
{
    private $genre_options = [
        'Pemrograman', 'Novel', 'Hobi', 'Horror', 'Romance', 'Action', 'Komedi', 'Sci-Fi', 'Fiksi', 'Mystery'
    ];

    public function index(Request $request)
    {
        $allGenres = Book::where('status', 'approved')
                         ->select('genre')->distinct()->pluck('genre');

        $genreFilter = $request->input('genre');

        $booksQuery = Book::where('status', 'approved')
                          ->orderBy('created_at', 'desc');

        $booksToShow = collect();
        $groupedBooks = collect();

        if (!empty($genreFilter)) {
            $booksToShow = $booksQuery->where('genre', $genreFilter)->paginate(8);
        } else {
            $allBooksData = $booksQuery->get();
            $groupedBooks = $allBooksData->groupBy('genre');
        }

        return view('admin.books.genre', [   // ← PERBAIKAN DI SINI
            'all_genres' => $allGenres,
            'current_genre' => $genreFilter,
            'books_to_show' => $booksToShow,
            'grouped_books' => $groupedBooks,
        ]);
    }

    public function create()
    {
        return view('admin.books.create-book', [
            'genre_options' => $this->genre_options
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string',
            'year' => 'required|integer',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('covers', 'public');
            $validated['image_path'] = '/storage/' . $path;
        }

        $validated['status'] = 'pending';
        Book::create($validated);

        return redirect('/admin/genre?genre=' . urlencode($request->genre))
               ->with('success', 'Buku berhasil ditambahkan ke Database!');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);

        return view('admin.books.edit', [
            'book' => $book,
            'genre_options' => $this->genre_options
        ]);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string',
            'year' => 'required|integer',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($book->image_path) {
                $oldPath = str_replace('/storage/', '', $book->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('covers', 'public');
            $validated['image_path'] = '/storage/' . $path;
        }

        $book->update($validated);

        return redirect('/admin/genre?genre=' . urlencode($request->genre))
               ->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Request $request)
    {
        $book = Book::findOrFail($request->id);

        if ($book->image_path) {
            $oldPath = str_replace('/storage/', '', $book->image_path);
            Storage::disk('public')->delete($oldPath);
        }

        $book->delete();

        return back()->with('success', 'Buku berhasil dihapus permanen!');
    }
}
