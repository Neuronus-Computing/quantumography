<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\StorageUrlCast;

class FilePass extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'file_name',
        'size',
        'path',
        'order_no',
        'qr_code',
        'expiration_date',
        'password',
        'password_protected'
    ];
    protected $casts = [
        'qr_code'=> StorageUrlCast::class,
        'path'=>StorageUrlCast::class,
    ];
}
