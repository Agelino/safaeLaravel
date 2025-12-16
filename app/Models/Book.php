<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'genre',
        'year',
        'content',
        'image_path',
        'status',
    ];

    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class);
    }

    // RELASI YANG BENAR UNTUK AMBIL REVIEW
    public function reviews()
    {
        return $this->hasMany(Review::class, 'book_id'); 
    }
}
