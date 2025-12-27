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
        'description',
        'image_path',
        'status',
        'content',
    ];

    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'book_id'); 
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'book_id', 'id');
    }
}
