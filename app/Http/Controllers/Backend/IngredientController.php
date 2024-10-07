<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Ingredients\StoreIngredientRequest;
use App\Http\Requests\Backend\Ingredients\UpdateIngredientRequest;
use App\Models\Ingredient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $ingredients = Ingredient::latest()->paginate(15);

        return \view('backend.ingredients.index', compact('ingredients'));
    }

    /**
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Ingredient $ingredient): View
    {
        return \view('backend.ingredients.edit', compact('ingredient'));
    }

    /**
     * @param \App\Http\Requests\Backend\Ingredients\UpdateIngredientRequest $request
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateIngredientRequest $request, Ingredient $ingredient): RedirectResponse
    {
        try {
            $ingredient->updateIngredient($request->validated());

            return redirect()->back()->with('success', 'Ingredient has been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Ingredient update failed.')->withInput();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return \view('backend.ingredients.create');
    }

    /**
     * @param \App\Http\Requests\Backend\Ingredients\StoreIngredientRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreIngredientRequest $request): RedirectResponse
    {
        try {
            Ingredient::storeIngredient($request->validated());

            return redirect()->back()->with('success', 'Ingredient has been successfully created.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Ingredient creation failed.')->withInput();
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ingredient $ingredient
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Ingredient $ingredient): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $ingredient->delete();

                return response()->json($this->formatResponse('success', 'Ingredient has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Ingredient deletion failed.'), 400);
        }
    }
}
