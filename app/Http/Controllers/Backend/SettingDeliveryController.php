<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Settings\UpdateSettingsDeliveryRequest;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingDeliveryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $delivery = optional(Setting::key('delivery')->first())->data ?? [];

        return \view('backend.settings.delivery', compact('delivery'));
    }

    /**
     * @param \App\Http\Requests\Backend\Settings\UpdateSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSettingsDeliveryRequest $request): RedirectResponse
    {
        try {
            Setting::updateOrCreateSettings($request->validated());
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Settings update failed.');
        }

        return redirect()->back()->with('success', 'Settings have been successfully updated.');
    }
}
