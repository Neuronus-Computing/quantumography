<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\StorageUrlCast;

class TextPass extends Model
{
    use HasFactory;
    protected $fillable = ['text', 'password_protected', 'password', 'is_read','qr_code'];
     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'qr_code'=> StorageUrlCast::class,
    ];


}
