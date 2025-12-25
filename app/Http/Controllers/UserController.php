<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // =====================
    // LIST USER
    // =====================
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    // =====================
    // DETAIL USER
    // =====================
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', [
            'user' => $user
        ]);
    }

    // =====================
    // FORM EDIT USER
    // =====================
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', [
            'user' => $user
        ]);
    }

    // =====================
    // UPDATE USER (ADMIN)
    // =====================
    public function update(Request $request, $id)
    {
        $request->validate([
            'username'    => 'required',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = User::findOrFail($id);

        $user->username = $request->username;

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/foto_profil'), $name);

            $user->foto_profil = 'uploads/foto_profil/' . $name;
        }

        $user->save();

        return redirect('/admin/users')
            ->with('success', 'User berhasil diperbarui');
    }

    // =====================
    // HAPUS USER
    // =====================
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/admin/users')
            ->with('success', 'User berhasil dihapus');
    }
}
