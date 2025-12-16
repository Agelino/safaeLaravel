<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'adzraaditama'],
            [
                'nama_depan' => 'Adzra',
                'nama_belakang' => 'Nurul Aditama',
                'email' => 'adzra@mail.com',
                'telepon' => '08123456789',
                'password' => Hash::make('1234'),
            ]
        );

        User::updateOrCreate(
            ['username' => 'sharonejp'],
            [
                'nama_depan' => 'Sharone',
                'nama_belakang' => 'Putri',
                'email' => 'sharone@mail.com',
                'telepon' => '08123450000',
                'password' => Hash::make('12345'),
            ]
        );

        User::updateOrCreate(
            ['username' => 'khansafeby'],
            [
                'nama_depan' => 'Feby',
                'nama_belakang' => 'Aulia',
                'email' => 'feby@mail.com',
                'telepon' => '08123459999',
                'password' => Hash::make('123456'),
            ]
        );

        $this->call([
            GenreSeeder::class,   
            BookSeeder::class,
            ReadingHistorySeeder::class,
        ]);
    }
}
