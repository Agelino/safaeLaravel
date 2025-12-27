<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookSubmissionController extends Controller
{
    /**
     * 1. HALAMAN TULIS BUKU (Untuk Penulis)
     */
    public function create()
    {
        return view('user.tulis-buku');
    }

    /**
     * 2. PROSES SIMPAN BUKU (Status: Pending)
     */
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

        // Upload Gambar
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('covers', 'public');
            $validated['image_path'] = '/storage/' . $path;
        }

        // SET STATUS OTOMATIS 'PENDING'
        $validated['status'] = 'pending'; 
        
        Book::create($validated);

        return redirect('/tulis-buku')->with('success', 'Buku berhasil dikirim! Mohon tunggu validasi dari Admin.');
    }



    /**
     * 4. AKSI APPROVE (Setujui)
     */
    public function approve($id)
    {
        $book = Book::findOrFail($id);
        $book->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Buku berhasil disetujui dan tayang!');
    }

    /**
     * 5. AKSI REJECT (Tolak)
     */
    public function reject($id)
    {
        $book = Book::findOrFail($id);
        


        $book->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Buku telah ditolak.');
    }
}