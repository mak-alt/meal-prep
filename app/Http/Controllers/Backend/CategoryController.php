<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Categories\StoreCategoryRequest;
use App\Http\Requests\Backend\Categories\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return \view('backend.categories.index');
    }

    /**
     * @param \App\Models\Category $category
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Category $category): View
    {
        $label = '';
        if ($category->images()->count() > 0){
            foreach ($category->images as $image){
                $label .= ($image->name ?? '') . ', ';
            }
            $label = trim($label, ', ');
        }
        return \view('backend.categories.edit', compact('category', 'label'));
    }

    /**
     * @param \App\Http\Requests\Backend\Categories\UpdateCategoryRequest $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        try {
            $category->updateCategory($request->validated());

            return redirect()->back()->with('success', 'Category has been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Category update failed.')->withInput();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return \view('backend.categories.create');
    }

    /**
     * @param \App\Http\Requests\Backend\Categories\StoreCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        try {
            Category::storeCategory($request->validated());

            return redirect()->back()->with('success', 'Category has been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Category creation failed.')->withInput();
        }
    }

    public function destroy(Category $category){
        try {
            $category->delete();

            return response()->json($this->formatResponse('success', 'Category has been successfully deleted.'));
        }
        catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Category deletion failed.'), 400);
        }
    }
}
