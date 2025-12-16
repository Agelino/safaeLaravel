<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;

class FullBacaanController extends Controller
{
    // ==========================================================
    // HALAMAN BACA BUKU
    // ==========================================================
    public function show($id, $page = 1)
    {
        $book = Book::findOrFail($id);

        // Simpan / update riwayat baca
        if (Auth::check()) {
            ReadingHistory::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'book_id' => $id,
                ],
                [
                    'progress' => $page,
                    'last_read_at' => now(),
                ]
            );
        }

        // Pecah teks full_text per baris
        $teks = str_replace(["\r\n", "\r"], "\n", $book->full_text);
        $halaman = explode("\n", $teks);
        $halaman = array_filter($halaman, fn($line) => trim($line) !== '');
        $halaman = array_values($halaman);

        $totalHalaman = count($halaman);

        if ($totalHalaman === 0) {
            return view('books.fullbacaan', [
                'buku' => $book,
                'halaman' => "Belum ada konten.",
                'page' => 1,
                'totalHalaman' => 1
            ]);
        }

        $page = max(1, min($page, $totalHalaman));

        return view('books.fullbacaan', [
            'buku' => $book,
            'halaman' => $halaman[$page - 1],
            'page' => $page,
            'totalHalaman' => $totalHalaman
        ]);
    }

    // ==========================================================
    // HALAMAN ULASAN
    // ==========================================================
    public function ulasan($id)
    {
        $book = Book::with(['reviews.user'])->findOrFail($id);

        $reviews = $book->reviews;
        $totalReview = $reviews->count();
        $avgRating = $totalReview > 0 ? round($reviews->avg('rating'), 1) : 0;

        return view('review.index', [
            'book'        => $book,
            'reviews'     => $reviews,
            'totalReview' => $totalReview,
            'avgRating'   => $avgRating
        ]);
    }

    // ==========================================================
    // SIMPAN ULASAN
    // ==========================================================
    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string'
        ]);

        $book = Book::findOrFail($id);

        $book->reviews()->create([
            'user_id'  => Auth::id(),
            'rating'   => $request->rating,
            'komentar' => $request->komentar
        ]);

        return redirect()->route('ulasan.index', $id)
            ->with('success', 'Ulasan berhasil ditambahkan!');
    }
}

