<?php

namespace App\Models;

use App\Services\FileUploaders\StorageFileUploadService;
use App\Services\SessionStorageHandlers\MealsSessionStorageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class Meal extends Model
{
    use HasFactory;

    public const THUMB_UPLOAD_BASE_PATH = 'public/uploads/meals';
    public const NO_THUMB_PATH = 'assets/frontend/img/no-meal-thumb.png';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'price',
        'points',
        'thumb',
        'calories',
        'fats',
        'carbs',
        'proteins',
        'description',
        'tags',
        'type',
        'order_id',
        'side_count',
        'status',
    ];

    /**
     * @var string[]
     */
    protected $casts = ['tags' => 'array'];

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
     * @param string|null $value
     * @return string
     */
    public function getThumbAttribute(?string $value): string
    {
        return $value ?: self::NO_THUMB_PATH;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sides(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'meal_side', 'meal_id', 'side_id')
            ->withPivot(['price', 'points']);
    }

    public function sidesActive(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'meal_side', 'meal_id', 'side_id')
            ->withPivot(['price', 'points'])->where('status', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sideFor(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'meal_side', 'side_id', 'meal_id');
    }

    public function mealFor(): BelongsToMany
    {
        return $this->belongsToMany(Addon::class, 'addon_meal', 'meal_id', 'addon_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menuSides(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'meal_menu_side', 'meal_id', 'side_id')->withPivot('times');
    }

    /**
     * @param array $data
     * @return bool
     */
    public function updateMeal(array $data): bool
    {
        if (!empty($data['thumb']) && $data['thumb'] instanceof UploadedFile) {
            $uploadedPath = StorageFileUploadService::store(self::THUMB_UPLOAD_BASE_PATH, $data['thumb']);

            if (!$uploadedPath) {
                return false;
            }

            $data['thumb'] = $uploadedPath;
        }

        $data['status'] = isset($data['status']);

        if (empty($data['tags'])) {
            $data['tags'] = [];
        }

        $this->update($data);

//        $this->categories()->sync($data['category_ids'] ?? []);
        $this->ingredients()->sync($data['ingredient_ids'] ?? []);

        $sidesData = [];
        foreach ($data['side_prices'] ?? [] as $mealId => $price) {
            $sidesData[$mealId] = ['price' => $price, 'points' => $data['side_points'][$mealId]];
        }
        $this->sides()->sync($sidesData);

        return true;
    }

    public function updateSide(array $data): bool
    {
        if (!empty($data['thumb']) && $data['thumb'] instanceof UploadedFile) {
            $uploadedPath = StorageFileUploadService::store(self::THUMB_UPLOAD_BASE_PATH, $data['thumb']);

            if (!$uploadedPath) {
                return false;
            }

            $data['thumb'] = $uploadedPath;
        }
        $data['status'] = isset($data['status']);
        if (empty($data['tags'])) {
            $data['tags'] = [];
        }

        $this->update($data);

//        $this->categories()->sync($data['category_ids'] ?? []);
        $this->ingredients()->sync($data['ingredient_ids'] ?? []);

        return true;
    }

    public function updateAddon(array $data): bool
    {
        if (!empty($data['thumb']) && $data['thumb'] instanceof UploadedFile) {
            $uploadedPath = StorageFileUploadService::store(self::THUMB_UPLOAD_BASE_PATH, $data['thumb']);

            if (!$uploadedPath) {
                return false;
            }

            $data['thumb'] = $uploadedPath;
        }

        if (empty($data['tags'])) {
            $data['tags'] = [];
        }

        $this->update($data);

        $this->ingredients()->sync($data['ingredient_ids'] ?? []);
//        $this->mealFor()->sync($data['category_ids'] ?? []);
        return true;
    }

    /**
     * @param array $data
     * @return static|null
     */
    public static function storeMeal(array $data): ?self
    {
        $uploadedPath = StorageFileUploadService::store(self::THUMB_UPLOAD_BASE_PATH, $data['thumb']);

        if (!$uploadedPath) {
            return null;
        }

        $data['thumb'] = $uploadedPath;

        if (empty($data['tags'])) {
            $data['tags'] = [];
        }

        $data['status'] = isset($data['status']);
        $data['type'] = 'entry';

        $meal = self::create($data);

//        $meal->categories()->sync($data['category_ids'] ?? []);
        $meal->ingredients()->sync($data['ingredient_ids'] ?? []);

        $sidesData = [];
        foreach ($data['side_prices'] ?? [] as $mealId => $price) {
            $sidesData[$mealId] = ['price' => $price, 'points' => $data['side_points'][$mealId]];
        }
        $meal->sides()->sync($sidesData);

        return $meal;
    }

    public static function storeSide(array $data): ?self
    {
        $uploadedPath = StorageFileUploadService::store(self::THUMB_UPLOAD_BASE_PATH, $data['thumb']);

        if (!$uploadedPath) {
            return null;
        }

        $data['thumb'] = $uploadedPath;
        $data['status'] = isset($data['status']);

        if (empty($data['tags'])) {
            $data['tags'] = [];
        }
        $data['type'] = 'side';

        $meal = self::create($data);

//        $meal->categories()->sync($data['category_ids'] ?? []);
        $meal->ingredients()->sync($data['ingredient_ids'] ?? []);

        return $meal;
    }

    public static function storeAddon(array $data): ?self
    {
        $uploadedPath = StorageFileUploadService::store(self::THUMB_UPLOAD_BASE_PATH, $data['thumb']);

        if (!$uploadedPath) {
            return null;
        }

        $data['thumb'] = $uploadedPath;

        if (empty($data['tags'])) {
            $data['tags'] = [];
        }
        $data['type'] = 'addon';

        $meal = self::create($data);

        $meal->ingredients()->sync($data['ingredient_ids'] ?? []);
//        $meal->mealFor()->sync($data['category_ids'] ?? []);
        return $meal;
    }

    /**
     * @param \Illuminate\Support\Collection $meals
     * @return \Illuminate\Support\Collection
     */
    public static function getMicronutrientsData(Collection $meals): Collection
    {
        $micronutrientsData = collect([
            'calories' => 0,
            'carbs'    => 0,
            'fats'     => 0,
            'proteins' => 0,
        ]);

        $meals->map(function (?self $meal) use ($micronutrientsData) {
            if ($meal) {
                $micronutrientsData['calories'] += $meal->calories;
                $micronutrientsData['carbs']    += $meal->carbs;
                $micronutrientsData['fats']     += $meal->fats;
                $micronutrientsData['proteins'] += $meal->proteins;
            }

            return $meal;
        });

        return $micronutrientsData;
    }

    /**
     * @param int|null $mealNumber
     * @return array
     */
    public static function getMealsAndSidesStoredInSession(?int $mealNumber = null): array
    {
        $meals                    = collect();
        $sides                    = collect();
        $mealsAndSidesSessionData = MealsSessionStorageService::getIds($mealNumber);

        foreach ($mealsAndSidesSessionData as $mealNumberOrKey => $mealNumberData) {
            $meal = $mealNumberOrKey !== 'sides'
                ? self::find(is_array($mealNumberData) ? $mealNumberData[0] ?? null : $mealNumberData ?? null)
                : null;

            if ($meal) {
                $meal->meal_number = $mealNumberOrKey;
                $meals->push($meal);
            }

            if ($mealNumberOrKey === 'sides' || (is_array($mealNumberData) && array_key_exists('sides', $mealNumberData))) {
                $sideIdsStoredInSessionIdDuplicateAmountMap = collect($mealNumberOrKey === 'sides' ? $mealNumberData : $mealNumberData['sides'])
                    ->map(function (int $sideId) {
                        return compact('sideId');
                    })
                    ->groupBy('sideId')
                    ->map(function (Collection $groupedSideIds) {
                        return count($groupedSideIds);
                    });

                $sidesBuilder = $meal ? $meal->sides() : Meal::query();
                $sidesBuilder->whereIn('meals.id', $mealNumberOrKey === 'sides' ? $mealNumberData : $mealNumberData['sides'])
                    ->get()
                    ->each(function (Meal $side) use ($sides, $meal, $mealNumberOrKey, $mealNumber, $sideIdsStoredInSessionIdDuplicateAmountMap) {
                        for ($i = 0; $i < $sideIdsStoredInSessionIdDuplicateAmountMap->get($side->id); $i++) {
                            $side->meal_number = $mealNumberOrKey === 'sides' ? $mealNumber : $mealNumberOrKey;
                            $side->entry_meal  = $meal;

                            $sides->push($side);
                        }
                    });
            }
        }

        return [$meals, $sides];
    }

    /**
     * @param int $mealNumber
     * @return \Illuminate\Support\Collection
     */
    public function getSidesStoredInSession(int $mealNumber): Collection
    {
        $sides                    = collect();
        $mealsAndSidesSessionData = MealsSessionStorageService::getIds($mealNumber);

        foreach ([$mealsAndSidesSessionData] as $mealNumberData) {
            if (array_key_exists('sides', $mealNumberData)) {
                $sideIdsStoredInSessionIdDuplicateAmountMap = collect($mealNumberData['sides'])
                    ->map(function (int $sideId) {
                        return compact('sideId');
                    })
                    ->groupBy('sideId')
                    ->map(function (Collection $groupedSideIds) {
                        return count($groupedSideIds);
                    });

                $this->sides()->whereIn('meals.id', $mealNumberData['sides'])
                    ->get()
                    ->each(function (Meal $side) use ($sides, $sideIdsStoredInSessionIdDuplicateAmountMap) {
                        for ($i = 0; $i < $sideIdsStoredInSessionIdDuplicateAmountMap->get($side->id); $i++) {
                            $sides->push($side);
                        }
                    });
            }
        }

        return $sides;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function duplicateMealsToMealCreationSteps(Request $request): array
    {
        $mealsAmount         = session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']);
        $selectedMealNumbers = collect(MealsSessionStorageService::getIds())->keys();
        $meal                = $request->has('entry_meal_id') ? Meal::find($request->entry_meal_id) : null;
        $duplicatedCounter         = 0;
        for ($mealNumber = 1; $mealNumber <= $mealsAmount; $mealNumber++) {
            if (!$selectedMealNumbers->contains($mealNumber) && $duplicatedCounter < $request->amount) {
                if ($request->has('entry_meal_id')) {
                    MealsSessionStorageService::pushId($request->entry_meal_id, $mealNumber);
                }
                if ($request->filled('side_meal_ids')) {
                    foreach ($request->side_meal_ids as $sideMealId) {
                        MealsSessionStorageService::pushId($sideMealId, $mealNumber, 'sides');
                    }
                } else {
                    session()->put(MealsSessionStorageService::MEALS_SELECTION_SESSION_KEY . '.' . $mealNumber . '.sides', []);
                }

                if (!empty($meal) && (!$meal->sides()->exists() || count($request->side_meal_ids ?? []) >= 2)) {
                    session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber", true);
                } elseif (!empty($meal) && ($request->filled('side_meal_ids') || !$request->has('side_meal_ids'))) {
                    session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber.sides", true);
                } elseif (empty($meal) && count($request->side_meal_ids) === 1) {
                    session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber.entry", true);
                    session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber.sides", true);
                } else {
                    session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber.entry", true);
                }

                $duplicatedCounter++;
            }
        }
        if ($request->amount !== $request->max_duplicate_amount){
            $firstDuplicatedMealNumber = $selectedMealNumbers->count() + $request->amount+1;
        }
        else $firstDuplicatedMealNumber = $mealsAmount;

        if (!empty($meal) && !$meal->sides()->exists()) {
            $responseMessage = "Entry meal was duplicated for $request->amount meals.";
        } elseif (!empty($meal) && count($request->side_meal_ids ?? []) >= 2) {
            $responseMessage = "Entry meal and side dishes were duplicated for $request->amount meals.";
        } elseif (!empty($meal) && $request->filled('side_meal_ids')) {
            $responseMessage = "Entry meal and side dish were duplicated for $request->amount meals. Please continue to select one more side dish.";
        } elseif (!empty($meal) && !$request->has('side_meal_ids')) {
            $responseMessage = "Entry meal was duplicated for $request->amount meals. Please continue to select side dishes.";
        } elseif (empty($meal) && count($request->side_meal_ids) === 1) {
            $responseMessage = '1 side dish was selected for each meal. Please continue to select entry dishes.';
        } else {
            $responseMessage = '2 side dish was selected for each meal. Please continue to select entry dishes.';
        }

        return [$firstDuplicatedMealNumber, $responseMessage];
    }
}
