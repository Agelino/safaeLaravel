<?php

namespace App\Http\Controllers;

class RewardController extends Controller
{
    public function index()
    {
        $ranking = [
            ['nama' => 'sharone', 'poin' => 120, 'foto' => 'sharone.jpeg'],
            ['nama' => 'carlos',  'poin' => 90,  'foto' => 'carlos.jpg'],
            ['nama' => 'revees',  'poin' => 80,  'foto' => 'revees.jpg'],
            ['nama' => 'olivia',  'poin' => 60,  'foto' => 'feby.jpeg'],
        ];

        $currentUser = [
            'nama' => 'feby',
            'poin' => 60,
            'foto' => 'feby.jpeg',
        ];

        return view('reward.reward', compact('ranking', 'currentUser'));
    }
}
