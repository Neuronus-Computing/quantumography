<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilePassPeriod extends Model
{
    use HasFactory;
    protected $fillable = [
        'period',
        'period_value',
        'type',
        'storage_bytes',
        'price',
    ];
}
