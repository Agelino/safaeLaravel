<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuFavoritController extends Controller
{
    // Menampilkan halaman daftar buku dan buku favorit
    public function index()
    {
        // Data contoh (bisa diganti dari database nanti)
        $books = [
            ["title" => "The Chronicles Of Narnia", "author" => "C.S. Lewis", "image" => asset('images/narnia.jpg')],
            ["title" => "Proposal For Wedding", "author" => "DesyMiladiana", "image" => asset('images/proposal-for-wedding.jpg')],
            ["title" => "Laut Bercerita", "author" => "Leila S. Chudori", "image" => asset('images/laut-bercerita.png')],
        ];

        // Ambil data favorit dari session
        $favorites = session('favorite_books', []);

        // Kirim ke view
        return view('books.BukuFavorit', compact('books', 'favorites'));
    }

    // Menambahkan buku ke daftar favorit
    public function tambah(Request $request)
    {
        $favorites = session('favorite_books', []);

        $bukuBaru = [
            'title' => $request->title,
            'author' => $request->author,
            'image' => $request->image
        ];

        // Cek apakah buku sudah ada di favorit
        $sudahAda = false;
        foreach ($favorites as $fav) {
            if ($fav['title'] === $bukuBaru['title']) {
                $sudahAda = true;
                break;
            }
        }

        // Tambahkan jika belum ada
        if (!$sudahAda) {
            $favorites[] = $bukuBaru;
            session(['favorite_books' => $favorites]);
        }

        return redirect('/bukufavorit');
    }

    // Menghapus buku dari daftar favorit
    public function hapus(Request $request)
    {
        $favorites = session('favorite_books', []);

        $favorites = array_filter($favorites, function ($book) use ($request) {
            return $book['title'] !== $request->title;
        });

        session(['favorite_books' => array_values($favorites)]);

        return redirect('/bukufavorit');
    }
}
