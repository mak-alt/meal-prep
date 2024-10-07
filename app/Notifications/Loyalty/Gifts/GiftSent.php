<?php

namespace App\Notifications\Loyalty\Gifts;

use App\Models\Gift;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GiftSent extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\Gift
     */
    protected Gift $gift;

    /**
     * Create a new notification instance.
     * @param \App\Models\Gift $gift
     * @return void
     */
    public function __construct(Gift $gift)
    {
        $this->gift = $gift;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $appName   = config('app.name');
        $fromEmail = Setting::getSupportEmail();

        return (new MailMessage)
            ->from($fromEmail)
            ->subject("You received a gift card on $appName.")
            ->greeting(
                $this->gift->message .
                "\r\n" .
                sprintf(
                    "You received a gift card for $%d on %s from %s.",
                    $this->gift->amount,
                    $appName,
                    $this->gift->sender_name
                )
            )
            ->line("Code: {$this->gift->code}")
            ->line('To redeem a gift card, follow the link below.')
            ->action('Redeem', route('frontend.gifts.index'))
            ->line('Thank you for using our application!');
    }
}
