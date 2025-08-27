<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = ['user_id', 'tarif_id', 'no_hp',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
    static::deleting(function ($pelanggan) {
        $pelanggan->user()->delete();
    });
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }

    public function pemakaians()
    {
        return $this->hasMany(Pemakaian::class);
    }
}
