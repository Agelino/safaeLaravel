<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class GenreAdminController extends Controller
{
    private $genre_options = [
        'Pemrograman', 'Novel', 'Hobi', 'Horror', 'Romance', 
        'Action', 'Komedi', 'Sci-Fi', 'Fiksi', 'Mystery'
    ];


    public function daftarBuku(Request $request)
    {
        $semua_genre = Book::where('status', 'approved')
                          ->select('genre')
                          ->distinct()
                          ->pluck('genre');

        $filter_genre = $request->input('genre');

        $query_buku = Book::where('status', 'approved')
                          ->orderBy('created_at', 'desc');

        $buku_tampil = collect();
        $buku_per_genre = collect();

        if (!empty($filter_genre)) {
            $buku_tampil = $query_buku->where('genre', $filter_genre)->paginate(8);
        } else {
            $semua_buku = $query_buku->get();
            $buku_per_genre = $semua_buku->groupBy('genre');
        }

        return view('admin.books.genre', [
            'all_genres' => $semua_genre,
            'current_genre' => $filter_genre,
            'books_to_show' => $buku_tampil,
            'grouped_books' => $buku_per_genre,
        ]);
    }

    public function halamanTambah()
    {
        return view('admin.books.create-book', [
            'genre_options' => $this->genre_options
        ]);
    }

    public function simpanBuku(Request $request)//mengecek  from
    {
        $data_valid = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string',
            'year' => 'required|integer',
            'description' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {//cek apakah user upload foto
            $path = $request->file('image')->store('covers', 'public');//ambil file nya gambar yang diupload
            $data_valid['image_path'] = '/storage/' . $path;
        }

        $data_valid['status'] = 'approved';
        
        Book::create($data_valid);//simpan semua data di var data valid

        return redirect('/admin/genre')
               ->with('success', 'Buku berhasil ditambahkan! Status: Menunggu Persetujuan');
    }

    public function halamanEdit($id)
    {
        $buku = Book::findOrFail($id);//mencari buku didatabse berdasarkan id

        return view('admin.books.edit', [
            'book' => $buku,
            'genre_options' => $this->genre_options
        ]);
    }

    public function perbaruiBuku(Request $request, $id) //data form dan  id
    {
        $buku = Book::findOrFail($id);

        $data_valid = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string',
            'year' => 'required|integer',
            'description' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {//cek kalau dia upload kalau gk maka di skip
            if ($buku->image_path) {   // cek data lama 
                $path_lama = str_replace('/storage/', '', $buku->image_path);
                Storage::disk('public')->delete($path_lama);//akses path trus hapus
            }

            $path = $request->file('image')->store('covers', 'public');
            $data_valid['image_path'] = '/storage/' . $path;
        }

        $buku->update($data_valid);//92

        return redirect('/admin/genre?genre=' . urlencode($request->genre))
               ->with('success', 'Data buku berhasil diperbarui!');
    }

    public function lihatBuku($id)
    {
        $buku = Book::findOrFail($id);
        
        $arrayKonten = explode("\n", $buku->content);
        $itemPerHalaman = 20;
        
        $dataPaginasi = new \Illuminate\Pagination\LengthAwarePaginator(
            collect($arrayKonten)->forPage(request()->get('page', 1), $itemPerHalaman),
            count($arrayKonten),
            $itemPerHalaman,
            request()->get('page', 1),
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        $kontenAkhir = nl2br(e(implode("\n", $dataPaginasi->items())));
        
        return view('admin.books.show-book', [
            'book' => $buku,
            'paginatedData' => $dataPaginasi,
            'finalContent' => $kontenAkhir,
        ]);
    }

    public function hapusBuku(Request $request)
    {
        $buku = Book::findOrFail($request->id);

        if ($buku->image_path) {//punya gambar cover?
            $path_gambar = str_replace('/storage/', '', $buku->image_path);
            Storage::disk('public')->delete($path_gambar);
        }

        $buku->delete();

        return back()->with('success', 'Buku berhasil dihapus permanen dari database!');
    }
}
