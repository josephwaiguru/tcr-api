<?php

namespace App\Domains\EGroups\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Filament\Notifications\Notification as FilamentNotification;

class JoinRequestApproved extends Notification
{
    use Queueable;

    public function __construct(
        public $egroup
            ) {}

    public function via($notifiable): array
    {
        // 'database' makes it show up in the Filament bell icon
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('E-Group Join Request Approved')
            ->line("Join request for {$this->egroup->name} has been approved.")
            ->line('Thank you for being a part of our community!');
    }
}