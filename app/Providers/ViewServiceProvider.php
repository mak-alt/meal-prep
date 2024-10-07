<?php

namespace App\Providers;

use App\Http\ViewComposers\AdminSidebarViewComposer;
use App\Http\ViewComposers\GoogleAnalyticsViewComposer;
use App\Http\ViewComposers\LoginViewComposer;
use App\View\Composers\AuthStatusComposer;
use App\View\Composers\CategoriesComposer;
use App\View\Composers\SeoHeadMetaDataComposer;
use App\View\Composers\SupportContactsComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['frontend.layouts.app', 'frontend.layouts.landing'], SeoHeadMetaDataComposer::class);
        View::composer(['frontend.layouts.app', 'frontend.layouts.landing'], GoogleAnalyticsViewComposer::class);
        View::composer('backend.layouts.partials.sidebar-new', AdminSidebarViewComposer::class);
        View::composer([
            'frontend.layouts.partials.app.left-sidebar',
            'frontend.order-and-menu.partials.content-header',
            'frontend.addons.show',
            'frontend.landing.index',
            'backend.categories.index',
        ], CategoriesComposer::class);
        View::composer([
            'frontend.layouts.partials.app.left-sidebar',
            'frontend.layouts.partials.landing.footer',
            'frontend.orders.show',
            'frontend.layouts.partials.subscribe-centered',
            'frontend.layouts.partials.app.footer',
            'emails.order-shipped',
            'emails.order-shipped-admin',
        ], SupportContactsComposer::class);
        View::composer(['frontend.*'], AuthStatusComposer::class);
        View::composer('frontend.landing.index', LoginViewComposer::class);
    }
}
