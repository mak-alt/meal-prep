<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\View\View;

class CategoriesComposer
{
    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     * @return void
     * @throws \Exception
     */
    public function compose(View $view): void
    {

        /*if ($view->getName() === 'backend.categories.index'){
            $categories = Category::getCategories();
        } else */
        $categories = Category::where('key', '!=', 'custom_menu')->get(['id', 'key', 'name', 'description']);
        $categoryId = session()->has(Order::ONBOARDING_SESSION_KEYS['preferred_menu_type_selection'])
            ? (int)session()->get(Order::ONBOARDING_SESSION_KEYS['preferred_menu_type_selection'])
            : null;

        $view->with('categories', $categories);
        $view->with('categoryId', $categoryId);
    }
}
