<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\OrderAndMenu\Addons\ToggleMealSelectionRequest;
use App\Models\Addon;
use App\Models\Meal;
use App\Models\Menu;
use App\Models\MenuPlanPrice;
use App\Models\Order;
use App\Models\Setting;
use App\Services\SessionStorageHandlers\AddonsSessionStorageService;
use App\Services\SessionStorageHandlers\MealsSessionStorageService;
use App\Services\SessionStorageHandlers\ShoppingCartSessionStorageService;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Addon $addon
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, Addon $addon)
    {
        $categoryId        = session()->has(Order::ONBOARDING_SESSION_KEYS['preferred_menu_type_selection'])
            ? (int)session()->get(Order::ONBOARDING_SESSION_KEYS['preferred_menu_type_selection'])
            : null;
        $freeMenuSelection = session()->get(Order::ONBOARDING_SESSION_KEYS['free_meals_selection']);

        if (!in_array($categoryId, $addon->categories->pluck('id')->toArray()) && !$freeMenuSelection) {
            return redirect()->route('frontend.landing.index');
        }

        $addon->load(['meals' => function (BelongsToMany $query) use ($request) {
            if ($request->ajax() && $request->filled('sort')) {
                $query->orderBy($request->sort['column'], $request->sort['direction']);
            }
        }]);

        if ($freeMenuSelection) {
            [$selectedMeals, $selectedSides] = Meal::getMealsAndSidesStoredInSession();
            $freeMenuSelectionMeals  = $selectedMeals->merge($selectedSides);
            $menu                    = null;
            $meals                   = collect();
            $mealsMicronutrientsData = Meal::getMicronutrientsData($freeMenuSelectionMeals ?? collect());
        } else {
            $selectedMeals           = collect();
            $selectedSides           = collect();
            $freeMenuSelectionMeals  = collect();
            $menu                    = Menu::where('category_id', $categoryId)->where('status', true)->latest()->first();
            $meals                   = optional($menu)->meals ?? collect();
            $mealsMicronutrientsData = collect([
                'calories' => $menu->calories ?? 0,
                'fats'     => $menu->fats ?? 0,
                'carbs'    => $menu->carbs ?? 0,
                'proteins' => $menu->proteins ?? 0,
            ]);
        }

        $addonMealsSelectedAmount     = AddonsSessionStorageService::countIds($addon->id);
        $selectedAddonMeals           = $addon->getAddonMealsStoredInSession();
        $allSelectedAddonMeals        = Addon::findMany(AddonsSessionStorageService::getAddonIds() ?? [])->map->getAddonMealsStoredInSession()->flatten();
        $selectedAddonMealsPoints     = $selectedAddonMeals->sum('pivot.points');
        $selectedAddonMealsPrice      = $allSelectedAddonMeals->sum('pivot.price');
        $selectedPortionSize          = MealsSessionStorageService::getPortionSize();
        $addonMealsMicronutrientsData = Meal::getMicronutrientsData($allSelectedAddonMeals);
        $mealsAmount                  = session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']);
        $priceOfMeal = MenuPlanPrice::where('count',$mealsAmount)->first()->price ?? (Setting::key('avg_price')->first()->data * $mealsAmount) ?? 0;
        if ($menu){
            $priceOfMeal = 0;
        }
        $totalPriceWithoutPortionSize = !$freeMenuSelection
            ? (optional($menu)->price ?? $meals->sum('price')) + $selectedAddonMealsPrice + $priceOfMeal
            : $selectedMeals->sum('price') + $selectedSides->sum('pivot.price') + $selectedAddonMealsPrice + $priceOfMeal;
        $totalPrice                   = $totalPriceWithoutPortionSize +
            calculatePercentageValueFromNumber($selectedPortionSize['percentage'], $totalPriceWithoutPortionSize);
        return \view('frontend.addons.show', compact(
            'selectedMeals',
            'selectedSides',
            'selectedPortionSize',
            'addon',
            'mealsMicronutrientsData',
            'freeMenuSelection',
            'categoryId',
            'meals',
            'menu',
            'addonMealsSelectedAmount',
            'addonMealsMicronutrientsData',
            'freeMenuSelectionMeals',
            'selectedAddonMeals',
            'selectedAddonMealsPoints',
            'selectedAddonMealsPrice',
            'totalPrice'
        ));
    }

    /**
     * @param \App\Http\Requests\Frontend\OrderAndMenu\Addons\ToggleMealSelectionRequest $request
     * @param \App\Models\Addon $addon
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleMealSelection(ToggleMealSelectionRequest $request, Addon $addon): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $categoryId        = session()->has(Order::ONBOARDING_SESSION_KEYS['preferred_menu_type_selection'])
                    ? (int)session()->get(Order::ONBOARDING_SESSION_KEYS['preferred_menu_type_selection'])
                    : null;
                $mealsSelectedAmount              = AddonsSessionStorageService::countIds($addon->id);
                $requiredMinimumMealsAmount       = $addon->required_minimum_meals_amount;
                $meal                             = $addon->meals()->where('meals.id', $request->meal_id)->firstOrFail();
                $selectedAddons                   = Addon::findMany(AddonsSessionStorageService::getAddonIds() ?? []);
                $selectedAddonMeals               = $selectedAddons->map->getAddonMealsStoredInSession()->flatten();
                [$selectedMeals, $selectedSides]  = Meal::getMealsAndSidesStoredInSession();
                $selectedMealsAndSides            = $selectedMeals->merge($selectedSides);
                $selectedPortionSize              = MealsSessionStorageService::getPortionSize();
                $menu                             = Menu::where('category_id', $categoryId)->where('status', true)->latest()->first();
                $mealsAmount                      = session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']);
                $priceOfMeal                      = MenuPlanPrice::where('count',$mealsAmount)->first()->price ?? (Setting::key('avg_price')->first()->data * $mealsAmount) ?? 0;

                if ($menu){
                    $priceOfMeal = $menu->price;
                }

                if ($request->operation === 'select') {
                    if ($requiredMinimumMealsAmount === $mealsSelectedAmount) {
                        return response()->json(
                            $this->formatResponse(
                                'warning',
                                'You have already selected the required amount of addon meals.'
                            )
                        );
                    }

                    AddonsSessionStorageService::pushId($addon->id, $request->meal_id);
                    $mealsSelectedAmount++;
                } else {
                    AddonsSessionStorageService::forgetId($addon->id, $request->meal_id);
                    AddonsSessionStorageService::forgetAddonId($addon->id);
                    $mealsSelectedAmount--;
                }
                ShoppingCartSessionStorageService::updateOrStore(false);
                $priceOfMeal = $priceOfMeal + ($meal->pivot->price * $mealsSelectedAmount);
                $totalPriceWithoutPortionSize = $selectedMealsAndSides->sum('price') + $selectedAddonMeals->sum('pivot.price') + $priceOfMeal;

                $totalPrice                   = $totalPriceWithoutPortionSize +
                    calculatePercentageValueFromNumber($selectedPortionSize['percentage'], $totalPriceWithoutPortionSize);

                return response()->json($this->formatResponse('success', null, [
                    'meals_selected_amount'         => $mealsSelectedAmount,
                    'required_meals_selected'       => $mealsSelectedAmount === $requiredMinimumMealsAmount,
                    'required_minimum_meals_amount' => $addon->required_minimum_meals_amount,
                    'price'                         => $meal->pivot->price,
                    'points'                        => $meal->pivot->points,
                    'micronutrients_data'           => [
                        'calories' => $meal->calories,
                        'fats'     => $meal->fats,
                        'carbs'    => $meal->carbs,
                        'proteins' => $meal->proteins,
                    ],
                    'total_price' => $totalPrice,

                ]));
            } catch (\Throwable $exception) {
                $errorMessage = $request->operation === 'select'
                    ? 'Selecting addon meal failed.'
                    : 'Unselecting addon meal failed.';

                return response()->json($this->formatResponse('error', $errorMessage), 400);
            }
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Addon $addon
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleAddToCart(Request $request, Addon $addon): JsonResponse
    {
        if ($request->ajax()) {
            try {
                if (AddonsSessionStorageService::hasAddonId($addon->id)) {
                    AddonsSessionStorageService::forgetAddonId($addon->id);
                    AddonsSessionStorageService::forgetAllIds($addon->id);

                    $successResponseMessage = 'Addon has been successfully removed from your shopping cart.';
                } else {
                    if (AddonsSessionStorageService::countIds($addon->id) < $addon->required_minimum_meals_amount) {
                        return response()->json(
                            $this->formatResponse(
                                'warning',
                                'In order to add an add-on to the cart, you need to select the required number of add-on items.'
                            )
                        );
                    }

                    AddonsSessionStorageService::pushAddonId($addon->id);

                    $successResponseMessage = 'Addon has been successfully added to your shopping cart.';
                }

                if (session()->get(Order::ONBOARDING_SESSION_KEYS['free_meals_selection'])) {
                    ShoppingCartSessionStorageService::updateOrStore(false);
                }

                return response()->json($this->formatResponse('success', $successResponseMessage));
            } catch (\Throwable $exception) {
                $errorResponseMessage = AddonsSessionStorageService::hasAddonId($addon->id)
                    ? 'Removing addon from shopping cart failed.'
                    : 'Adding addon to shopping cart failed.';

                return response()->json($this->formatResponse('error', $errorResponseMessage), 400);
            }
        }
    }

    public function removeAddonFromCart(Addon $addon, $uuid){
        try {
            session()->put(Order::ONBOARDING_SESSION_KEYS['current_meal_selection_uuid'], $uuid);
            $sessionKey = ShoppingCartSessionStorageService::SESSION_KEY . ".$uuid";
            $sessionData = session()->get($sessionKey);
            if (isset($sessionData['addons'][$addon->id])){
                unset($sessionData['addons'][$addon->id]);
            }
            session()->put($sessionKey, $sessionData);
            ShoppingCartSessionStorageService::updateOrStore(true);

            return response()->json($this->formatResponse('success', $addon->name.' item was successfully removed form cart'));
        }catch (\Exception $exception){
            return response()->json($this->formatResponse('error', $exception->getMessage()), 400);
        }
    }
}
