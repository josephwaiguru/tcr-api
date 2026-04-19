<?php
namespace App\Domains\EGroups\Actions;

use App\Domains\EGroups\Models\EGroup;
use App\Models\User;
use App\Domains\EGroups\Models\JoinRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class CreateJoinRequest
{
    /**
     * Execute the join request logic.
     */
    public function execute(EGroup $egroup, User $user, array $data = []): JoinRequest
    {
        return DB::transaction(function () use ($egroup, $user, $data) {
            // Prevent duplicate pending requests
            $existing = JoinRequest::where('user_id', $user->id)
                ->where('e_group_id', $egroup->id)
                ->where('status', 'pending')
                ->first();

            if ($existing) {
                throw new Exception("You already have a pending request for this group.");
            }

            return JoinRequest::create([
                'user_id'    => $user->id,
                'e_group_id'  => $egroup->id,
                'status'     => 'pending',
                'notes'       => $data['note'] ?? null,
            ]);
        });
    }
}