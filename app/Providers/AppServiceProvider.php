<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Setting;
use App\Observers\OrderObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // Register observers
        Order::observe(OrderObserver::class);
        $mailchimpCredentials = optional(Setting::key('mailchimp')->first())->data ?? null;
        config()->set('newsletter.apiKey', $mailchimpCredentials['api_key'] ?? env('MAILCHIMP_APIKEY'));
        config()->set('newsletter.lists.subscribers.id', $mailchimpCredentials['list_id'] ?? env('MAILCHIMP_LIST_ID'));
    }
}
