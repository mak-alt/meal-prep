<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Ingredient extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'description'];

    /**
     * @param string $value
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = ucfirst($value);
    }

    /**
     * @param string $value
     */
    public function setDescriptionAttribute(string $value): void
    {
        $this->attributes['description'] = ucfirst($value);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function updateIngredient(array $data): bool
    {
        return $this->update($data);
    }

    /**
     * @param array $data
     * @return static|null
     */
    public static function storeIngredient(array $data): ?self
    {
        return self::create($data);
    }
}
