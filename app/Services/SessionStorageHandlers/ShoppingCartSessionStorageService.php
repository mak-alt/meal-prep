<?php

namespace App\Services\SessionStorageHandlers;

use App\Models\Addon;
use App\Models\Meal;
use App\Models\Menu;
use App\Models\MenuPlanPrice;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ShoppingCartSessionStorageService
{
    public const SESSION_KEY = 'shopping-cart';

    /**
     * @param bool|null $selectionCompleted
     * @return bool
     */
    public static function store(?bool $selectionCompleted = null): bool
    {
        $isFreeMealsSelection = (bool)session()->get(Order::ONBOARDING_SESSION_KEYS['free_meals_selection']);
        $categoryId           = session()->get(Order::ONBOARDING_SESSION_KEYS['preferred_menu_type_selection']);

        if (!$isFreeMealsSelection && !(bool)$categoryId) {
            return false;
        }

        if ($isFreeMealsSelection) {
            $selectionData = [
                'items'               => MealsSessionStorageService::getIds(),
                'addons'              => AddonsSessionStorageService::getIds(),
                'menu_id'             => null,
                'category_id'         => null,
                'selection_completed' => $selectionCompleted ?? true,
                'meals_amount'        => session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']),
                'portion_size'        => MealsSessionStorageService::getPortionSize(),
            ];
        } else {
            $items     = [];
            $menu      = Menu::where('category_id', $categoryId)->where('status', true)->latest()->first();
            $mealSides = [];
            foreach ($menu->meals as $meal){
                $mealSides[$meal->id] = $meal->menuSides()->where('menu_id', $menu->id)->get()->groupBy('pivot.times')->map(fn($item) => $item->pluck('id'))->toArray();
            }

            $menuMeals = $menu->meals;
            $mealMenusArray = collect();
            foreach ($mealSides as $id => $times){
                if (!empty($times)){
                    $mealsById = $menuMeals->where('id', $id);
                    foreach ($times as $sideIds){
                        $sidesArray = [];
                        foreach ($sideIds as $sideid){
                            $side = Meal::find($sideid);
                            if ($side->status) $sidesArray[] = $side->id;
                        }
                        $meal = $mealsById->shift();
                        $meal->selected_sides = $sidesArray;
                        $mealMenusArray[] =$meal;
                    }
                }
                else {
                    $mealsById = $menuMeals->where('id', $id);
                    foreach ($mealsById as $meal){
                        $mealMenusArray->push($meal);
                    }
                }
            }

            foreach ($mealMenusArray as $meal) {
                if ($meal->status){
                    $items[] = [$meal->id, 'sides' => $meal->selected_sides];
                }
            }

            $selectionData = [
                'items'               => $items,
                'addons'              => AddonsSessionStorageService::getIds(),
                'menu_id'             => $menu->id,
                'selection_completed' => $selectionCompleted ?? true,
                'meals_amount'        => $menu->meals->where('status', true)->count(),
                'portion_size'        => MealsSessionStorageService::getPortionSize(),
            ];
        }

        $uuid = Str::uuid();

        session()->put(self::SESSION_KEY . ".$uuid", $selectionData);
        session()->put(Order::ONBOARDING_SESSION_KEYS['current_meal_selection_uuid'], $uuid);

        return true;
    }

    /**
     * @param bool|null $selectionCompleted
     * @return bool
     */
    public static function updateOrStore(bool $selectionCompleted): bool
    {
        if (session()->has(Order::ONBOARDING_SESSION_KEYS['current_meal_selection_uuid'])) {
            $uuid       = session()->get(Order::ONBOARDING_SESSION_KEYS['current_meal_selection_uuid']);
            $sessionKey = self::SESSION_KEY . ".$uuid";

            $sessionData = session()->get($sessionKey);

            if (empty($sessionData['menu_id'])){
                if (count(MealsSessionStorageService::getIds() ?? []) > 0){
                    $sessionData['items']               = MealsSessionStorageService::getIds();
                }
                $sessionData['menu_id']             = null;
            }
            $sessionData['portion_size']        = MealsSessionStorageService::getPortionSize();
            $sessionData['selection_completed'] = $selectionCompleted;
            $sessionData['meals_amount'] = session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']);

            if (count(AddonsSessionStorageService::getIds() ?? []) > 0){
                $sessionData['addons']          = AddonsSessionStorageService::getIds();
            }

            if ($selectionCompleted){
                if (count($sessionData['addons'] ?? []) > 0){
                    foreach ($sessionData['addons'] as $key => $value){
                        $addon = Addon::find($key);
                        $sessionData['addons'][$key]['price'] = 0;
                        foreach ($value as $id){
                            $item = $addon->meals()->where('meals.id', $id)->first();
                            if (isset($sessionData['addons'][$key]['price'])){
                                $sessionData['addons'][$key]['price'] += $item->pivot->price ?? 0;
                            }
                        }
                    }
                }
                AddonsSessionStorageService::forgetAllIds();
            }
            session()->put($sessionKey, $sessionData);

            foreach (session()->get(self::SESSION_KEY) as $uuid => $value){
                $sessionData = $value;
                if ($sessionData['menu_id'] !== null && $sessionData['selection_completed'] === false){
                    $sessionData['selection_completed'] = true;
                    $sessionData['portion_size']        = MealsSessionStorageService::getPortionSize();
                    session()->put(self::SESSION_KEY.".$uuid",$sessionData);
                }
            }
        } else {
            self::store($selectionCompleted);
        }

        return true;
    }

    /**
     * @param \App\Models\Order $order
     * @return bool
     */
    public static function repeatOrder(Order $order): bool
    {
        $order->load(['orderItems.orderItemables.children', 'orderItems.menu']);

        $shoppingCartData = [];

        foreach ($order->orderItems as $index => $orderItem) {
            $itemsData          = [];
            $addonsData         = [];
            $selectionCompleted = true;

            if ($orderItem->menu_id !== null) {
                $menu = $orderItem->menu;

                if ($menu) {
                    foreach ($menu->meals as $menuMealIndex => $menuMeal) {
                        $itemsData[$menuMealIndex + 1] = [
                            $menuMeal->id,
                            'sides' => $menuMeal->menuSides()->where('meal_menu_side.menu_id', $menu->id)->get()->pluck('id')->toArray(),
                        ];
                    }
                }
            } else {
                $i = 1;
                foreach ($orderItem->orderItemables->whereNull('parent_id')->where('order_itemable_type', Meal::class) as $orderItemableMeal) {
                    if (Meal::where('id', $orderItemableMeal->order_itemable_id)->exists()) {
                        $entryMealSelectedSideIds = array_intersect(
                            $orderItemableMeal->children->pluck('order_itemable_id')->toArray(),
                            Meal::find($orderItemableMeal->order_itemable_id)->sides->pluck('id')->toArray()
                        );

                        $itemsData[$i] = [
                            $orderItemableMeal->order_itemable_id,
                            'sides' => $entryMealSelectedSideIds,
                        ];
                    } else {
                        $selectionCompleted = false;
                    }

                    $i++;
                }
            }

            foreach ($orderItem->orderItemables->whereNull('parent_id')->where('order_itemable_type', Addon::class) as $orderItemableAddon) {
                if (Addon::where('id', $orderItemableAddon->order_itemable_id)->exists()) {
                    $addonSelectedMealIds = array_intersect(
                        $orderItemableAddon->children->pluck('order_itemable_id')->toArray(),
                        Addon::find($orderItemableAddon->order_itemable_id)->meals->pluck('id')->toArray()
                    );

                    $addonsData[$orderItemableAddon->order_itemable_id] = $addonSelectedMealIds;
                }
            }

            if ($orderItem->menu_id === null || !empty($menu)) {
                $shoppingCartData[$index] = [
                    'items'               => $itemsData,
                    'addons'              => $addonsData,
                    'menu_id'             => !empty($menu) ? $menu->id : null,
                    'selection_completed' => $selectionCompleted,
                    'meals_amount'        => !empty($menu) ? count($itemsData) : (count($itemsData) >= 5 ? count($itemsData) : 5),
                    'portion_size'        => $order->portion_size,
                ];
            }

            unset($menu);
        }

        ShoppingCartSessionStorageService::forgetAllOnboardingData();
        session()->forget(ShoppingCartSessionStorageService::SESSION_KEY);

        foreach ($shoppingCartData as $shoppingCartItemData) {
            $uuid = Str::uuid();

            session()->put(self::SESSION_KEY . ".$uuid", $shoppingCartItemData);
            session()->put(Order::ONBOARDING_SESSION_KEYS['current_meal_selection_uuid'], $uuid);
        }

        return true;
    }

    /**
     * @param string $uuid
     * @return int|null
     */
    public static function completeMenu(string $uuid): ?int
    {
        $data = self::getStoredData($uuid);

        session()->forget(Order::ONBOARDING_SESSION_KEYS['preferred_menu_type_selection']);
        session()->put(Order::ONBOARDING_SESSION_KEYS['current_meal_selection_uuid'], $uuid);
        session()->put(MealsSessionStorageService::MEALS_SELECTION_SESSION_KEY, $data['items']);
        MealsSessionStorageService::setPortionSize($data['portion_size']);
        session()->forget([AddonsSessionStorageService::ADDONS_SELECTION_SESSION_KEY, AddonsSessionStorageService::ADDON_MEALS_SELECTION_SESSION_KEY]);
        foreach ($data['addons'] ?? [] as $addonId => $addonSelectedMealIds) {
            AddonsSessionStorageService::pushAddonId($addonId);
            foreach ($addonSelectedMealIds as $addonSelectedMealId) {
                AddonsSessionStorageService::pushId($addonId, $addonSelectedMealId);
            }
        }
        session()->put(Order::ONBOARDING_SESSION_KEYS['free_meals_selection'], true);
        session()->put(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection'], $data['meals_amount']);

        $firstMealNumberWithWarning = null;
        foreach ($data['items'] ?? [] as $mealNumber => $data) {
            if (!empty($data[0]) && is_int($data[0])) {
                if (!empty($data['sides']) && count($data['sides']) >= 2) {
                    session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber", true);
                } else {
                    session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber.sides", true);

                    if (!is_int($firstMealNumberWithWarning)) {
                        $firstMealNumberWithWarning = $mealNumber;
                    }
                }
            } else {
                session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber.entry", true);

                if (!empty($data['sides']) && count($data['sides']) < 2) {
                    session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber.sides", true);
                }

                if (!is_int($firstMealNumberWithWarning)) {
                    $firstMealNumberWithWarning = $mealNumber;
                }
            }
        }

        return $firstMealNumberWithWarning;
    }

    /**
     * @param string $uuid
     * @return bool
     */
    public static function duplicateStoredData(string $uuid): bool
    {
        $sessionKey = self::SESSION_KEY . '.' . Str::uuid();

        session()->put($sessionKey, self::getStoredData($uuid));

        return true;
    }

    /**
     * @param string $uuid
     * @return bool
     */
    public static function hasStoredData(string $uuid): bool
    {
        return !empty(session()->get(self::SESSION_KEY . ".$uuid"));
    }

    /**
     * @return mixed
     */
    public static function getStoredData(?string $uuid = null)
    {
        $sessionKey = self::SESSION_KEY;

        if ($uuid) {
            $sessionKey .= ".$uuid";
        }

        return session()->get($sessionKey);
    }

    /**
     * @return int
     */
    public static function countStoredItems(): int
    {
        return count(session()->get(self::SESSION_KEY, []));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getMappedStoredData(): Collection
    {
        $storedData = collect(self::getStoredData());
        //dd($storedData);
        $storedData->mapWithKeys(function (array $data, string $uuid) use ($storedData) {
            if (empty($data['items'])) {
                ShoppingCartSessionStorageService::forget($uuid);

                $storedData->forget($uuid);
            } else {
                $menu                     = Menu::find($data['menu_id']);
                $itemsMapped              = [];
                $itemsMicronutrientsData  = collect();
                $addonsMapped             = [];
                $addonsMicronutrientsData = collect();
                $totalPrice               = optional($menu)->price ?? 0;
                $totalPoints              = optional($menu)->points ?? 0;
                $itemsAmount              = 0;

                foreach ($data['items'] ?? [] as $itemsData) {
                    $entryMeal = Meal::find($itemsData[0] ?? null);
                    $sides     = [];

                    if (!array_key_exists('sides', $itemsData)) {
                        $itemsData['sides'] = [];
                    }
                    if ($itemsData['sides'] !== null){
                        foreach ($itemsData['sides'] as $sideId) {
                            if ($entryMeal && $entryMeal->sides()->count() > 0){
                                $sides[] = $entryMeal->sides()->where('meals.id', $sideId)->first();
                            }
                            else{
                                $sides[] = Meal::find($sideId);
                            }
                        }
                    }
                    else $sides = [];


                    $itemsMapped[] = [$entryMeal, 'sides' => $sides];
                    $itemsAmount   += 1 + count($sides);

                    if (!$menu) {
                        $itemsMicronutrientsData->push(Meal::getMicronutrientsData(collect($sides)->push($entryMeal)));
                    }

                    if ($data['menu_id'] === null) {
                        $totalPrice  += (int)($entryMeal->price ?? 0) + collect($sides)->sum('pivot.price');
                        $totalPoints += ($entryMeal->points ?? 0) + collect($sides)->sum('pivot.points');
                    }
                }
                if ($data['menu_id'] === null) {
                    $priceOfMeal = MenuPlanPrice::where('count',$storedData[$uuid]['meals_amount'])->first()->price ?? (Setting::key('avg_price')->first()->data * $storedData[$uuid]['meals_amount']) ?? 0;;
                    $totalPrice += $priceOfMeal;
                }


                if ($menu) {
                    $itemsMicronutrientsData->push(collect([
                        'calories' => $menu->calories ?? 0,
                        'fats'     => $menu->fats ?? 0,
                        'carbs'    => $menu->carbs ?? 0,
                        'proteins' => $menu->proteins ?? 0,
                    ]));
                }

                foreach ($data['addons'] ?? [] as $addonId => $addonSelectedMealIds) {
                    $addon      = Addon::find($addonId);
                    $addonMeals = [];

                    foreach ($addonSelectedMealIds as $key => $addonSelectedMealId) {
                        if ($key !== "price"){
                            $addonMeals[] = $addon->meals()->where('meals.id', $addonSelectedMealId)->first();
                        }
                    }

                    $addonsMapped[]       = [$addon, 'meals' => $addonMeals, 'price' => $data['addons'][$addonId]['price'] ?? 0];
                    $addonMealsCollection = collect($addonMeals);
                    $addonsMicronutrientsData->push(Meal::getMicronutrientsData($addonMealsCollection));
                    $totalPrice  += $addonMealsCollection->sum('pivot.price');
                    $totalPoints += $addonMealsCollection->sum('pivot.points');
                }

                $data['items']               = $itemsMapped;
                $data['addons']              = $addonsMapped;
                $data['items_amount']        = $itemsAmount;
                $data['micronutrients_data'] = [
                    'calories' => $itemsMicronutrientsData->sum('calories') + $addonsMicronutrientsData->sum('calories'),
                    'fats'     => $itemsMicronutrientsData->sum('fats') + $addonsMicronutrientsData->sum('fats'),
                    'carbs'    => $itemsMicronutrientsData->sum('carbs') + $addonsMicronutrientsData->sum('carbs'),
                    'proteins' => $itemsMicronutrientsData->sum('proteins') + $addonsMicronutrientsData->sum('proteins'),
                ];
                $data['total_price']         = $totalPrice + calculatePercentageValueFromNumber($data['portion_size']['percentage'] ?? 0, $totalPrice);
                $data['total_points']        = $data['total_price'] * 10;
                $data['menu']                = $menu;

                $storedData[$uuid] = $data;
            }

            return $data;
        });

        return $storedData;
    }

    /**
     * @param string|null $uuid
     * @return bool
     */
    public static function forget(?string $uuid = null): bool
    {
        $sessionKey = self::SESSION_KEY;

        if ($uuid) {
            $sessionKey .= ".$uuid";
        }

        session()->forget($sessionKey);

        return true;
    }

    /**
     * @return bool
     */
    public static function forgetAllOnboardingData(): bool
    {
        session()->forget([
            ...array_values(Order::ONBOARDING_SESSION_KEYS),
            MealsSessionStorageService::MEALS_SELECTION_SESSION_KEY,
            MealsSessionStorageService::MEALS_PORTION_SIZE_SESSION_KEY,
            AddonsSessionStorageService::ADDONS_SELECTION_SESSION_KEY,
            AddonsSessionStorageService::ADDON_MEALS_SELECTION_SESSION_KEY,
            'response-message',
            'response-message-style',
        ]);

        return true;
    }

    public static function checkForEmpty(): bool
    {
        $shoppingCartOrders = ShoppingCartSessionStorageService::getMappedStoredData();
        foreach ($shoppingCartOrders as $uuid => $order){
            if ($order['menu_id'] === null && count($order['items']) !== (int)$order['meals_amount']){
                $return = true;
            }
        }

        return $return ?? false;
    }
}
