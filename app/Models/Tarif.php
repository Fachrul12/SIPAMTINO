<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $fillable = ['nama_tarif', 'biaya_per_m3', 'beban'];

    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class);
    }
}
