<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PembayaranController extends Controller
{
    // HALAMAN PEMBAYARAN
    public function index()
    {
        $user = Auth::user();

        return view('pembayaran.index', [
            'saldoPoin' => $user->points
        ]);
    }

    // PROSES PEMBAYARAN
    public function proses(Request $request)
{
    $request->validate([
        'points' => 'required|integer|min:1',
        'price' => 'required|integer|min:0',
        'metode' => 'required'
    ]);

    DB::table('users')
        ->where('id', Auth::id())
        ->update([
            'points' => DB::raw('points + ' . (int) $request->points)
        ]);

    return redirect('/pembayaran')
        ->with('success', 'Pembayaran berhasil! Poin kamu bertambah 🎉');
}
}
