<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentar';

    protected $fillable = [
        'user_id',
        'username',
        'komentar',
        'image_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
