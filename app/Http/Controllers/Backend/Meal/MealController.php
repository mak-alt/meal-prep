<?php

namespace App\Http\Controllers\Backend\Meal;

use App\Http\Controllers\Backend\Traits\PointsCalculation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Meals\DeleteMultipleMealsRequest;
use App\Http\Requests\Backend\Meals\RenderSelectedSidesTableItemsRequest;
use App\Http\Requests\Backend\Meals\StoreMealRequest;
use App\Http\Requests\Backend\Meals\UpdateMealRequest;
use App\Models\Addon;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealController extends Controller
{
    use PointsCalculation;

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        if(\request()->has('sort') && (\request()->sort === 'created_at' || \request()->sort === 'order_id' || \request()->sort === 'name')){
            if (\request()->sort === 'created_at'){
                $meals = Meal::where('type','entry')->with('categories')->latest()->paginate(15);
            }else $meals = Meal::where('type','entry')->with('categories')->orderBy(\request()->sort)->paginate(15);
        } else $meals = Meal::where('type','entry')->with('categories')->orderBy('order_id')->paginate(15);

        return \view('backend.meals.index', compact('meals'));
    }

    /**
     * @param \App\Models\Meal $meal
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Meal $meal): View
    {
        $meal->load(['categories', 'ingredients', 'sides']);

        $mealSides   = old('side_ids')
            ? Meal::whereIn('id', old('side_ids'))->get(['id', 'name', 'price'])
            : $meal->sides;
        $categories  = Category::getCategories();
        $sides = Meal::where('type', 'side')->get();
        $ingredients = Ingredient::all(['id', 'name']);
        $tags        = Tag::get()->pluck(['name'])->toArray();

        return \view('backend.meals.edit', compact(
            'meal',
            'categories',
            'ingredients',
            'tags',
            'sides',
            'mealSides'
        ));
    }

    /**
     * @param \App\Http\Requests\Backend\Meals\UpdateMealRequest $request
     * @param \App\Models\Meal $meal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateMealRequest $request, Meal $meal): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $meal) {
                $meal->updateMeal($request->validated());
            });

            return redirect()->back()->with('success', 'Meal has been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Meal update failed.')->withInput();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        $mealSides   = old('side_ids')
            ? Meal::whereIn('id', old('side_ids'))->get(['id', 'name', 'price'])
            : [];
        $categories  = Category::getCategories();
        $sides       = Meal::where('type', 'side')->get(['id', 'name']);
        $ingredients = Ingredient::all(['id', 'name']);
        $maxId = Meal::where('type', 'entry')->get()->max('order_id') + 1;
        $tags = Tag::get()->pluck(['name'])->toArray();

        return \view('backend.meals.create', compact(
            'categories',
            'sides',
            'ingredients',
            'tags',
            'mealSides',
            'maxId'
        ));
    }

    /**
     * @param \App\Http\Requests\Backend\Meals\StoreMealRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMealRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                Meal::storeMeal($request->validated());
            });

            return redirect()->back()->with('success', 'Meal has been successfully created.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Meal creation failed.')->withInput();
        }
    }

    /**
     * @param \App\Http\Requests\Backend\Meals\RenderSelectedSidesTableItemsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderSelectedSidesTableItems(RenderSelectedSidesTableItemsRequest $request): JsonResponse
    {
        try {
            $sides = $request->has('meal_id')
                ? Meal::findOrFail($request->meal_id)
                    ->sides()
                    ->whereIn('meals.id', $request->side_ids)
                    ->get(['meals.id', 'meals.name', 'meals.price', 'meals.points'])
                : Meal::whereIn('id', $request->side_ids)->get(['id', 'name', 'price', 'points']);

            return response()->json($this->formatResponse('success', null, [
                'sides_table_items_view' => \view('backend.meals.partials.sides-table-items', compact('sides'))->render(),
            ]));
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Rendering side meals table failed.'), 400);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Meal $meal
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Meal $meal): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $meal->sides()->detach();
                $meal->delete();

                return response()->json($this->formatResponse('success', 'Meal has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Meal deletion failed.'), 400);
        }
    }

    /**
     * @param \App\Http\Requests\Backend\Meals\DeleteMultipleMealsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyMultiple(DeleteMultipleMealsRequest $request): JsonResponse
    {
        try {
            DB::transaction(function () use ($request) {
                Meal::whereIn('id', $request->meal_ids)->delete();
            });

            return response()->json($this->formatResponse('success', 'Meal has been successfully deleted.'));
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Meals deletion failed.'), 400);
        }
    }

    public function getSidesByCategory(Request $request)
    {
        try{
            $cat = Category::find($request->ids);
            $sides = $cat->map(function ($item, $key) {
                return $item->meals()->where('type', 'side')->get();
            });
            $sideArr = [];
            foreach ($sides as $cat) {
                foreach ($cat as $side){
                    $sideArr[] = [
                        'id' => $side->id,
                        'text' => $side->name
                    ];
                }
            }
            return response()->json([
                'success' => true,
                'sides' => $sideArr,
            ]);
        }
        catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'msg' => 'Finding sides failed',
            ]);
        }
    }

    public function getCategoryToRemove(Request $request)
    {
        try{
            $cat = Category::find($request->id);
            $sides = $cat->meals()->where('type', 'side')->get();
            $sideArr = [];
            foreach ($sides as $side) {
                $sideArr[] = [
                    'id' => $side->id,
                    'text' => $side->name
                ];
            }
            return response()->json([
                'success' => true,
                'sides' => $sideArr,
            ]);
        }
        catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'msg' => 'Removing sides failed',
            ]);
        }
    }

    public function toggleStatus(Meal $meal)
    {
        try {
            $meal->update([
                'status' => !$meal->status
            ]);

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $exception){
            return response()->json([
            'success' => false,
            'msg' => 'Status toggle failed',
            ]);
        }
    }
}
