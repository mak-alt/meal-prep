<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\DelayedDeletion;
use App\Models\Menu;
use App\Models\Order;
use App\Services\SessionStorageHandlers\ShoppingCartSessionStorageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $shoppingCartOrders  = ShoppingCartSessionStorageService::getMappedStoredData();
        $isShoppingCartEmpty = $shoppingCartOrders->isEmpty();

        return \view('frontend.shopping-cart.index', compact('isShoppingCartEmpty', 'shoppingCartOrders'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $isStored = ShoppingCartSessionStorageService::updateOrStore(true);

                if (!$isStored) {
                    return response()->json($this->formatResponse('error', 'Adding to cart failed.'), 400);
                }

                $uuid = session()->get(Order::ONBOARDING_SESSION_KEYS['current_meal_selection_uuid']);
                $menuId = session()->get(ShoppingCartSessionStorageService::SESSION_KEY . ".$uuid")['menu_id'] ?? null;
                if (isset($menuId)){
                    $menu = Menu::find($menuId);

                    if (session()->has('menu-duplicate') && isset($menu)){
                        $array = session()->get('menu-duplicate') ?? null;
                        if (array_key_exists($menu->id, $array)){
                            $count = $array[$menu->id];
                            for ($i = 1; $i <= $count; $i++){
                                ShoppingCartSessionStorageService::duplicateStoredData($uuid);
                            }
                        }
                        session()->forget('menu-duplicate');
                    }
                }

                if(!auth()->check()) {
                    //ShoppingCartSessionStorageService::forgetAllOnboardingData();
                    return response()->json($this->formatResponse('success', null, [
                        'redirect' => route('frontend.shopping-cart.index'),
                    ]));
                } else {
                    return response()->json($this->formatResponse('success', null, [
                        'redirect' => route('frontend.checkout.proceed-to-checkout'),
                    ]));
                }
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Adding to cart failed.'), 400);
            }
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function completeMenu(Request $request, string $uuid): JsonResponse
    {
        if ($request->ajax()) {
            try {
                if (!ShoppingCartSessionStorageService::hasStoredData($uuid)) {
                    return response()->json(
                        $this->formatResponse(
                            'error',
                            'The menu you are trying to complete no longer exists in your shopping cart. Refresh the page to see menus that were not expired.'
                        ),
                        400
                    );
                }

                $firstMealNumberWithWarning = ShoppingCartSessionStorageService::completeMenu($uuid);

                return response()->json($this->formatResponse('success', null, [
                    'redirect' => route('frontend.order-and-menu.select-meals', $firstMealNumberWithWarning ?? 1),
                ]));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Completing menu failed.'), 400);
            }
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function duplicate(Request $request, string $uuid): JsonResponse
    {
        if ($request->ajax()) {
            try {
                if (!ShoppingCartSessionStorageService::hasStoredData($uuid)) {
                    return response()->json(
                        $this->formatResponse(
                            'error',
                            'The menu you are trying to duplicate no longer exists in your shopping cart. Refresh the page to see menus that were not expired.'
                        ),
                        400
                    );
                }

                setSessionResponseMessage('Menu has been successfully duplicated.');

                ShoppingCartSessionStorageService::duplicateStoredData($uuid);

                return response()->json($this->formatResponse('success'));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Duplicating menu failed.'), 400);
            }
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, string $uuid): JsonResponse
    {
        if ($request->ajax()) {
            try {
                if (!ShoppingCartSessionStorageService::hasStoredData($uuid)) {
                    return response()->json(
                        $this->formatResponse(
                            'error',
                            'The menu you are trying to delete no longer exists in your shopping cart. Refresh the page to see menus that were not expired.'
                        ),
                        400
                    );
                }

                $delayedDeletionSessionKey = DelayedDeletion::BASE_SESSION_KEY . '.' . ShoppingCartSessionStorageService::SESSION_KEY;

                if (session()->has($delayedDeletionSessionKey)) {
                    ShoppingCartSessionStorageService::forget(session()->get($delayedDeletionSessionKey));
                    session()->forget($delayedDeletionSessionKey);
                }

                session()->put($delayedDeletionSessionKey, $uuid);

                return response()->json($this->formatResponse('success', 'Menu has been successfully deleted from your shopping cart.'));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Deleting menu from shopping cart failed.'), 400);
            }
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function undoDestroy(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $delayedDeletionSessionKey = DelayedDeletion::BASE_SESSION_KEY . '.' . ShoppingCartSessionStorageService::SESSION_KEY;

                if (!session()->has($delayedDeletionSessionKey)) {
                    return response()->json(
                        $this->formatResponse(
                            'error',
                            'The menu you are trying to restore no longer exists in your shopping cart. Refresh the page to see menus that were not expired.'
                        ),
                        400
                    );
                }

                session()->forget($delayedDeletionSessionKey);

                return response()->json($this->formatResponse('success', 'Menu has been successfully restored to your shopping cart.'));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Undoing deleting menu from shopping cart failed.'), 400);
            }
        }
    }
}
