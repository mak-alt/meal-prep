<?php

namespace App\Notifications\Coupons;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SentCoupon extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\Coupon
     */
    protected Coupon $coupon;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $discountType = $this->coupon->discount_type === 'currency' ? '$' : '%';

        return (new MailMessage)
            ->subject($this->coupon->coupon_name)
            ->markdown('backend.emails.coupons',[
                'coupon' => $this->coupon,
                'discountType' => $discountType,
            ]);
    }
}
