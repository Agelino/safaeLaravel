<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3), // Judul acak
            'author' => $this->faker->name(), // Nama penulis acak
            // Genre dipilih acak dari daftar ini
            'genre' => $this->faker->randomElement(['Pemrograman', 'Novel', 'Hobi', 'Horror', 'Romance', 'Action']), 
            'year' => $this->faker->year(),
            'content' => $this->faker->text(500), // Konten lorem ipsum panjang
            'image_path' => null, // Foto kosong (biar pakai placeholder)
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}