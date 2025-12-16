<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $users = [
        1 => [
            'id' => 1,
            'username' => 'Sharone Wonmally',
            'foto_profil' => 'images/sharone.jpg',
            'social_media' => '@sharonejp',
            'bio' => "Halo! aku suka membaca manga."
        ],
        2 => [
            'id' => 2,
            'username' => 'Adzra',
            'foto_profil' => 'images/sharone.jpg',
            'social_media' => '@adzranurul',
            'bio' => "Beer"
        ],
               3 => [
            'id' => 3,
            'username' => 'Sharone',
            'foto_profil' => 'images/sharone.jpg',
            'social_media' => '@sharonejp',
            'bio' => "Halo! aku suka membaca manga."
        ],
                4 => [
            'id' => 4,
            'username' => 'Sharone',
            'foto_profil' => 'images/sharone.jpg',
            'social_media' => '@sharonejp',
            'bio' => "Halo! aku suka membaca manga."
        ],
    ];

            public function create()
        {
            return view('profile.create');
        }

    public function show($id)
    {
        if (!isset($this->users[$id])) { 
            return "Profil tidak ditemukan.";
        }

        $profile = $this->users[$id]; 
        return view('profile.show', ['profile' => $profile]);
    }
    public function edit($id)
    {
        if (!isset($this->users[$id])) {
            return "Profil tidak ditemukan.";
        }

        $profile = $this->users[$id];
        return view('profile.edit', ['profile' => $profile]);
    }
    public function delete($id) 
    {
        if (!isset($this->users[$id])) {
            return "Profil tidak ditemukan.";
        }

        unset($this->users[$id]);
        return redirect('/home')->with('success', 'Profil berhasil dihapus (percobaan).');
    }

    public function update(Request $request, $id)
    {
        if (!isset($this->users[$id])) {
            return redirect('/profile/' . $id)->with('error', 'Profil tidak ditemukan.');
        }

        $data = $request->validate([
            'username' => 'required|string|max:255',
            'social_media' => 'required|string|max:255',
            'bio' => 'required|string',
            'profile_pic' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_pic')) {
            $folder = 'uploads/foto_profil/';
        } else {
            $data['foto_profil'] = $this->users[$id]['foto_profil'];
        }

        $this->users[$id] = array_merge($this->users[$id], $data);

        return redirect('/profile/' . $id)->with('success', 'Profil berhasil diperbarui (sementara)');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'username' => 'required|string|max:255',
        'social_media' => 'required|string|max:255',
        'bio' => 'required|string',
        'profile_pic' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('profile_pic')) {
        $folder = 'uploads/foto_profil/';
        if (!is_dir($folder)) mkdir($folder, 0777, true);

        $filename = time() . '_' . $request->file('profile_pic')->getClientOriginalName();
        $request->file('profile_pic')->move($folder, $filename);
        $data['foto_profil'] = $folder . $filename;
    } else {
        $data['foto_profil'] = 'images/default.jpg'; 
    }

    $newId = count($this->users) + 1;
    $data['id'] = $newId;

    $this->users[$newId] = $data;

    return redirect('/profile/' . $newId)->with('success', 'Profil berhasil ditambahkan (sementara)');
}

}
