<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Ministry\Models\MinistryJoinRequest;
use App\Domains\Ministry\Events\JoinRequestCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use App\Domains\Ministry\Models\Ministry;

class MinistryJoinRequestController extends Controller
{
    public function store(Request $request, Ministry $ministry)
    {
        $request->validate([
            
        ]);

        $user = Auth::user();

        // Check if user is already a member
        $existingMember = \App\Domains\Ministry\Models\MinistryMember::where('ministry_id', $request->ministry_id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingMember) {
            throw ValidationException::withMessages([
                'ministry_id' => 'You are already a member of this ministry.',
            ]);
        }

        // Check if user already has a pending request
        $existingRequest = MinistryJoinRequest::where('ministry_id', $request->ministry_id)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            throw ValidationException::withMessages([
                'ministry_id' => 'You already have a pending join request for this ministry.',
            ]);
        }

        $churchId = $request->header('X-Church-Id');

        $joinRequest = MinistryJoinRequest::create([
            'ministry_id' => $ministry->id,
            'user_id' => $user->id,
            'skills_note' => $request->skills_note,
            'availability' => $request->availability,
            'status' => 'pending',
            'church_id' => $churchId, // Using the church ID from the header
        ]);

        // Fire the event
        Event::dispatch(new JoinRequestCreated($joinRequest));

        return response()->json([
            'message' => 'Join request sent successfully.',
            'data' => $joinRequest,
        ], 201);
    }
}