<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_pengaduan',
        'foto',
        'deskripsi',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($pengaduan) {
            if (Auth::check()) {
                $pengaduan->user_id = Auth::id();
            }
        });
    }

}
