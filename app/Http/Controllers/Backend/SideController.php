<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Meals\DeleteMultipleMealsRequest;
use App\Http\Requests\Backend\Sides\StoreSideRequest;
use App\Http\Requests\Backend\Sides\UpdateSideRequest;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SideController extends Controller
{
    public function index(): View
    {
        if(\request()->has('sort') && (\request()->sort === 'created_at' || \request()->sort === 'order_id' || \request()->sort === 'name')){
            if (\request()->sort === 'created_at'){
                $meals = Meal::where('type','side')->latest()->paginate(15);
            }else $meals = Meal::where('type','side')->orderBy(\request()->sort)->paginate(15);
        } else $meals = Meal::where('type','side')->orderBy('order_id')->paginate(15);

        return \view('backend.sides.index', compact('meals'));
    }

    public function edit(Meal $side): View
    {
        $side->load(['ingredients', 'categories']);

        $ingredients = Ingredient::all(['id', 'name']);
        $categories  = Category::getCategories();
        $tags        = Tag::get()->pluck(['name'])->toArray();

        return \view('backend.sides.edit', compact(
            'side',
            'ingredients',
            'categories',
            'tags'
        ));
    }

    public function update(UpdateSideRequest $request, Meal $side): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $side) {
                $side->updateSide($request->validated());
            });

            return redirect()->back()->with('success', 'Side has been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Side update failed.')->withInput();
        }
    }

    public function create(): View
    {
        $maxId = Meal::where('type', 'side')->get()->max('order_id') + 1;
        $ingredients = Ingredient::all(['id', 'name']);
        $categories  = Category::getCategories();
        $tags = Tag::get()->pluck(['name'])->toArray();

        return \view('backend.sides.create', compact(
            'ingredients',
            'maxId',
            'categories',
            'tags'
        ));
    }

    public function store(StoreSideRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                Meal::storeSide($request->validated());
            });

            return redirect()->back()->with('success', 'Side has been successfully created.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Side creation failed.')->withInput();
        }
    }

    public function destroy(Request $request, Meal $side): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $side->sideFor()->detach();
                $side->delete();

                return response()->json($this->formatResponse('success', 'Side has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Side deletion failed.'), 400);
        }
    }

    public function destroyMultiple(DeleteMultipleMealsRequest $request): JsonResponse
    {
        try {
            DB::transaction(function () use ($request) {
                Meal::whereIn('id', $request->meal_ids)->delete();
            });

            return response()->json($this->formatResponse('success', 'Sides has been successfully deleted.'));
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Sides deletion failed.'), 400);
        }
    }
}
