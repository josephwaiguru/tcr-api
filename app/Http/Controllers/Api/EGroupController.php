<?php

namespace App\Http\Controllers\Api;

use App\Domains\EGroups\Actions\CreateJoinRequest;
use App\Http\Controllers\Controller;
use App\Domains\EGroups\Models\EGroup;
use App\Http\Resources\EGroupResource;
use Illuminate\Http\Request;
use App\Domains\EGroups\Notifications\JoinRequestCreated;

class EGroupController extends Controller
{
    public function index(Request $request)
    {
        // 1. Identify the tenant (Church) 
        // You can pass this via header or domain
        $churchId = $request->header('X-Church-Id');

        $groups = EGroup::where('church_id', $churchId)
            ->with(['leader']) // Eager load leader
            ->withCount('members') // Get current membership count
            // ->where('is_active', true)
            ->when($request->category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->latest()
            ->paginate(12);

        return EGroupResource::collection($groups);
    }

    public function joinRequest(Request $request, EGroup $egroup, CreateJoinRequest $action)
    {
        try {
            $user = $request->user();

            // 1. Check if already a member or has a pending request
            if ($egroup->members()->where('user_id', $user->id)->exists()) {
                return response()->json(['message' => 'You are already a member of this group.'], 422);
            }

            // 2. Attach the user with a 'pending' status
            $action->execute($egroup, $user, ['note' => 'I would like to join this group.']);

            // 3. Trigger a Filament Notification for the Leader
            if ($egroup->leader) {
                $egroup->leader->notify(new JoinRequestCreated($egroup, $user));
            }

            return response()->json([
                'message' => 'Join request sent successfully. The leader will review it soon.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
