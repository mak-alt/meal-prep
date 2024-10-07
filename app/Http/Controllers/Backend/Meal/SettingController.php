<?php

namespace App\Http\Controllers\Backend\Meal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Meals\Settings\RenderPortionSizeTableItemRequest;
use App\Http\Requests\Backend\Meals\Settings\UpdateMealsSettingsRequest;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $portionSizes = old('portion_sizes') ?? Setting::getMealsPortionSizes();

        return \view('backend.meals.settings.index', compact('portionSizes'));
    }

    /**
     * @param UpdateMealsSettingsRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateMealsSettingsRequest $request): RedirectResponse
    {
        try {
            $data = ['portion_sizes' => $request->portion_sizes];

            Setting::updateOrCreateSettings($data);

            return redirect()->back()->with('success', 'Meals settings have been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Meals settings update failed.')->withInput();
        }
    }

    /**
     * @param RenderPortionSizeTableItemRequest $request
     * @return JsonResponse
     */
    public function renderPortionSizeTableItem(RenderPortionSizeTableItemRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                return response()->json($this->formatResponse('success', null, [
                    'portion_size_table_item' => \view('backend.meals.settings.partials.portion-size-table-item', [
                        'index'            => $request->index,
                        'withDeleteButton' => true,
                    ])->render(),
                ]));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Rendering portion size failed.'), 400);
            }
        }
    }
}
