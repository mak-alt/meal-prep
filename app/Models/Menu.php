<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    use HasFactory;

    public const THUMB_UPLOAD_BASE_PATH = 'public/uploads/menus';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'points',
        'calories',
        'fats',
        'carbs',
        'proteins',
        'description',
        'weekly_menu',
        'status',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'status'      => 'boolean',
        'weekly_menu' => 'boolean',
    ];

    /**
     * @param string $value
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = ucfirst($value);
    }

    /**
     * @param string|null $value
     */
    public function setDescriptionAttribute(?string $value): void
    {
        if ($value) {
            $this->attributes['description'] = ucfirst($value);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function updateMenu(array $data): bool
    {
        if ($data['status']) {
            Menu::where('category_id', $data['category_id'])
                ->where('id', '!=', $this->id)
                ->get()
                ->map(function ($menu) {
                    $menu->update(['status' => false]);
                });
        }

        $this->update($data);

        $this->meals()->detach();

        foreach ($data['meal_ids'] as $id){
            $this->meals()->attach($id);
        }

        MealMenuSide::where('menu_id', $this->id)->delete();
        foreach ($data['meal_side_ids'] as $mealId => $sides) {
            foreach ($sides as $times => $sideIds){
                foreach ($sideIds as $sideId) {
                    MealMenuSide::create([
                        'menu_id' => $this->id,
                        'meal_id' => $mealId,
                        'side_id' => $sideId,
                        'times' => $times,
                    ]);
                }
            }
        }

        return true;
    }

    /**
     * @param array $data
     * @return static|null
     */
    public static function storeMenu(array $data): ?self
    {
        if ($data['status']) {
            Menu::where('category_id', $data['category_id'])->get()->map(function ($menu) {
                $menu->update(['status' => false]);
            });
        }

        $menu = self::create($data);

        foreach ($data['meal_ids'] as $id){
            $menu->meals()->attach($id);
        }

        foreach ($data['meal_side_ids'] as $mealId => $sides) {
            foreach ($sides as $times => $sideIds){
                foreach ($sideIds as $sideId) {
                    MealMenuSide::create([
                        'menu_id' => $menu->id,
                        'meal_id' => $mealId,
                        'side_id' => $sideId,
                        'times' => $times,
                    ]);
                }
            }
        }

        return $menu;
    }
}
