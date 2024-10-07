<?php

namespace App\Http\ViewComposers;

use App\Models\AdminMenu;
use Illuminate\View\View;

class AdminSidebarViewComposer
{
    public function compose(View $view)
    {
        //dd(AdminMenu::where('parent_id',null)->get());
        $view->with('adminMenu', AdminMenu::where('parent_id',null)->get());
    }
}
