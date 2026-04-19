<?php

namespace App\Domains\Ministry\Listeners;

use App\Domains\Ministry\Events\JoinRequestCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Domains\Ministry\Notifications\NewMinistryApplicantNotification;

class AlertMinistryLeader implements ShouldQueue
{
    public function handle(JoinRequestCreated $event)
    {
        $user = $event->request->user;
        $ministry = $event->request->ministry;

        // Send notification (using Laravel's notification system)
        $ministry->leader()->notify(new NewMinistryApplicantNotification($ministry, $user));
    }
}