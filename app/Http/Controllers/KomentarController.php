<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class KomentarController extends Controller
{
    public function index()
    {
        $komentar = Komentar::latest()->get();
        return view('books.komentar', ['komentar' => $komentar]);
    }

    public function input()
    {
        return view('books.input_komentar');
    }

    public function simpan(Request $r)
    {
        $r->validate([
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
            'user_id'    => $user->id ?? null,
            'username'   => $username,
            'komentar'   => $r->komentar,
            'image_path' => $namaFile
        ]);

        return redirect('/komentar');
    }

    public function edit($id)
    {
        $komentar = Komentar::findOrFail($id);

        if (Auth::id() !== $komentar->user_id) {
            return redirect('/komentar');
        }

        return view('books.edit_komentar', ['komentar' => $komentar]);
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
            if ($komentar->image_path) {
                $oldPath = public_path('uploads/' . $komentar->image_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            $file = $r->file('image');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);
        }

        $komentar->update([
            'komentar'   => $r->komentar,
            'image_path' => $namaFile
        ]);

        return redirect('/komentar');
    }

    public function hapus($id)
    {
        $komentar = Komentar::findOrFail($id);


        if ($komentar->image_path) {
            $path = public_path('uploads/' . $komentar->image_path);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $komentar->delete();

        return redirect('/komentar');
    }
}
