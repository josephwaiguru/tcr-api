<?php

namespace App\Domains\Ministry\Events;

use App\Domains\Ministry\Models\MinistryJoinRequest;

class MemberAdmitted
{
    public function __construct(public MinistryJoinRequest $request) {}
}