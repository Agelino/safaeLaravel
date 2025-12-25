<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Support\Facades\File;

class AdminKomentarController extends Controller
{
    // LIST KOMENTAR
    public function index()
    {
        $komentar = Komentar::with(['user', 'book'])
            ->latest()
            ->paginate(10);

        return view('admin.komentar.index', compact('komentar'));
    }

    // METHOD SESUAI ROUTE (JANGAN DIHAPUS)
    public function hapus($id)
    {
        return $this->destroy($id);
    }

    // LOGIKA HAPUS SEBENARNYA
    public function destroy($id)
    {
        $komentar = Komentar::findOrFail($id);

        if ($komentar->image_path) {
            $path = public_path('uploads/' . $komentar->image_path);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $komentar->delete();

        return redirect()
            ->route('admin.komentar.index')
            ->with('success', 'Komentar berhasil dihapus');
    }
}
