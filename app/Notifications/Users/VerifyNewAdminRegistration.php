<?php

namespace App\Notifications\Users;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyNewAdminRegistration extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\User
     */
    protected User $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $subject   = "Admin account registered on $appName";
        $greeting  = "Admin account registered on $appName.";

        return (new MailMessage)
            ->from($fromEmail)
            ->subject($subject)
            ->greeting($greeting)
            ->line(
                "An admin account was recently created on $appName. Please confirm the registration of this account.
                 If the account does not need to be verified, you can simply ignore this message and take no action."
            )
            ->line("Name: $notifiable->name")
            ->line("Email: $this->email")
            ->line('Thank you for using our application!');
    }
}
