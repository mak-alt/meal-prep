<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Setting;
use App\Models\WeeklyMenu;
use Illuminate\Contracts\View\View;

class SiteController extends Controller
{
    /**
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function router(string $slug = '/')
    {
        $page = $slug !== '/'
            ? Page::where('slug', '/' . $slug)->first()
            : Page::where('slug', $slug)->first();
        if ($page === null || $page->status !== 'published') {
            abort(404);
        }

        try {
            return $this->{$page->name}($page);
        } catch (\Exception $e) {
            abort(404);
        }

        return \view('site.page', ['content' => $page->content, 'page' => $page]);
    }

    /**
     * @return View
     */
    public function galleryAndReviews(): View
    {
        $page = Page::where('name', 'galleryAndReviews')->first();

        return \view('frontend.gallery-and-reviews.index', compact('page'));
    }

    /**
     * @return View
     */
    public function partnersAndReferences(): View
    {
        $page = Page::where('name', 'partnersAndReferences')->first();

        return \view('frontend.partners-and-references.index', compact('page'));
    }

    /**
     * @return View
     */
    public function deliveryAndPickup(): View
    {
        $page = Page::where('name', 'deliveryAndPickup')->first();

        return \view('frontend.delivery-and-pickup.index', compact('page'));
    }

    /**
     * @return View
     */
    public function weeklyMenu(): View
    {
        $page = WeeklyMenu::where('status', true)->first();

        $meals = Meal::find($page->data['meals'] ?? []);
        $sides = Meal::find($page->data['sides'] ?? []);
        $other = Meal::find($page->data['other'] ?? []);

        $defaultPortionSize = Setting::getMealsPortionSizes(true)[0];

        return \view('frontend.weekly-menu.index', compact(
            'page',
            'meals',
            'sides',
            'other',
            'defaultPortionSize'
        ));
    }
}
