<?php

namespace App\Models;

use App\Services\FileUploaders\StorageFileUploadService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    public const CACHE_KEY = 'categories';
    public const THUMB_UPLOAD_BASE_PATH = 'public/uploads/categories';

    public const KEYS = [
        'healthy_mix' => 'healthy_mix',
        'paleo'       => 'paleo',
        'keto'        => 'keto',
        'w30'         => 'w30',
        'vegan'       => 'vegan',
    ];

    /**
     * @var string[]
     */
    protected $fillable = ['key', 'name', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(Addon::class)->with('meals');
    }

    public function meals() : BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'category_meal','category_id','meal_id');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getCategories(): Collection
    {
        return Category::all(['id', 'key', 'name', 'description']);
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function updateCategory(array $data): bool
    {
        $this->update($data);

        if (isset($data['thumb']) && is_array($data['thumb'])){
            if ($this->images()->count() > 0){
                $this->images()->delete();
            }

            foreach ($data['thumb'] as $file){
                if ($file instanceof UploadedFile) {
                    $uploadedPath = StorageFileUploadService::store(self::THUMB_UPLOAD_BASE_PATH, $file);

                    if (!$uploadedPath) {
                        return false;
                    }

                    $this->images()->create([
                        'img' => $uploadedPath,
                        'name' => $file->getClientOriginalName()
                    ]);
                }
            }
        }

        return self::clearCache();
    }

    /**
     * @param array $data
     * @return static|null
     * @throws \Exception
     */
    public static function storeCategory(array $data): ?self
    {
        $category = self::create($data);

        if (isset($data['thumb']) && is_array($data['thumb'])){
            if ($category->images()->count() > 0){
                $category->images()->delete();
            }

            foreach ($data['thumb'] as $file){
                if ($file instanceof UploadedFile) {
                    $uploadedPath = StorageFileUploadService::store(self::THUMB_UPLOAD_BASE_PATH, $file);

                    if (!$uploadedPath) {
                        return false;
                    }

                    $category->images()->create([
                        'img' => $uploadedPath,
                        'name' => $file->getClientOriginalName()
                    ]);
                }
            }
        }

        self::clearCache();

        return $category;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private static function clearCache(): bool
    {
        return cache()->forget(Category::CACHE_KEY);
    }

    public function images()
    {
        return $this->hasMany(CategoryImage::class, 'category_id', 'id');
    }
}
