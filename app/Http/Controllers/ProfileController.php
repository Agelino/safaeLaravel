<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    // =====================
    // LIHAT PROFIL
    // =====================
    public function show()
    {
        $user = Auth::user();

        return view('profile.show', [
            'profile' => $user
        ]);
    }

    // =====================
    // FORM EDIT PROFIL
    // =====================
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', [
            'profile' => $user
        ]);
    }

    // =====================
    // UPDATE PROFIL
    // =====================
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        if (!$user) {
            return redirect('/profile');
        }

        $request->validate([
            'username'      => 'required',
            'social_media'  => 'nullable',
            'bio'           => 'nullable',
            'foto_profil'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->username     = $request->username;
        $user->social_media = $request->social_media;
        $user->bio          = $request->bio;

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/foto_profil'), $name);

            $user->foto_profil = 'uploads/foto_profil/' . $name;
        }

        $user->save();

        return redirect('/profile')
            ->with('success', 'Profil berhasil diperbarui');
    }

    // =====================
    // HAPUS AKUN SENDIRI
    // =====================
    public function destroy()
    {
        $user = User::find(Auth::id());

        Auth::logout();

        if ($user) {
            $user->delete();
        }

        return redirect('/')
            ->with('success', 'Akun berhasil dihapus');
    }
}
