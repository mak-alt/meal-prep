<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Delivery\CalculateDeliveryFeesRequest;
use App\Models\Order;
use App\Models\Page;
use App\Models\Setting;
use App\Services\SessionStorageHandlers\ShoppingCartSessionStorageService;
use Illuminate\Http\JsonResponse;

class DeliveryController extends Controller
{
    /**
     * @param \App\Http\Requests\Frontend\Delivery\CalculateDeliveryFeesRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function calculateDeliveryFees(CalculateDeliveryFeesRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {

                $delivery = optional(Setting::key('delivery')->first())->data ?? [];
                $z_i_p_codes = $delivery["zip_codes"] ?? [];

                $keyCode = array_search($request->search_address, array_column($z_i_p_codes, 'code'));
                if (!empty($z_i_p_codes) && ($keyCode !== false)) {
                    $deliveryFees = $z_i_p_codes[$keyCode]['price'];
                } elseif ($request->filled('is_within_perimeter_of_i_285')) {
                        $deliveryFees = $request->get('is_within_perimeter_of_i_285') === 'true'
                            ? $delivery['within_i_285']
                            : $delivery['outside_i_285'];
                } else {
                    $deliveryFees = null;
                }

                return response()->json($this->formatResponse('success', null, [
                    'hide_delivery_price' => !$request->filled('is_within_perimeter_of_i_285'),
                    'delivery_fees'      => $deliveryFees,
                ]));

            } catch (\Throwable $exception) {

                return response()->json($this->formatResponse('error', 'Calculating total order price failed.'), 400);
            }
        }
    }

}
