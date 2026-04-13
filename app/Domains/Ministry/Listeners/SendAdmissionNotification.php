<?php

namespace App\Domains\Ministry\Listeners;

use App\Domains\Ministry\Events\MemberAdmitted;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAdmissionNotification implements ShouldQueue
{
    public function handle(MemberAdmitted $event)
    {
        // send email / SMS
    }
}