<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemakaian extends Model
{
    protected $fillable = ['pelanggan_id', 'periode', 'meter_awal', 'meter_akhir', 'total_pakai', 'tagihan'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
