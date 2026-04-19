<?php
namespace App\Domains\Ministry\Services;

use App\Domains\Ministry\Actions\ApproveJoinRequest;
use App\Domains\Ministry\Models\MinistryJoinRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use App\Domains\Ministry\Events\MemberAdmitted;

class MinistryService
{
    public function __construct(
        protected ApproveJoinRequest $approveAction
    ) {}

    public function approve(MinistryJoinRequest $request, string $leaderId)
    {
        return DB::transaction(function () use ($request, $leaderId) {

            $member = $this->approveAction->execute($request, $leaderId);

            Event::dispatch(new MemberAdmitted($request));

            return $member;
        });
    }
}