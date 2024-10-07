<?php

namespace App\Listeners;

use App\Events\CheckoutCompleted;
use App\Services\SessionStorageHandlers\ShoppingCartSessionStorageService;

class ManageCheckoutSessionDataAfterOrderCreation
{
    /**
     * Handle the event.
     *
     * @param CheckoutCompleted $event
     * @return void
     */
    public function handle(CheckoutCompleted $event): void
    {
        ShoppingCartSessionStorageService::forgetAllOnboardingData();
        session()->forget(ShoppingCartSessionStorageService::SESSION_KEY);

        setSessionResponseMessage('Success! Your order is completed.');
    }
}
