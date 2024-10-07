<?php

namespace App\Models;

use App\Services\SessionStorageHandlers\AddonsSessionStorageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Addon extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'required_minimum_meals_amount',
    ];

    /**
     * @param string $value
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = ucfirst($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class)->withPivot(['price', 'points']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function updateAddon(array $data): bool
    {
        $this->update($data);
        $this->categories()->sync($data['category_ids'] ?? []);

        $mealsData = [];
        foreach ($data['meal_prices'] as $mealId => $price) {
            $mealsData[$mealId] = ['price' => $price, 'points' => $data['meal_points'][$mealId]];
        }
        $this->meals()->sync($mealsData);

        return true;
    }

    /**
     * @param array $data
     * @return static|null
     */
    public static function storeAddon(array $data): ?self
    {
        $addon = self::create($data);

        $addon->categories()->sync($data['category_ids'] ?? []);

        $mealsData = [];
        foreach ($data['meal_prices'] as $mealId => $price) {
            $mealsData[$mealId] = ['price' => $price, 'points' => $data['meal_points'][$mealId]];
        }
        $addon->meals()->sync($mealsData);

        return $addon;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAddonMealsStoredInSession(): Collection
    {
        $meals                  = collect();
        $mealIdsStoredInSession = collect(AddonsSessionStorageService::getIds($this->id) ?? []);

        $mealIdsStoredInSessionIdDuplicateAmountMap = collect($mealIdsStoredInSession)
            ->map(function (int $mealId) {
                return compact('mealId');
            })
            ->groupBy('mealId')
            ->map(function (Collection $groupedMealIds) {
                return count($groupedMealIds);
            });

        self::meals()->whereIn('meals.id', $mealIdsStoredInSession)
            ->get()
            ->each(function (Meal $meal) use ($meals, $mealIdsStoredInSessionIdDuplicateAmountMap) {
                for ($i = 0; $i < $mealIdsStoredInSessionIdDuplicateAmountMap->get($meal->id); $i++) {
                    $meals->push($meal);
                }
            });

        return $meals;
    }
}
