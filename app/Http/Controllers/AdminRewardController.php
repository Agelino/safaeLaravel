<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PointHistory;
use Illuminate\Http\Request;

class AdminRewardController extends Controller
{
    /**
     * Halaman kelola reward (admin)
     */
    public function index()
    {
        $users = User::where('role', 'user')
            ->orderBy('points', 'desc')
            ->get();

        return view('admin.rewards.index', compact('users'));
    }

    /**
     * Tambah poin user
     */
    public function add(Request $request, User $user)
    {
        $request->validate([
            'points' => 'required|integer|min:1',
        ]);

        // tambah poin
        $user->points += $request->points;
        $user->save();

        // simpan riwayat poin (+)
        PointHistory::create([
            'user_id' => $user->id,
            'points'  => $request->points,
        ]);

        // 🔥 WAJIB ke route admin.rewards.index
        return redirect()->route('admin.rewards.index')
            ->with('success', 'Poin berhasil ditambahkan');
    }

    /**
     * Kurangi poin user
     */
    public function remove(Request $request, User $user)
    {
        $request->validate([
            'points' => 'required|integer|min:1',
        ]);

        // kurangi poin (tidak boleh minus)
        $user->points -= $request->points;
        if ($user->points < 0) {
            $user->points = 0;
        }
        $user->save();

        // simpan riwayat poin (-)
        PointHistory::create([
            'user_id' => $user->id,
            'points'  => -$request->points,
        ]);

        return redirect()->route('admin.rewards.index')
            ->with('success', 'Poin berhasil dikurangi');
    }
}
