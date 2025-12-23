<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminKomentarController extends Controller
{
    // Tampilkan semua komentar
    public function index()
    {
        $komentar = Komentar::latest()->get();
        return view('admin.books.komentar', compact('komentar'));
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

        return back()->with('success', 'Komentar berhasil dihapus');
    }
}
