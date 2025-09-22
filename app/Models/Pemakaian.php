<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemakaian extends Model
{
    protected $table = 'pemakaians';
    protected $fillable = ['pelanggan_id', 'periode_id', 'meter_awal', 'meter_akhir', 'total_pakai', 'tagihan'];
    protected $appends = ['status'];

    protected static function booted()
    {
        static::created(function ($pemakaian) {
            // Ambil tarif dari pelanggan
            $pelanggan = $pemakaian->pelanggan;
            $tarif = $pelanggan?->tarif;

            if ($tarif) {
                $jumlahBayar = ($pemakaian->total_pakai * $tarif->biaya_per_m3) + $tarif->beban;

                // Buat pembayaran otomatis
                \App\Models\Pembayaran::create([
                    'pemakaian_id' => $pemakaian->id,
                    'periode_id'   => $pemakaian->periode_id,
                    'jumlah_bayar' => $jumlahBayar,
                    'status'       => 'belum_lunas',
                    'tanggal_bayar' => null,
                ]);
            }
        });
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'pemakaian_id');
    }

    public function getStatusAttribute()
    {
        return $this->pembayaran()->exists() ? 'Lunas' : 'Belum Lunas';
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

}
