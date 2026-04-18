<?php
namespace App\Domains\Users\Actions;

use App\Models\User;
use App\Domains\CRM\Models\Visitor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterUserAction {
    public function execute(array $data): User {
        return DB::transaction(function () use ($data) {
            // 1. Check if they were already a 'Visitor' (by email)
            $visitor = Visitor::where('email', $data['email'])->first();

            // 2. Create or Update the User
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role' => 'member', // Default role
                    'email_verified_at' => null, // Trigger verification later
                ]
            );

            // 3. If they were a visitor, link their history
            if ($visitor) {
                $user->update([
                    'phone' => $visitor->phone,
                    'residence' => $visitor->residence,
                ]);
                // Mark visitor as converted so they don't show up in "New Leads"
                $visitor->update(['converted_to_user' => true]);
            }

            return $user;
        });
    }
}