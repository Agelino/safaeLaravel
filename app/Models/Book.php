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
        'content',
        'status',
        'image_path',
    ];

    /**
     * Accessor URL GAMBAR (UNTUK FLUTTER)
     */
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image_path
            ? asset('storage/' . $this->image_path)
            : null;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }

    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class);
    }
}
