<?php

namespace App\Notifications\Loyalty\Referrals;

use App\Models\Referral;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReferralInvitationSent extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\Referral
     */
    protected Referral $referral;

    /**
     * @var string|null
     */
    protected ?string $subject;

    /**
     * @var string|null
     */
    protected ?string $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Referral $referral, ?string $subject = null, ?string $message = null)
    {
        $this->referral = $referral;
        $this->subject  = $subject;
        $this->message  = $message;
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
        $inviter   = $this->referral->inviter;
        $subject   = $this->subject ?? Referral::getDefaultInvitationSubject();
        $message   = $this->message ?? Referral::getDefaultInvitationMessage();
        $greeting  = "You have been invited to join referral program on $appName by $inviter->name.";

        return (new MailMessage)
            ->from($fromEmail)
            ->subject($subject)
            ->greeting($greeting)
            ->line($message)
            ->line('To join our referral program, follow the link below.')
            ->action('Join', route('frontend.referrals.join', $inviter->referral_code))
            ->line('Thank you for using our application!');
    }
}
