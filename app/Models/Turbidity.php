<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turbidity extends Model
{
    protected $table = 'turbidity'; // nama tabel di database

    protected $fillable = [
        'turbidity',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];
}
