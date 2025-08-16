<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{

    protected $table = 'pembayarans';
    protected $fillable = [
        'pemakaian_id',
        'periode_id',
        'jumlah_bayar',
        'status',
        'tanggal_bayar',
    ];

    public function pemakaian()
{
    return $this->belongsTo(Pemakaian::class);
}

public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

}
