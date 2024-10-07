<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Addons\RenderSelectedMealsTableItemsRequest;
use App\Http\Requests\Backend\Addons\StoreAddonMealRequest;
use App\Http\Requests\Backend\Addons\StoreAddonRequest;
use App\Http\Requests\Backend\Addons\UpdateAddonMealRequest;
use App\Http\Requests\Backend\Addons\UpdateAddonRequest;
use App\Models\Addon;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Meal;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddonController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $addons = Addon::with('categories')->latest()->paginate(15);

        return \view('backend.addons.index', compact('addons'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        $categories = Category::getCategories();
        $addonMeals = old('meal_ids')
            ? Meal::whereIn('id', old('meal_ids'))->get(['id', 'name', 'price'])
            : [];
//        $sides      = Meal::where('type' , 'side')->get(['id', 'name']);
//        $addons      = Meal::where('type' , 'addon')->get(['id', 'name']);
//        $meals = $addons->merge($sides);
        $meals = Meal::get();

        return \view('backend.addons.create', compact('meals', 'categories', 'addonMeals'));
    }

    /**
     * @param \App\Http\Requests\Backend\Addons\StoreAddonRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAddonRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                Addon::storeAddon($request->validated());
            });

            return redirect()->back()->with('success', 'Addon has been successfully created.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Addon creation failed.')->withInput();
        }
    }

    /**
     * @param \App\Http\Requests\Backend\Addons\RenderSelectedMealsTableItemsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderSelectedMealsTableItems(RenderSelectedMealsTableItemsRequest $request): JsonResponse
    {
        try {
            $meals = $request->has('addon_id')
                ? Addon::findOrFail($request->addon_id)
                    ->meals()
                    ->whereIn('meals.id', $request->meal_ids)
                    ->get(['meals.id', 'meals.name', 'meals.price', 'meals.points'])
                : Meal::whereIn('id', $request->meal_ids)->get(['id', 'name', 'price', 'points']);

            return response()->json($this->formatResponse('success', null, [
                'meals_table_items_view' => \view('backend.addons.partials.meals-table-items', compact('meals'))->render(),
            ]));
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Rendering side meals table failed.'), 400);
        }
    }

    /**
     * @param \App\Models\Addon $addon
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Addon $addon): View
    {
        $addon->load(['categories', 'meals']);

        $categories = Category::getCategories();
//        $sides      = Meal::where('type' , 'side')->get(['id', 'name']);
//        $addons      = Meal::where('type' , 'addon')->get(['id', 'name']);
//        $meals = $addons->merge($sides);
        $meals = Meal::get();
        $addonMeals = old('meal_ids')
            ? Meal::whereIn('id', old('meal_ids'))->get(['id', 'name', 'price'])
            : $addon->meals;

        return \view('backend.addons.edit', compact(
            'meals',
            'categories',
            'addonMeals',
            'addon'
        ));
    }

    /**
     * @param \App\Http\Requests\Backend\Addons\UpdateAddonRequest $request
     * @param \App\Models\Addon $addon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAddonRequest $request, Addon $addon): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $addon) {
                $addon->updateAddon($request->validated());
            });

            return redirect()->back()->with('success', 'Addon has been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Addon update failed.')->withInput();
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Addon $addon
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Addon $addon): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $addon->delete();

                return response()->json($this->formatResponse('success', 'Addon has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Addon deletion failed.'), 400);
        }
    }

    public function mealsIndex(){
        if(\request()->has('sort') && (\request()->sort === 'created_at' || \request()->sort === 'order_id' || \request()->sort === 'name')){
            if (\request()->sort === 'created_at'){
                $meals = Meal::where('type','addon')->latest()->paginate(15);
            }else $meals = Meal::where('type','addon')->orderBy(\request()->sort)->paginate(15);
        } else $meals = Meal::where('type','addon')->orderBy('order_id')->paginate(15);

        return view('backend.addons.meals.index')->with([
            'meals' => $meals,
        ]);
    }

    public function mealsCreateIndex(){
        $maxId = Meal::where('type', 'addon')->get()->max('order_id') + 1;
        $ingredients = Ingredient::all(['id', 'name']);
        $categories = Addon::all(['id', 'name']);

        return \view('backend.addons.meals.create', compact(
            'ingredients',
            'maxId',
            'categories'
        ));
    }

    public function mealsCreate(StoreAddonMealRequest $request){
        try {
            DB::transaction(function () use ($request) {
                Meal::storeAddon($request->validated());
            });

            return redirect()->back()->with('success', 'Addon meal has been successfully created.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Addon meal creation failed.')->withInput();
        }
    }

    public function mealsEdit(Meal $addon): View
    {
        $addon->load(['ingredients', 'mealFor']);

        $categories = Addon::all(['id', 'name']);
        $ingredients = Ingredient::all(['id', 'name']);
        return \view('backend.addons.meals.edit', compact(
            'addon',
            'ingredients',
            'categories',
        ));
    }

    public function mealsUpdate(UpdateAddonMealRequest $request, Meal $addon){
        try {
            DB::transaction(function () use ($request, $addon) {
                $addon->updateAddon($request->validated());
            });

            return redirect()->back()->with('success', 'Addon meal has been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Addon meal update failed.')->withInput();
        }
    }

    public function mealsDelete(Request $request, Meal $addon){
        try {
            if ($request->ajax()) {
                $addon->mealFor()->detach();
                $addon->delete();
                return response()->json($this->formatResponse('success', 'Addon meal has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Addon meal   deletion failed.'), 400);
        }
    }
}
