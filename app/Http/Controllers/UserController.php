<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // =========================
    // LIST USER
    // =========================
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    // =========================
    // DETAIL USER
    // =========================
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    // =========================
    // FORM EDIT USER
    // =========================
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'username' => 'required|string|max:100',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = User::findOrFail($id);

    // update username
    $user->username = $request->username;

    // upload foto profil
    if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')
                        ->store('profile_images', 'public');

        $user->profile_image = $path;
    }

    $user->save();

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User berhasil diperbarui');
}
    // =========================
    // HAPUS USER
    // =========================
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }
}
