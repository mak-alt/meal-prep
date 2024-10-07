<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Settings\UpdateSettingsRequest;
use App\Models\AdminMenu;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $supportData         = [
            'email'        => optional(Setting::key('support_email')->first())->data ?? env('MAIL_FROM_ADDRESS'),
            'order_email'  => optional(Setting::key('order_email')->first())->data ?? env('MAIL_FROM_ADDRESS'),
            'phone_number' => optional(Setting::key('support_phone_number')->first())->data ?? '',
            'location'     => optional(Setting::key('support_location')->first())->data ?? '',
        ];
        $socialMediaData     = [
            'facebook_url'  => optional(Setting::key('facebook_url')->first())->data ?? '',
            'twitter_url'   => optional(Setting::key('twitter_url')->first())->data ?? '',
            'instagram_url' => optional(Setting::key('instagram_url')->first())->data ?? '',
        ];
        $seoData             = [
            'title'       => optional(Setting::key('seo_title')->first())->data,
            'description' => optional(Setting::key('seo_description')->first())->data,
            'keywords'    => optional(Setting::key('seo_keywords')->first())->data,
        ];
        $paymentsCredentials = Setting::getPaymentServicesCredentials();

        $googleAnalyticsID = optional(Setting::key('snippetID')->first())->data;

        $mailchimpCredentials = optional(Setting::key('mailchimp')->first())->data ?? [];
        $inviter = optional(Setting::key('amountInviterGets')->first())->data;
        $invitee = optional(Setting::key('amountInviteeGets')->first())->data;

        $twillioCredentials = optional(Setting::key('twillio')->first())->data ?? [];


        return \view('backend.settings.index', compact(
            'supportData',
            'socialMediaData',
            'seoData',
            'paymentsCredentials',
            'googleAnalyticsID',
            'mailchimpCredentials',
            'twillioCredentials',
            'invitee',
            'inviter'
        ));
    }

    /**
     * @param \App\Http\Requests\Backend\Settings\UpdateSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        try {
            Setting::updateOrCreateSettings($request->validated());
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Settings update failed.');
        }

        return redirect()->back()->with('success', 'Settings have been successfully updated.');
    }

    public function sidePanelIndex(){
        $adminMenu = AdminMenu::where('parent_id',null)->get();
        return \view('backend.settings.sidebar-index')->with('adminMenus', $adminMenu);
    }

    public function sidePanelUpdate(Request $request){
        try {
            foreach ($request->all() as $key=>$val){
                AdminMenu::where('id',$key)->update([
                    'name' => $val,
                ]);
            }
        } catch (\Throwable $exception){
            return redirect()->back()->with('error', 'Sidebar update failed.');
        }
        return redirect()->back()->with('success', 'Sidebar was successfully updated.');
    }
}
