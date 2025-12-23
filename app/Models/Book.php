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
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
{
    if (!$this->image_path) {
        return null;
    }

    // kalau di DB sudah ada /storage di depannya
    if (str_starts_with($this->image_path, '/storage')) {
        return asset($this->image_path);
    }

    // kalau format normal (covers/xxx.jpg)
    return asset('storage/' . $this->image_path);
}


    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'book_id'); 
    }
}
