<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('pembayaran.index', [
            'saldoPoin' => $user->points
        ]);
    }

    public function proses(Request $request)
    {
        $request->validate([
            'points' => 'required',
            'price' => 'required',
            'metode' => 'required'
        ]);

        // ambil id user yang sedang login
        $userId = Auth::id();

        // update poin pakai where
        User::where('id', $userId)
            ->update([
                'points' => $request->points + Auth::user()->points
            ]);

        return redirect('/pembayaran')
            ->with('success', 'Pembayaran berhasil!');
    }
}
