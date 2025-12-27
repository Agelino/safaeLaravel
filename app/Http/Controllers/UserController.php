<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // =====================
    // LIST USER
    // =====================
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    // =====================
    // FORM TAMBAH USER
    // =====================
    public function create()
    {
        return view('admin.users.create');
    }

    // =====================
    // SIMPAN USER BARU
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    // =====================
    // DETAIL USER
    // =====================
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    // =====================
    // FORM EDIT USER
    // =====================
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    // =====================
    // UPDATE USER (ADMIN) - STORAGE LINK
    // =====================
    public function update(Request $request, $id)
    {
        $request->validate([
            'username'    => 'required|string|max:50|unique:users,username,' . $id,
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = User::findOrFail($id);

        $user->username = $request->username;

        // UPLOAD FOTO PROFIL (STORAGE)
        if ($request->hasFile('foto_profil')) {

            // hapus foto lama (jika ada)
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            // simpan foto baru
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $user->foto_profil = $path; // contoh: foto_profil/abc.jpg
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    // =====================
    // HAPUS USER
    // =====================
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // hapus foto profil dari storage (jika ada)
        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }
}
