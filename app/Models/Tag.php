<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['name'];

    /**
     * @param string $value
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = ucfirst($value);
    }
}
