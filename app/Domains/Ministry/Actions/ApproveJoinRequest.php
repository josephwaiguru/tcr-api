<?php
namespace App\Domains\Ministry\Actions;

use App\Domains\Ministry\Models\MinistryJoinRequest;
use App\Domains\Ministry\Models\MinistryMember;

class ApproveJoinRequest
{
    public function execute(MinistryJoinRequest $request, string $leaderId)
    {
        $request->update([
            'status' => 'approved',
            'reviewed_by' => $leaderId,
            'reviewed_at' => now(),
        ]);

        return MinistryMember::create([
            'ministry_id' => $request->ministry_id,
            'user_id' => $request->user_id,
            'role' => 'member',
            'status' => 'active',
            'church_id' => $request->church_id,
        ]);
    }
}