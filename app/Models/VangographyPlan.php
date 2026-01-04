<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VangographyPlan extends Model
{
    use HasFactory;
    protected $fillable=['plan_name','size','price'];
}
