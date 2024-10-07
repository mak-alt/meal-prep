<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Traits\PointsCalculation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Menus\RenderSelectedMealTableItemsRequest;
use App\Http\Requests\Backend\Menus\StoreMenuRequest;
use App\Http\Requests\Backend\Menus\UpdateMenuRequest;
use App\Models\Category;
use App\Models\Meal;
use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use PointsCalculation;

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $menus = Menu::with('meals')->orderBy('category_id')->latest()->paginate(15);

        return \view('backend.menus.index', compact('menus'));
    }

    /**
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Menu $menu): View
    {
        $menu->load('meals');
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

        $categories = Category::getCategories();
        $sides = Meal::where('type', 'side')->get();
        $meals = Meal::where('type', 'entry')->get();

        return \view('backend.menus.edit', compact('menu', 'categories', 'meals', 'sides', 'mealSides', 'mealMenusArray'));
    }

    /**
     * @param \App\Http\Requests\Backend\Menus\UpdateMenuRequest $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateMenuRequest $request, Menu $menu): RedirectResponse
    {
        $data = $request->validated();

        $data['weekly_menu'] = $request->has('weekly_menu');
        $data['status']      = $request->has('status');
        $data['description'] = strip_tags($data['description']);

        try {
            $menu->updateMenu($data);

            return redirect()->back()->with('success', 'Menu has been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Menu update failed.')->withInput();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        $categories = Category::getCategories();
        $meals      = Meal::where('type', 'entry')->get(['id', 'name']);

        return \view('backend.menus.create', compact('categories', 'meals'));
    }


    public function store(StoreMenuRequest $request)
    {
        try {
            $data = $request->validated();
            $data['description'] = strip_tags($data['description']);

            $data['weekly_menu'] = $request->has('weekly_menu');
            $data['status']      = $request->has('status');

            Menu::storeMenu($data);

            return redirect()->back()->with('success', 'Menu has been successfully created.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Menu creation failed.')->withInput();
        }
    }

    /**
     * @param \App\Http\Requests\Backend\Menus\RenderSelectedMealTableItemsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderSelectedMealTableItems(RenderSelectedMealTableItemsRequest $request): JsonResponse
    {
        try {
            $meals = Meal::where('id', $request->meal_id)->with('sides')->get();
            $sides = Meal::where('type', 'side')->get();
            $times = $request->times ?? 1;
            $calories =  $meals[0]->calories;
            $fats =  $meals[0]->fats;
            $carbs =  $meals[0]->carbs;
            $proteins =  $meals[0]->proteins;

            return response()->json($this->formatResponse('success', null, [
                'meals_table_item_view' => \view('backend.menus.partials.meals-table-items', compact('meals', 'sides', 'times'))->render(),
                'calories' => $calories,
                'fats' => $fats,
                'carbs' => $carbs,
                'proteins' => $proteins,
            ]));
        } catch (\Throwable $exception) {
            dd($exception);
            return response()->json($this->formatResponse('error', 'Rendering meals table failed.'), 400);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Menu $menu): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $menu->delete();

                return response()->json($this->formatResponse('success', 'Menu has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Menu deletion failed.'), 400);
        }
    }

    public function getMealsByCategory(Request $request)
    {
        try{
            $cat = Category::find($request->id);
            $entrees = $cat->meals()->where('type', 'entry')->get();
            $arr = [];
            foreach ($entrees as $entree) {
                $arr[] = [
                    'id' => $entree->id,
                    'text' => $entree->name
                ];
            }
            return response()->json([
                'success' => true,
                'entry' => $arr,
            ]);
        }
        catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'msg' => 'Finding sides failed',
                //'msg' => $exception->getMessage(),
            ]);
        }
    }
}
