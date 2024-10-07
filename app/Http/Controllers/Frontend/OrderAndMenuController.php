<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\OrderAndMenu\RememberAmountOfMealsSelectionRequest;
use App\Http\Requests\Frontend\OrderAndMenu\RememberPreferredMenuTypeSelectionRequest;
use App\Http\Requests\Frontend\OrderAndMenu\RenderMealDetailsPopupRequest;
use App\Http\Requests\Frontend\OrderAndMenu\SelectMeals\DuplicateMealsRequest;
use App\Http\Requests\Frontend\OrderAndMenu\SelectMeals\SelectPortionSizeRequest;
use App\Http\Requests\Frontend\OrderAndMenu\SelectMeals\ToggleEntryMealSelectionRequest;
use App\Http\Requests\Frontend\OrderAndMenu\SelectMeals\ToggleSideMealSelectionRequest;
use App\Http\Requests\Frontend\OrderAndMenu\SelectMeals\UpdateAmountOfMealsRequest;
use App\Http\Requests\Frontend\OrderAndMenu\SelectMeals\ValidateMealCreationStep;
use App\Models\Addon;
use App\Models\Category;
use App\Models\Meal;
use App\Models\Menu;
use App\Models\MenuPlanPrice;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Tag;
use App\Services\SessionStorageHandlers\AddonsSessionStorageService;
use App\Services\SessionStorageHandlers\MealsSessionStorageService;
use App\Services\SessionStorageHandlers\ShoppingCartSessionStorageService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderAndMenuController extends Controller
{
    /**
     * @param \App\Models\Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Category $category)
    {
        $categoryId = session()->has(Order::ONBOARDING_SESSION_KEYS['preferred_menu_type_selection'])
            ? (int)session()->get(Order::ONBOARDING_SESSION_KEYS['preferred_menu_type_selection'])
            : null;

        if (!empty($categoryId) && $categoryId !== $category->id) {
            return redirect()->route('frontend.landing.index');
        }

        $selectedAddons                   = Addon::findMany(AddonsSessionStorageService::getAddonIds() ?? []);
        $selectedAddonMeals               = $selectedAddons->map->getAddonMealsStoredInSession()->flatten();
        $selectedAddonsMicronutrientsData = Meal::getMicronutrientsData($selectedAddonMeals);
        $portionSizes                     = Setting::getMealsPortionSizes();
        $selectedPortionSize              = MealsSessionStorageService::getPortionSize();
        $menu                             = Menu::where('category_id', $category->id)->where('status', true)->with('category.addons')->latest()->first();
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
                    $meal = $mealsById->shift();
                    $meal->selected_sides = $sideIds;
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
        $meals                            = $menu
            ? $mealMenusArray
            : collect();
        //dd($meals);
        $totalPriceWithoutPortionSize = (optional($menu)->price ?? $meals->sum('price')) + $selectedAddonMeals->sum('pivot.price');
        $totalPrice                   = $totalPriceWithoutPortionSize +
            calculatePercentageValueFromNumber($selectedPortionSize['percentage'], $totalPriceWithoutPortionSize);
        $totalPoints = $totalPrice * 10;
        $mealsMicronutrientsData          = collect([
            'calories' => $menu->calories ?? 0,
            'carbs'    => $menu->carbs ?? 0,
            'fats'     => $menu->fats ?? 0,
            'proteins' => $menu->proteins ?? 0,
        ]);

        return \view('frontend.order-and-menu.index', compact(
            'category',
            'categoryId',
            'meals',
            'mealsMicronutrientsData',
            'menu',
            'selectedAddonsMicronutrientsData',
            'selectedAddonMeals',
            'selectedAddons',
            'portionSizes',
            'selectedPortionSize',
            'totalPriceWithoutPortionSize',
            'totalPrice',
            'totalPoints'
        ));
    }

    public function sortSides(Request $request, int $mealNumber){

        $currentSelectedEntryMeal = Meal::with('sides')
            ->withCount('sides')
            ->where('id', MealsSessionStorageService::getIds($mealNumber)[0] ?? null)
            ->first();
        $mealsQuery          = $currentSelectedEntryMeal->sides();
        if ($request->ajax()) {/**/
            /*if ($request->filled('sort')) {
                $mealsQuery->orderBy($request->sort['column'], $request->sort['direction']);
            }*/
            if ($request->has('filter') && $request->filter['tags'] !== null) {
                $tags = [];
                foreach ($request->filter['tags'] as $index => $tag) {
                    $tags[] = $tag;
                }
                $mealsQuery->whereJsonContains('tags', $tags)->where('type', 'side');
            }
        }

        $currentSelectedSides     = collect(Meal::getMealsAndSidesStoredInSession($mealNumber)[1])->flatten();
        $sides                    = $mealsQuery->get();

        if ($request->ajax() && $request->filled('sort') || $request->has('filter')) {
            return response()->json($this->formatResponse('success', null, [
                'sorted_items_view' => \view('frontend.order-and-menu.partials.side-meals-items', compact(
                    'sides',
                    'mealNumber',
                    'currentSelectedSides'
                ))->render(),
            ]));
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $mealNumber
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function selectMeals(Request $request, int $mealNumber)
    {
        if (!session()->get(Order::ONBOARDING_SESSION_KEYS['free_meals_selection'])) {
            return redirect()->route('frontend.landing.index');
        }
        if ($mealNumber !== 1 && !session()->get(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . '.' . ($mealNumber - 1))) {
            return redirect()->route('frontend.order-and-menu.select-meals', 1);
        }

        $hasSidesWarning     = (bool)session()->get(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber.sides");
        $hasEntryMealWarning = (bool)session()->get(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber.entry");
        $mealsQuery          = Meal::query()->where([
            ['type', 'entry'],
            ['status', true],
            ])->with('sides');

        if ($hasEntryMealWarning) {
            foreach (MealsSessionStorageService::getIds($mealNumber, 'sides') as $sideId) {
                $mealsQuery->whereHas('sides', function (Builder $query) use ($sideId) {
                    $query->where('side_id', $sideId);
                });
            }
        }

        if ($request->ajax()) {/**/
            if ($request->filled('sort')) {
                $mealsQuery->orderBy($request->sort['column'], $request->sort['direction']);
            }
            if ($request->has('filter') && $request->filter['tags'] !== null) {
                $tags = [];
                foreach ($request->filter['tags'] as $index => $tag) {
                    $tags[] = $tag;
                }
                $mealsQuery->whereJsonContains('tags', $tags)->where('type', 'entry');
            }
        }

        $meals                    = $mealsQuery->get();
        $currentSelectedEntryMeal = Meal::with('sides')
            ->withCount('sides')
            ->where('id', MealsSessionStorageService::getIds($mealNumber)[0] ?? null)
            ->first();

        if ($request->ajax() && $request->filled('sort') || $request->has('filter')) {
            return response()->json($this->formatResponse('success', null, [
                'sorted_items_view' => \view('frontend.order-and-menu.partials.entry-meals-items', compact(
                    'meals',
                    'mealNumber',
                    'currentSelectedEntryMeal',
                    'hasEntryMealWarning',
                    'hasSidesWarning'
                ))->render(),
            ]));
        }

        $portionSizes                     = Setting::getMealsPortionSizes();
        $selectedPortionSize              = MealsSessionStorageService::getPortionSize();
        $tags                             = Tag::all(['name']);
        $mealsAmount                      = session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']);
        $addons                           = Addon::whereHas('categories', function ($q){
            $q->where('key', 'custom_menu');
        })->get(['id', 'name']);
        $selectedAddons                   = Addon::findMany(AddonsSessionStorageService::getAddonIds() ?? []);
        $selectedAddonMeals               = $selectedAddons->map->getAddonMealsStoredInSession()->flatten();
        $selectedAddonsMicronutrientsData = Meal::getMicronutrientsData($selectedAddonMeals);
        $currentSelectedSides             = !$currentSelectedEntryMeal && ($hasSidesWarning || $hasEntryMealWarning)
            ? collect(Meal::getMealsAndSidesStoredInSession($mealNumber)[1])->flatten()
            : optional($currentSelectedEntryMeal)->getSidesStoredInSession($mealNumber) ?? collect();
        [$selectedMeals, $selectedSides] = Meal::getMealsAndSidesStoredInSession();
        $selectedMealsAndSides           = $selectedMeals->merge($selectedSides);
        if($selectedMealsAndSides->count() === ($selectedMeals->count() + $selectedSides->count()) && (session()->get(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealsAmount") === true)){
            $allMealsSelected = true;
        } else $allMealsSelected = false;
        $mealsAndSidesMicronutrientsData = [
            'calories' => ($currentSelectedEntryMeal->calories ?? 0) + $currentSelectedSides->sum('calories'),
            'fats' => ($currentSelectedEntryMeal->fats ?? 0) + $currentSelectedSides->sum('fats'),
            'carbs' => ($currentSelectedEntryMeal->carbs ?? 0) + $currentSelectedSides->sum('carbs'),
            'proteins' => ($currentSelectedEntryMeal->proteins ?? 0) + $currentSelectedSides->sum('proteins'),
        ];
        $mealsAmount                  = session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']);
        $priceOfMeal = MenuPlanPrice::where('count',$mealsAmount)->first()->price ?? (Setting::key('avg_price')->first()->data * $mealsAmount) ?? 0;
        $totalPriceWithoutPortionSize = $selectedMealsAndSides->sum('price') + $selectedAddonMeals->sum('pivot.price') + $priceOfMeal;
        $totalPrice                   = $totalPriceWithoutPortionSize +
            calculatePercentageValueFromNumber($selectedPortionSize['percentage'], $totalPriceWithoutPortionSize);
        $totalPoints = $totalPrice * 10;

        return \view('frontend.order-and-menu.select-meals', compact(
            'mealsAmount',
            'hasEntryMealWarning',
            'hasSidesWarning',
            'meals',
            'mealNumber',
            'tags',
            'allMealsSelected',
            'addons',
            'selectedAddonsMicronutrientsData',
            'selectedAddons',
            'selectedAddonMeals',
            'currentSelectedEntryMeal',
            'currentSelectedSides',
            'selectedSides',
            'selectedMeals',
            'selectedMealsAndSides',
            'mealsAndSidesMicronutrientsData',
            'totalPriceWithoutPortionSize',
            'totalPrice',
            'portionSizes',
            'selectedPortionSize',
            'totalPoints'
        ));
    }

    /**
     * @param \App\Http\Requests\Frontend\OrderAndMenu\SelectMeals\ToggleEntryMealSelectionRequest $request
     * @param \App\Models\Meal $meal
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleEntryMealSelection(ToggleEntryMealSelectionRequest $request, Meal $meal): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $mealNumber = $request->meal_number;

                if ($request->operation === 'select') {
                    MealsSessionStorageService::pushId($meal->id, $mealNumber);

                    if (!$meal->sides()->exists()) {
                        session()->put(MealsSessionStorageService::MEALS_SELECTION_SESSION_KEY . '.' . $mealNumber . '.sides', []);
                        session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber", true);
                    }
                    if (count(MealsSessionStorageService::getIds($mealNumber, 'sides')) >= 2) {
                        session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber", true);
                    }
                } else {
                    $currentUnselectedSides = $meal->getSidesStoredInSession($mealNumber) ?? collect();

                    session()->forget(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber");
                    if (!session()->get(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber.entry")) {
                        MealsSessionStorageService::forgetAllIds($mealNumber);
                    } else {
                        MealsSessionStorageService::forgetId($meal->id, $mealNumber);
                    }
                }

                ShoppingCartSessionStorageService::updateOrStore(false);

                $currentSelectedSides = collect(Meal::getMealsAndSidesStoredInSession($mealNumber)[1])->flatten();

                $responseData = [
                    'meal_id'             => $meal->id,
                    'name'                => $meal->name,
                    'price'               => (int)$meal->price,
                    'points'              => (int)$meal->points,
                    'removing_from_order' => $request->operation === 'unselect',
                    'micronutrients_data' => [
                        'calories' => $meal->calories,
                        'fats'     => $meal->fats,
                        'carbs'    => $meal->carbs,
                        'proteins' => $meal->proteins,
                    ],
                ];
                if (session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']) === $request->meal_number){
                    $last_step = true;
                } else $last_step = false;

                if ($request->operation === 'select') {
                    $sides = $meal->sides()->where('status', true)->get();

                    $responseData['sides_view']              = \view('frontend.order-and-menu.partials.side-meals-items', compact(
                        'sides',
                        'mealNumber',
                        'currentSelectedSides'
                    ))->render();
                    $responseData['sides_count']             = $sides->count();
                    $responseData['last_step']               = $last_step;
                    if ($sides->count() === 0){
                        $responseData['required_sides_selected'] = true;
                    }
                    else{
                        $responseData['required_sides_selected'] = $currentSelectedSides->count() >= 2;
                    }

                } else {
                    $responseData['unselected_sides']['micronutrients_data'] = Meal::getMicronutrientsData($currentUnselectedSides ?? collect());
                    $responseData['unselected_sides']['price']               = (int)(optional($currentUnselectedSides ?? null)->sum('pivot.price') ?? 0);
                    $responseData['unselected_sides']['points']              = (int)(optional($currentUnselectedSides ?? null)->sum('pivot.points') ?? 0);
                }

                return response()->json($this->formatResponse('success', null, $responseData));
            }
        } catch (\Throwable $exception) {
            $errorMessage = $request->operation === 'select'
                ? 'Selecting entry meal failed.'
                : 'Unselecting entry meal failed.';

            return response()->json($this->formatResponse('error', $exception->getMessage()), 400);
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\OrderAndMenu\SelectMeals\ToggleSideMealSelectionRequest $request
     * @param \App\Models\Meal $meal
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleSideMealSelection(ToggleSideMealSelectionRequest $request, Meal $meal): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $sideMealsSelectedAmount = MealsSessionStorageService::countIds($request->meal_number, 'sides');
                $sideMeal                = $request->entry_meal_id
                    ? Meal::find($request->entry_meal_id)->sides()->where('meals.id', $meal->id)->first()
                    : $meal;
                $entryMealSelected = Meal::find($request->entry_meal_id);
                if ($request->operation === 'select') {
                    if ($sideMealsSelectedAmount === $entryMealSelected->side_count) {
                        return response()->json(
                            $this->formatResponse(
                                'warning',
                                'You have already selected the required amount of side meals.'
                            )
                        );
                    }

                    MealsSessionStorageService::pushId($sideMeal->id, $request->meal_number, 'sides');
                    $sideMealsSelectedAmount++;
                    /*$sideMealsSelectedAmount === 2 && */
                    if ($sideMealsSelectedAmount === $entryMealSelected->side_count && $request->filled('entry_meal_id')) {
                        session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$request->meal_number", true);
                        session()->forget(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$request->meal_number");
                    }
                } else {
                    session()->forget(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$request->meal_number");
                    MealsSessionStorageService::forgetId($sideMeal->id, $request->meal_number, 'sides');
                    $sideMealsSelectedAmount--;
                }

                ShoppingCartSessionStorageService::updateOrStore(false);

                if (session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']) === $request->meal_number){
                    $last_step = true;
                } else $last_step = false;

                return response()->json($this->formatResponse('success', null, [
                    'side_selected' => array_unique(MealsSessionStorageService::getIds()[$request->meal_number]['sides']),
                    'side_meals_selected_amount'   => $sideMealsSelectedAmount,
                    'entry_meal_selected'          => $request->filled('entry_meal_id'),
                    'required_side_meals_selected' => $sideMealsSelectedAmount === $entryMealSelected->side_count, /*$sideMealsSelectedAmount === 2*/
                    'side_count'                   => $entryMealSelected->side_count,
                    'side_id'                      => $sideMeal->id,
                    'selected_id'                  => (int)$request->selected_id ?? null,
                    'name'                         => $sideMeal->name,
                    'last_step'                    => $last_step,
                    'price'                        => (int)(optional($sideMeal->pivot)->price ?? $sideMeal->price),
                    'points'                       => (int)(optional($sideMeal->pivot)->points ?? $sideMeal->points),
                    'micronutrients_data'          => [
                        'calories' => $sideMeal->calories,
                        'fats'     => $sideMeal->fats,
                        'carbs'    => $sideMeal->carbs,
                        'proteins' => $sideMeal->proteins,
                    ],
                ]));
            } catch (\Throwable $exception) {
                $errorMessage = $request->operation === 'select'
                    ? 'Selecting side meal failed.'
                    : 'Unselecting side meal failed.';

                return response()->json($this->formatResponse('error', $errorMessage), 400);
            }
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $mealNumber
     * @return \Illuminate\Http\JsonResponse
     */
    public function discardMealCreation(Request $request, int $mealNumber): JsonResponse
    {
        if ($request->ajax()) {
            try {
                MealsSessionStorageService::forgetAllIds($mealNumber);
                session()->forget(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber");
                session()->forget(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber");

                return response()->json($this->formatResponse('success', 'Changes has been successfully discarded.'));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Discarding changes failed.'), 400);
            }
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function startOverMealCreation(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                MealsSessionStorageService::forgetAllIds();
                AddonsSessionStorageService::forgetAllIds();
                ShoppingCartSessionStorageService::forget(session()->get(Order::ONBOARDING_SESSION_KEYS['current_meal_selection_uuid']));
                session()->forget([
                    MealsSessionStorageService::MEALS_PORTION_SIZE_SESSION_KEY,
                    Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'],
                    Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'],
                    Order::ONBOARDING_SESSION_KEYS['current_meal_selection_uuid'],
                ]);

                return response()->json(
                    $this->formatResponse(
                        'success',
                        'Changes has been successfully discarded.',
                        ['redirect' => route('frontend.order-and-menu.select-meals', 1)]
                    )
                );
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Discarding changes failed.'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\OrderAndMenu\SelectMeals\ValidateMealCreationStep $request
     * @param int $mealNumber
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateMealCreationStep(ValidateMealCreationStep $request, int $mealNumber): JsonResponse
    {
        if ($request->ajax()) {
            try {
                if ($request->wanted_meal_number <= $mealNumber) {
                    return response()->json($this->formatResponse('success', null, [
                        'redirect' => route('frontend.order-and-menu.select-meals', $request->wanted_meal_number),
                    ]));
                }

                $selectedEntryMeal = Meal::find(MealsSessionStorageService::getIds($mealNumber)[0] ?? null);

                if (!$selectedEntryMeal) {
                    session()->forget(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber");

                    return response()->json($this->formatResponse('warning', 'Select entry meal.', [
                        'warning_for' => 'entry',
                    ]));
                }
                if ($selectedEntryMeal->sides()->exists() && count(MealsSessionStorageService::getIds($mealNumber, 'sides')) < 2) {
                    session()->forget(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber");

                    return response()->json($this->formatResponse('warning', 'Select two side dishes.', [
                        'warning_for' => 'sides',
                    ]));
                }

                session()->forget(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber");
                session()->put(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber", true);

                return response()->json($this->formatResponse('success', null, [
                    'redirect' => route('frontend.order-and-menu.select-meals', $request->wanted_meal_number),
                ]));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Moving to next meal failed.'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\OrderAndMenu\SelectMeals\UpdateAmountOfMealsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAmountOfMeals(UpdateAmountOfMealsRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                session()->put(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection'], $request->amount);

                ShoppingCartSessionStorageService::updateOrStore(false);

                return response()->json($this->formatResponse('success', 'Amount of meals has been successfully changed.'));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Updating amount of meals failed.'), 400);
            }
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $mealNumber
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderDuplicateMealsPopup(Request $request, int $mealNumber): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $maximumMealsAmount       = (int)session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']) - count(MealsSessionStorageService::getIds());
                $currentSelectedEntryMeal = Meal::find(MealsSessionStorageService::getIds($mealNumber)[0] ?? null);
                $currentSelectedSides     = optional($currentSelectedEntryMeal)->getSidesStoredInSession($mealNumber) ?? collect();

                return response()->json($this->formatResponse('success', null, [
                    'duplicate_meals_popup_view' => \view('frontend.order-and-menu.partials.popups.duplicate-meal-step-selection', compact(
                        'maximumMealsAmount',
                        'currentSelectedEntryMeal',
                        'currentSelectedSides'
                    ))->render(),
                ]));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Rendering duplicate popup failed.'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\OrderAndMenu\SelectMeals\DuplicateMealsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function duplicateMeals(DuplicateMealsRequest $request): JsonResponse/**/
    {
        if ($request->ajax()) {
            try {
                [$firstDuplicatedMealNumber, $responseMessage] = Meal::duplicateMealsToMealCreationSteps($request);

                ShoppingCartSessionStorageService::updateOrStore(false);

                setSessionResponseMessage($responseMessage);

                return response()->json($this->formatResponse('success', $responseMessage, [
                    'redirect' => route('frontend.order-and-menu.select-meals', $firstDuplicatedMealNumber)
                ]));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Duplicating meals failed.'), 400);
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function reviewOrderSelection()
    {
        $mealsAmount = session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']);

        if (!$mealsAmount) {
            return redirect()->route('frontend.landing.index');
        }
        if (!session()->get(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . '.' . ($mealsAmount - 1))) {
            return redirect()->route('frontend.order-and-menu.select-meals', 1);
        }

        $shoppingCartOrders  = ShoppingCartSessionStorageService::getMappedStoredData();
        $totalPrice = $shoppingCartOrders->sum('total_price');
        $totalPoints = $shoppingCartOrders->sum('total_points');
        $selectedAddons                   = Addon::findMany(AddonsSessionStorageService::getAddonIds() ?? []);
        $selectedAddonMeals               = $selectedAddons->map->getAddonMealsStoredInSession()->flatten();
        $selectedAddonsArray  = ShoppingCartSessionStorageService::getMappedStoredData()->first()['addons'];
        foreach ($selectedAddonsArray as $key => $value){
            $calories = 0;
            $carbs = 0;
            $fats = 0;
            $proteins = 0;
            foreach ($value['meals'] as $meal){
                $calories += $meal->calories;
                $carbs += $meal->carbs;
                $fats += $meal->fats;
                $proteins += $meal->proteins;
            }
            array_push($selectedAddonsArray[$key], [
                'calories' => $calories,
                'carbs' => $carbs,
                'fats' => $fats,
                'proteins' => $proteins,
            ]);
        }
        $selectedAddonsMicronutrientsData = Meal::getMicronutrientsData($selectedAddonMeals);
        [$selectedMeals, $selectedSides] = Meal::getMealsAndSidesStoredInSession();
        $selectedMealsAndSides           = $selectedMeals->merge($selectedSides);
        $mealsAndSidesMicronutrientsData = Meal::getMicronutrientsData($selectedMealsAndSides);

        [$selectedMeals, $selectedSides] = Meal::getMealsAndSidesStoredInSession();

        return \view('frontend.order-and-menu.review-order', compact(
            'mealsAmount',
            'selectedAddons',
            'selectedAddonMeals',
            'selectedAddonsMicronutrientsData',
            'selectedMeals',
            'selectedSides',
            'selectedMealsAndSides',
            'mealsAndSidesMicronutrientsData',
            'selectedAddonsArray',
            'shoppingCartOrders',
            'totalPoints',
            'totalPrice'
        ));
    }

    /**
     * @param \App\Http\Requests\Frontend\OrderAndMenu\SelectMeals\SelectPortionSizeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectPortionSize(SelectPortionSizeRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $selectedPortionSize = collect(Setting::getMealsPortionSizes())->where('size', $request->size)->first();
                [$selectedMeals, $selectedSides] = Meal::getMealsAndSidesStoredInSession();
                $selectedMealsAndSides        = $selectedMeals->merge($selectedSides);
                $selectedAddons               = Addon::findMany(AddonsSessionStorageService::getAddonIds() ?? []);
                $selectedAddonMeals           = $selectedAddons->map->getAddonMealsStoredInSession()->flatten();
                $mealsAmount                  = session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']);
                $priceOfMeal = MenuPlanPrice::where('count',$mealsAmount)->first()->price ?? (Setting::key('avg_price')->first()->data * $mealsAmount) ?? 0;
                $totalPriceWithoutPortionSize = $selectedMealsAndSides->sum('price') + $selectedAddonMeals->sum('pivot.price') + $priceOfMeal;
                $totalPrice                   = $totalPriceWithoutPortionSize +
                    calculatePercentageValueFromNumber($selectedPortionSize['percentage'], $totalPriceWithoutPortionSize);
                $totalPoints = $totalPrice * 10;

                MealsSessionStorageService::setPortionSize($selectedPortionSize);

                ShoppingCartSessionStorageService::updateOrStore(false);

                return response()->json($this->formatResponse('success', null, [
                    'total_price' => $totalPrice,
                    'total_points' => $totalPoints,
                ]));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Selecting portion size failed.'), 400);
            }
        }
    }

    public function selectPortionSizeForMenu(SelectPortionSizeRequest $request, Category $category): JsonResponse
    {
        if ($request->ajax()) {
            try {/**/
                $selectedPortionSize = collect(Setting::getMealsPortionSizes())->where('size', $request->size)->first();

                $selectedAddons               = Addon::findMany(AddonsSessionStorageService::getAddonIds() ?? []);
                $selectedAddonMeals           = $selectedAddons->map->getAddonMealsStoredInSession()->flatten();
                $menu                         = Menu::where('category_id', $category->id)->where('status', true)->with('category.addons')->latest()->first();
                $meals                        = $menu
                    ? $menu->meals()->with('menuSides', function (BelongsToMany $query) use ($menu) {
                        $query->where('menu_id', $menu->id);
                    })->get()
                    : collect();
                $totalPriceWithoutPortionSize = (optional($menu)->price ?? $meals->sum('price')) + $selectedAddonMeals->sum('pivot.price');
                $totalPrice                   = $totalPriceWithoutPortionSize +
                    calculatePercentageValueFromNumber($selectedPortionSize['percentage'], $totalPriceWithoutPortionSize);
                $totalPoints = $totalPrice * 10;

                MealsSessionStorageService::setPortionSize($selectedPortionSize);

                ShoppingCartSessionStorageService::updateOrStore(false);

                return response()->json($this->formatResponse('success', null, [
                    'total_price' => $totalPrice,
                    'total_points' => $totalPoints,
                ]));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Selecting portion size failed.'), 400);
            }
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshPortionSizesValues(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $selectedPortionSize = MealsSessionStorageService::getPortionSize();
                [$selectedMeals, $selectedSides] = Meal::getMealsAndSidesStoredInSession();
                $selectedMealsAndSides        = $selectedMeals->merge($selectedSides);
                $selectedAddons               = Addon::findMany(AddonsSessionStorageService::getAddonIds() ?? []);
                $selectedAddonMeals           = $selectedAddons->map->getAddonMealsStoredInSession()->flatten();
                $mealsAmount                  = session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']);
                $priceOfMeal = MenuPlanPrice::where('count',$mealsAmount)->first()->price ?? (Setting::key('avg_price')->first()->data * $mealsAmount) ?? 0;
                $totalPriceWithoutPortionSize = $selectedMealsAndSides->sum('price') + $selectedAddonMeals->sum('pivot.price') + $priceOfMeal;
                $totalPrice                   = $totalPriceWithoutPortionSize +
                    calculatePercentageValueFromNumber($selectedPortionSize['percentage'], $totalPriceWithoutPortionSize);

                $portionSizesData = collect(Setting::getMealsPortionSizes())->map(function (array $portionSize) use ($totalPriceWithoutPortionSize) {
                    return [
                        'size'  => $portionSize['size'],
                        'value' => calculatePercentageValueFromNumber($portionSize['percentage'], $totalPriceWithoutPortionSize),
                    ];
                })->toArray();

                return response()->json($this->formatResponse('success', null, [
                    'portion_sizes' => $portionSizesData,
                    'total_price'   => $totalPrice,
                ]));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Recalculation portion size prices failed.'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\OrderAndMenu\RenderMealDetailsPopupRequest $request
     * @param \App\Models\Meal $meal
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderMealDetailsPopup(RenderMealDetailsPopupRequest $request, Meal $meal): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $mealNumber = $request->meal_number;
                $hasEntryMealWarning = (bool)session()->get(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber.entry");
                $currentSelectedEntryMeal = Meal::with('sides')
                    ->withCount('sides')
                    ->where('id', MealsSessionStorageService::getIds($request->meal_number)[0] ?? null)
                    ->first();
                return response()->json($this->formatResponse('success', null, [
                    'meal_details_popup_view' => \view('frontend.order-and-menu.partials.popups.meal-details', [
                        'menuId'        => $request->menu_id,
                        'meal'          => $meal,
                        'showAddButton' => (bool)$request->show_add_button,
                        'showSides'     => (bool)$request->show_sides,
                        'removing'      => false,
                        'currentSelectedEntryMeal' => $currentSelectedEntryMeal,
                        'hasEntryMealWarning' => $hasEntryMealWarning,
                        'mealNumber' => $mealNumber
                    ])->render(),
                ]));
            }
        } catch (\Throwable $exception) {

            return response()->json($this->formatResponse('error', 'Rendering meal details popup failed.'), 400);
        }
    }

    public function renderSideDetailsPopup(RenderMealDetailsPopupRequest $request, Meal $meal): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $mealNumber = $request->meal_number;
                $hasEntryMealWarning = (bool)session()->get(Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$mealNumber.entry");
                $currentSelectedEntryMeal = Meal::with('sides')
                    ->withCount('sides')
                    ->where('id', MealsSessionStorageService::getIds($request->meal_number)[0] ?? null)
                    ->first();
                $currentSelectedSides             = !$currentSelectedEntryMeal && ($hasSidesWarning || $hasEntryMealWarning)
                    ? collect(Meal::getMealsAndSidesStoredInSession($mealNumber)[1])->flatten()
                    : optional($currentSelectedEntryMeal)->getSidesStoredInSession($mealNumber) ?? collect();
                return response()->json($this->formatResponse('success', null, [
                    'meal_details_popup_view' => \view('frontend.order-and-menu.partials.popups.meal-details', [
                        'menuId'        => $request->menu_id,
                        'meal'          => $meal,
                        'showAddButton' => (bool)$request->show_add_button,
                        'showSides'     => (bool)$request->show_sides,
                        'removing'      => false,
                        'selected_id'   => $request->selected_id,
                        'currentSelectedSides' => $currentSelectedSides,
                        'isSide'        => true,
                        'currentSelectedEntryMeal' => $currentSelectedEntryMeal,
                        'hasEntryMealWarning' => $hasEntryMealWarning,
                        'mealNumber' => $mealNumber
                    ])->render(),
                ]));
            }
        } catch (\Throwable $exception) {

            return response()->json($this->formatResponse('error', 'Rendering meal details popup failed.', $exception->getMessage()), 400);
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\OrderAndMenu\RememberPreferredMenuTypeSelectionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rememberPreferredMenuTypeSelection(RememberPreferredMenuTypeSelectionRequest $request): JsonResponse
    {
        session()->forget([
            Order::ONBOARDING_SESSION_KEYS['free_meals_selection'],
            Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'],
            Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'],
            Order::ONBOARDING_SESSION_KEYS['current_meal_selection_uuid'],
            'response-message',
            AddonsSessionStorageService::ADDONS_SELECTION_SESSION_KEY,
            AddonsSessionStorageService::ADDON_MEALS_SELECTION_SESSION_KEY,
            MealsSessionStorageService::MEALS_SELECTION_SESSION_KEY,
            MealsSessionStorageService::MEALS_PORTION_SIZE_SESSION_KEY,
        ]);

        session()->put(Order::ONBOARDING_SESSION_KEYS['preferred_menu_type_selection'], $request->category_id);

        return response()->json($this->formatResponse('success', null, [
            'redirect' => route('frontend.order-and-menu.index', Category::find($request->category_id)->name),
        ]));
    }

    /**
     * @param \App\Http\Requests\Frontend\OrderAndMenu\RememberAmountOfMealsSelectionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rememberFreeMealsSelection(RememberAmountOfMealsSelectionRequest $request): JsonResponse
    {
        session()->forget([
            Order::ONBOARDING_SESSION_KEYS['preferred_menu_type_selection'],
            Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'],
            Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'],
            Order::ONBOARDING_SESSION_KEYS['current_meal_selection_uuid'],
            'response-message',
            AddonsSessionStorageService::ADDONS_SELECTION_SESSION_KEY,
            AddonsSessionStorageService::ADDON_MEALS_SELECTION_SESSION_KEY,
            MealsSessionStorageService::MEALS_SELECTION_SESSION_KEY,
            MealsSessionStorageService::MEALS_PORTION_SIZE_SESSION_KEY,
        ]);

        session()->put(Order::ONBOARDING_SESSION_KEYS['free_meals_selection'], true);
        session()->put(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection'], $request->amount);

        return response()->json($this->formatResponse('success', null, [
            'redirect' => route('frontend.order-and-menu.select-meals', 1),
        ]));
    }

    public function duplicateMenu(Menu $menu, Request $request)
    {
        if ($request->ajax()) {
            try {
                $array = session()->has('menu-duplicate') ? session()->get('menu-duplicate') : [];
                if (array_key_exists($menu->id, $array)){
                    $array[$menu->id] +=1;
                }
                else{
                    $array[$menu->id] =1;
                }
                session()->put('menu-duplicate', $array);

                return response()->json([
                    'success' => true,
                    'message' => 'Menu was duplicated successfully, menu count: '. ($array[$menu->id]+1),
                    'count'   => $array[$menu->id],
                ]);
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Adding to cart failed.'), 400);
            }
        }
    }
}
