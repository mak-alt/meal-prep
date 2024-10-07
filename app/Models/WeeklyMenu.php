<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'data',
        'seo_title',
        'seo_description',
    ];

    protected $casts = ['data' => 'array'];
}
