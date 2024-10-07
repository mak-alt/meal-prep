<?php

namespace App\Providers;

use App\Events\CheckoutCompleted;
use App\Listeners\ManageCheckoutSessionDataAfterOrderCreation;
use App\Listeners\SendOrderConfirmationEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class        => [
            SendEmailVerificationNotification::class,
        ],
        CheckoutCompleted::class => [
            ManageCheckoutSessionDataAfterOrderCreation::class,
            SendOrderConfirmationEmail::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
