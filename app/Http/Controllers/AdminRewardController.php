<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminRewardController extends Controller
{
    // HALAMAN KELOLA REWARD
    public function index()
    {
        $users = User::orderBy('points', 'desc')->get();

        return view('admin.reward.index', compact('users'));
    }

    // RESET POINT USER
    public function reset(User $user)
    {
        $user->points = 0;
        $user->save();

        return back()->with('success', 'Poin user berhasil direset.');
    }
}
