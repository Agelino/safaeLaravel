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
        $komentar = Komentar::where('book_id', $bookId)->where('page', $page)->orderBy('created_at', 'desc')->get();

        return view('books.komentar', [
            'komentar' => $komentar,
            'bookId' => $bookId,
            'page' => $page
        ]);
    }

  
    public function simpan(Request $request)
    {
        $request->validate([
            'book_id' => 'required',
            'page' => 'required',
            'komentar' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $namaFile = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);
        }

      
        $user = Auth::user();

        if ($user->username) {
            $username = $user->username;
        } else {
            $username = $user->name;
        }

        if (!$username) {
            $username = 'Anonymous';
        }

        Komentar::create([
            'user_id' => $user->id,
            'book_id' => $request->book_id,
            'page' => $request->page,
            'username' => $username,
            'komentar' => $request->komentar,
            'image_path' => $namaFile
        ]);

        return back();
    }

    
    public function edit($id)
    {
        $komentar = Komentar::findOrFail($id);

        if (Auth::id() != $komentar->user_id) {
            abort(403);
        }

        return view('books.edit_komentar', ['komentar' => $komentar ]);
    }

   
    public function update(Request $request, $id)
{
    $komentar = Komentar::findOrFail($id);
    
    if (Auth::id() != $komentar->user_id) {
        abort(403, 'Kamu tidak berhak mengedit komentar ini');
    }
    $request->validate([
        'komentar' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $namaFile = $komentar->image_path;

    if ($request->hasFile('image')) {

        if ($namaFile) {
            $path = public_path('uploads/' . $namaFile);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $file = $request->file('image');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $namaFile);
    }

    $komentar->update([
        'komentar' => $request->komentar,
        'image_path' => $namaFile
    ]);

    
    return redirect()->route('komentar.index', [
        $request->book_id,
        $request->page
    ])->with('success', 'Komentar berhasil diperbarui');
}


    
    public function hapus($id)
    {
        $komentar = Komentar::findOrFail($id);

        if (Auth::id() != $komentar->user_id) {
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
