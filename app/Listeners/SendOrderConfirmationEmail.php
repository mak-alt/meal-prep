<?php

namespace App\Listeners;

use App\Events\CheckoutCompleted;
use App\Mail\OrderShipped;
use App\Mail\OrderShippedAdmin;
use App\Models\Setting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationEmail
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CheckoutCompleted $event)
    {
        $email = Setting::key('order_email')->first()->data ?? 'amptestsiteorders@gmail.com';
        Mail::to($event->email)->send(new OrderShipped($event->order, $event->user));
        Mail::to($email)->send(new OrderShippedAdmin($event->order,$event->user));
    }
}
