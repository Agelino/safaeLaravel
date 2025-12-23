<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointHistory extends Model
{
    protected $table = 'point_histories';

    protected $fillable = [
        'user_id',
        'book_id',
        'points'
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
