<?php

namespace App\Http\ViewComposers;

use App\Models\Setting;
use Illuminate\View\View;

class GoogleAnalyticsViewComposer
{
    public function compose(View $view)
    {
        $view->with('googleAnalyticsID', Setting::key('snippetID')->first()->data ?? '');
    }
}
