<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $fillable = [
        'nama_periode',
        'bulan',
        'tahun',
        'status',
    ];

    public function pemakaians()
    {
        return $this->hasMany(Pemakaian::class);
    }
}
