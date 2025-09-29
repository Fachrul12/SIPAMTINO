<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurbiditySummary extends Model
{
    protected $fillable = ['avg', 'min', 'max', 'period'];
}
