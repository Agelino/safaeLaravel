<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FullBacaanController extends Controller
{
   
    public function show($id, $page = 1)
    {
       
        $book = Book::findOrFail($id);

        
        if (Auth::check()) {ReadingHistory::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                ],
                [
                    'progress' => $page,
                    'last_read_at' => now(),
                ]
            );
        }

        $text = $book->full_text;
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);
        $halaman = explode("\n", $text);
        $hasil = [];
        foreach ($halaman as $baris) {
            if (trim($baris) !== '') {
                $hasil[] = $baris;
            }
        }

        $totalHalaman = count($hasil);

        if ($totalHalaman == 0) {
            return view('books.fullbacaan', [
                'buku' => $book,
                'halaman' => 'Belum ada konten.',
                'page' => 1,
                'totalHalaman' => 1
            ]);
        }

      
        if ($page < 1) {
            $page = 1;
        }

        if ($page > $totalHalaman) {
            $page = $totalHalaman;
        }

        return view('books.fullbacaan', [
            'buku' => $book,
            'halaman' => $hasil[$page - 1],
            'page' => $page,
            'totalHalaman' => $totalHalaman
        ]);
    }

  
    public function ulasan($id)
    {
        $book = Book::with('reviews.user')->findOrFail($id);

        $reviews = $book->reviews;
        $totalReview = $reviews->count();

        if ($totalReview > 0) {
            $avgRating = round($reviews->avg('rating'), 1);
        } else {
            $avgRating = 0;
        }

        return view('review.index', [
            'book' => $book,
            'reviews' => $reviews,
            'totalReview' => $totalReview,
            'avgRating' => $avgRating
        ]);
    }

    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string'
        ]);

        $book = Book::findOrFail($id);

        $book->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar
        ]);

        return redirect()->route('ulasan.index', $id)
            ->with('success', 'Ulasan berhasil ditambahkan!');
    }
}
