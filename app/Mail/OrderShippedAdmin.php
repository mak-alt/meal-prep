<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShippedAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $user,$order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order,$user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.order-shipped-admin')->with([
            'user' => $this->user,
            'order' => $this->order,
        ]);
    }
}
