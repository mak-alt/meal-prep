<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckoutCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email,$order, $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order, $email, $user)
    {
        $this->order = $order;
        $this->email = $email;
        $this->user = $user;
    }
}
