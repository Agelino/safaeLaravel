<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\FavoriteBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BukuFavoritController extends Controller
{
    /**
     * Tampilkan daftar buku favorit user
     */
    public function index()
    {
        // Ambil semua buku approved (jika masih dipakai di view)
        $books = Book::where('status', 'approved')->get();

        // Ambil favorit user login + relasi buku
        $favorites = FavoriteBook::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('books.bukuFavorit', [
            'books'     => $books,
            'favorites' => $favorites
        ]);
    }

    /**
     * Tambah buku ke favorit
     */
    public function tambah(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        $fav = FavoriteBook::firstOrCreate([
    'user_id' => Auth::id(),
    'book_id' => $request->book_id
]);

// 🔔 notif hanya kalau baru
if ($fav->wasRecentlyCreated) {
    \App\Models\Notification::create([
        'user_id' => Auth::id(),
        'message' => 'Buku "' . $fav->book->judul . '" ditambahkan ke favorit',
        'url' => route('favorite.index')
    ]);
}



return back()->with('success', 'Buku berhasil ditambahkan ke favorit');

    }

    /**
     * Hapus buku dari favorit
     */
    public function hapus(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        FavoriteBook::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->delete();

        return back()->with('success', 'Buku berhasil dihapus dari favorit');
    }
}
