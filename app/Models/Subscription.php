<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable =[
    'user_id',
    'stripe_id',
    'stripe_price',
    'plan_name',
    'amount',
    'card',
    'currency',
    'started_at',
    'end_at',
    'cancelled_at'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
