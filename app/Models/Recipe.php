<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    use HasFactory;

    public const DEFAULT_IMAGE_PATH = 'assets/backend/img/empty.jpg';
    public const IMAGE_UPLOAD_BASE_PATH = 'public/uploads/recipes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meal_id',
        'title',
        'image',
        'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }

    /**
     * @param string|null $value
     * @return string
     */
    public function getImageAttribute(?string $value): string
    {
        return ($value && file_exists(public_path($value))) ? $value : self::DEFAULT_IMAGE_PATH;
    }

}
