<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Settings\UpdateSettingsDeliveryRequest;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingDeliveryTimeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        /*$deliveryTimes = optional(Setting::key('delivery_times')->first())->data ?? [];
        $pickupTimes = optional(Setting::key('pickup_times')->first())->data ?? [];
        $pickupTimesB = optional(Setting::key('pickup_times_brookhaven')->first())->data ?? [];
        //dd($deliveryTimes, $pickupTimes, $pickupTimesB);

        return \view('backend.settings.delivery-time', compact('deliveryTimes', 'pickupTimes', 'pickupTimesB'));*/


        $deliveryTime = optional(Setting::key('delivery_times')->first())->data ?? [];
        $deliveryTime = $deliveryTime[0]['days_available'][0];

        return \view('backend.settings.delivery-time', compact('deliveryTime'));
    }

    public function update(Request $request): RedirectResponse
    {
        try {
            $deliveryTime = optional(Setting::key('delivery_times')->first())->data ?? [];
            foreach ($deliveryTime as &$item){
                foreach ($item['days_available'] as &$day){
                    $day['times'] = $request->delivery_time;
                }
            }
            Setting::updateOrCreateSettings(['delivery_times' => $deliveryTime]);
            /*Setting::updateOrCreateSettings(['delivery_times' => $request->delivery]);
            Setting::updateOrCreateSettings(['pickup_times' => $request->pickup]);
            Setting::updateOrCreateSettings(['pickup_times_brookhaven' => $request->pickupB]);*/
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Settings update failed.');
        }

        return redirect()->back()->with('success', 'Settings have been successfully updated.');
    }
}
