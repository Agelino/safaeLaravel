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
        return view('profile.show', [
            'profile' => Auth::user()
        ]);
    }

    // =====================
    // FORM EDIT PROFIL
    // =====================
    public function edit()
    {
        return view('profile.edit', [
            'profile' => Auth::user()
        ]);
    }

    // =====================
    // UPDATE PROFIL (PALING BASIC)
    // =====================
    public function update(Request $request)
    {
        $request->validate([
            'username'    => 'required',
            'social_media'=> 'nullable',
            'bio'         => 'nullable',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'username'     => $request->username,
            'social_media' => $request->social_media,
            'bio'          => $request->bio,
        ];

        // FOTO PROFIL (STORAGE LINK BASIC)
        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')
                            ->store('foto_profil', 'public');

            $data['foto_profil'] = $path;
        }

        User::where('id', Auth::id())->update($data);

        return redirect('/profile')
            ->with('success', 'Profil berhasil diperbarui');
    }

    // =====================
    // HAPUS AKUN (TANPA delete())
    // =====================
    public function destroy()
    {
        $userId = Auth::id();

        Auth::logout();

        User::where('id', $userId)->delete();

        return redirect('/')
            ->with('success', 'Akun berhasil dihapus');
    }
}
