<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class KomentarController extends Controller
{
   
    public function index($bookId, $page)
    {
        $komentar = Komentar::where('book_id', $bookId)->where('page', $page)->latest()->get();

        return view('books.komentar', compact('komentar', 'bookId', 'page'));
    }

   
    public function simpan(Request $r)
    {
        $r->validate([
            'book_id' => 'required',
            'page' => 'required',
            'komentar' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $namaFile = null;

        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);
        }

        $user = Auth::user();
        $username = $user->username ?? $user->name ?? 'Anonymous';

        Komentar::create([
            'user_id' => $user->id,
            'book_id' => $r->book_id,
            'page' => $r->page,
            'username' => $username,
            'komentar' => $r->komentar,
            'image_path' => $namaFile
        ]);

        return back();
    }

    
    public function edit($id)
    {
        $komentar = Komentar::findOrFail($id);

        if (Auth::id() !== $komentar->user_id) {
            abort(403);
        }

        return view('books.edit_komentar', compact('komentar'));
    }

   
    public function update(Request $r, $id)
    {
        $komentar = Komentar::findOrFail($id);

        $r->validate([
            'komentar' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $namaFile = $komentar->image_path;

        if ($r->hasFile('image')) {
            if ($namaFile && File::exists(public_path('uploads/' . $namaFile))) {
                File::delete(public_path('uploads/' . $namaFile));
            }

            $file = $r->file('image');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);
        }

        $komentar->update([
            'komentar' => $r->komentar,
            'image_path' => $namaFile
        ]);

        return back();
    }

    
    public function hapus($id)
{
    $komentar = Komentar::findOrFail($id);

    if (Auth::id() !== $komentar->user_id) {
        abort(403, 'Kamu tidak berhak menghapus komentar ini');
    }

    if ($komentar->image_path) {
        $path = public_path('uploads/' . $komentar->image_path);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    $komentar->delete();

    return back()->with('success', 'Komentar berhasil dihapus');
}

}
