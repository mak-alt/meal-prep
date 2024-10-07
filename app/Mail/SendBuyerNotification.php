<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendBuyerNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $gift;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($gift)
    {
        $this->gift = $gift;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.gift-purchased')->subject('Thanks for buying a gift card!')->with([
            'gift' => $this->gift,
        ]);
    }
}
