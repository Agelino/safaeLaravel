<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // =====================
    // GET /api/users
    // =====================
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => User::select(
                'id',
                'username',
                'social_media',
                'foto_profil'
            )->get()
        ]);
    }

    // =====================
    // GET /api/users/{id}
    // =====================
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => User::select(
                'id',
                'username',
                'social_media',
                'foto_profil'
            )->findOrFail($id)
        ]);
    }

    // =====================
    // PUT /api/users/{id}
    // =====================
    public function update(Request $request, $id)
    {
        $request->validate([
            'username'      => 'required|string|max:50|unique:users,username,' . $id,
            'social_media'  => 'nullable|string|max:100',
        ]);

        $user = User::findOrFail($id);

        $user->username = $request->username;
        $user->social_media = $request->social_media;

        // upload foto (optional)
        if ($request->hasFile('foto_profil')) {

            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $path = $request->file('foto_profil')
                ->store('foto_profil', 'public');

            $user->foto_profil = $path;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui',
            'data' => $user
        ]);
    }

    // =====================
    // DELETE /api/users/{id}
    // =====================
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
}
