<?php

namespace App\Domains\EGroups\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Filament\Notifications\Notification as FilamentNotification;

class JoinRequestCreated extends Notification
{
    use Queueable;

    public function __construct(
        public $egroup,
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
            ->subject('New E-Group Join Request')
            ->line("{$this->user->name} has requested to join your E-Group: {$this->egroup->name}.")
            ->action('View Requests', url("/admin/egroup-requests"))
            ->line('Thank you for leading!');
    }

    public function toArray($notifiable): array
    {
        // This format is compatible with Filament's database notification plugin
        return FilamentNotification::make()
            ->title('New Join Request')
            ->body("{$this->user->name} wants to join {$this->egroup->name}")
            ->icon('heroicon-o-user-plus')
            ->color('success')
            ->actions([
            \Filament\Notifications\Actions\Action::make('view')
                ->button()
                ->url(url('/admin/join-requests')),
            ])
            ->getDatabaseMessage();
    }
}