<?php

namespace App\Domains\Ministry\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewMinistryApplicantNotification extends Notification
{
    use Queueable;

    public function __construct(
        public $ministry,
        public $user
    ) {}

    public function via($notifiable): array
    {
        // 'database' makes it show up in the Filament bell icon
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Ministry Applicant')
            ->line("{$this->user->name} has requested to join your ministry: {$this->ministry->name}.")
            ->line('Thank you for leading!');
    }
}