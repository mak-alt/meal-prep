<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class SupportContactsComposer
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
        $supportLocation    = optional(Setting::key('support_location')->first())->data ?? '';
        $supportPhoneNumber = optional(Setting::key('support_phone_number')->first())->data ?? '';
        $supportEmail       = optional(Setting::key('support_email')->first())->data ?? env('MAIL_FROM_ADDRESS');
        $socialMediaData    = [
            'facebook_url'  => optional(Setting::key('facebook_url')->first())->data ?? '',
            'twitter_url'   => optional(Setting::key('twitter_url')->first())->data ?? '',
            'instagram_url' => optional(Setting::key('instagram_url')->first())->data ?? '',
        ];
        $main_photo       = Setting::key('thumb')->first()->data ?? 'assets/frontend/img/home-section1-img.jpg';
        $sub_photo       = Setting::key('thumb2')->first()->data ?? 'assets/frontend/img/subscribe.png';

        $view->with('supportLocation', $supportLocation);
        $view->with('supportPhoneNumber', $supportPhoneNumber);
        $view->with('supportEmail', $supportEmail);
        $view->with('socialMediaData', $socialMediaData);
        $view->with('main_photo', $main_photo);
        $view->with('sub_photo', $sub_photo);
    }
}
