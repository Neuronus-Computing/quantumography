<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EnlargeImage extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','user_ip','image','subscription_id'];
    public function scopeCurrentMonth(Builder $query)
    {
        return $query->whereMonth('created_at', now()->month);
    }

}
