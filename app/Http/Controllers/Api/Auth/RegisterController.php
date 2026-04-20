<?php
// app/Http/Controllers/Api/Auth/RegisterController.php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Domains\Users\Actions\RegisterUserAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * Handle the incoming registration request.
     */
    public function __invoke(Request $request, RegisterUserAction $registerAction): JsonResponse
    {
        // 1. Validation
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Execute Domain Logic
        $data['church_id'] = $request->header('X-Church-ID'); // Pass church context
        $user = $registerAction->execute($data);

        // 3. Create Sanctum Token
        $token = $user->createToken('tcr_auth_token')->plainTextToken;

        // 4. Return Response
        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful. Welcome to TCR!',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token' => $token,
            ]
        ], 201);
    }
}