<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'url',
        'parent_id'
    ];

    public function childCategories(){
        return $this->hasMany(AdminMenu::class,'parent_id','id');
    }
}
