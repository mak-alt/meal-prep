<?php

namespace App\Notifications\Profile;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateEmailVerificationCodeSent extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    protected string $verificationCode;

    /**
     * UpdateEmailVerificationCodeSent constructor.
     * @param string $verificationCode
     */
    public function __construct(string $verificationCode)
    {
        $this->verificationCode = $verificationCode;
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
            ->subject("Update email address attempt on $appName.")
            ->greeting("Update email address attempt on $appName.")
            ->line('We have received a request to change the email address. In order to confirm the change of the email address, please enter this code to verify the action.')
            ->line("Code: $this->verificationCode")
            ->line('Thank you for using our application!');
    }
}
