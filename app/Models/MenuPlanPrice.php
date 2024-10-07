<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPlanPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'count',
        'price',
    ];
}
