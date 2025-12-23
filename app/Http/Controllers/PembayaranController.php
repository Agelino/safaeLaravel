<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PembayaranController extends Controller
{
    // tampil halaman pembayaran
    public function index()
    {
        $user = auth()->user();

        return view('pembayaran.index', [
            'saldoPoin' => $user->points
        ]);
    }

    // simpan pembayaran (tambah poin)
    public function proses(Request $request)
    {
        $request->validate([
            'points' => 'required',
            'price' => 'required',
            'metode' => 'required'
        ]);

        $user = auth()->user();

        $user->points = $user->points + $request->points;
        $user->save();

        return redirect('/pembayaran')
            ->with('success', 'Pembayaran berhasil!');
    }
}
