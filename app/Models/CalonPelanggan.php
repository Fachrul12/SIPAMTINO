<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CalonPelanggan extends Model
{
    protected $fillable = [
        'name',
        'email', 
        'no_hp',
        'password',
        'tarif_id',
        'ktp_path',
        'status',
        'keterangan',
        'processed_at',
        'processed_by'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function approve($userId, $keterangan = null)
    {
        $this->update([
            'status' => 'approved',
            'processed_at' => now(),
            'processed_by' => $userId,
            'keterangan' => $keterangan
        ]);

        // Buat user dan pelanggan baru dengan password yang dipilih user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'no_hp' => $this->no_hp,
            'password' => $this->password, // gunakan password dari calon pelanggan
            'role_id' => Role::where('name', 'pelanggan')->value('id'),
        ]);

        Pelanggan::create([
            'user_id' => $user->id,
            'tarif_id' => $this->tarif_id,
            'no_hp' => $this->no_hp,
        ]);
    }

    public function reject($userId, $keterangan)
    {
        $this->update([
            'status' => 'rejected',
            'processed_at' => now(),
            'processed_by' => $userId,
            'keterangan' => $keterangan
        ]);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessed($query)
    {
        return $query->whereIn('status', ['approved', 'rejected']);
    }
}
