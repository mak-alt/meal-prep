<?php

namespace App\Http\ViewComposers;

use App\Models\Setting;
use Illuminate\View\View;

class LoginViewComposer
{
    public function compose(View $view)
    {
        $main_photo = Setting::key('thumb')->first()->data ?? 'assets/frontend/img/home-section1-img.jpg';
        $view->with('main_photo', $main_photo);
    }
}
