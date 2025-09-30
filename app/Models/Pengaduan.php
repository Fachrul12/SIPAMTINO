<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? Storage::url($this->foto) : null;
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
