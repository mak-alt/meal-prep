<?php

namespace App\Notifications\Users;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAdminRegisteredVerificationPending extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    private string $userPassword;

    /**
     * NewDoctorRegistered constructor.
     * @param string $password
     */
    public function __construct(string $password)
    {
        $this->userPassword = $password;
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
        $greeting  = "Thank you for registering on $appName.";

        return (new MailMessage)
            ->from($fromEmail)
            ->subject($subject)
            ->greeting($greeting)
            ->line(
                "Hello $notifiable->name. You recently registered an admin account on $appName.
                Your account has been successfully created and is awaiting confirmation.
                As soon as your account is confirmed, you can log in to your admin account."
            )
            ->line("Your login: $notifiable->email")
            ->line("Your password: $this->userPassword")
            ->line('To log in to your personal admin account, follow the link below.')
            ->action('Login', route('backend.auth.login'))
            ->line('Thank you for using our application!');
    }
}
