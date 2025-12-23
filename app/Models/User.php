<?php

namespace App\Models;
use App\Models\ReadingProgress;
use App\Models\PointHistory;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'username',
        'email',
        'telepon',
        'password',
        'points', // ✅ TAMBAHAN
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* =====================
       RELATION (OPTIONAL)
       ===================== */

    // relasi ke reading_progress
    public function readingProgress()
    {
        return $this->hasMany(ReadingProgress::class);
    }

    // relasi ke point_histories
    public function pointHistories()
    {
        return $this->hasMany(PointHistory::class);
    }

    // helper nama lengkap (opsional)
    public function getNamaLengkapAttribute()
    {
        return $this->nama_depan . ' ' . $this->nama_belakang;
    }
}
