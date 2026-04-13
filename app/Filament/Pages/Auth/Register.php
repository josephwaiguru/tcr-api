<?php
namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Church\Models\Church;
use Log;

class Register extends BaseRegister
{
    protected function handleRegistration(array $data): Model
    {
        // 1. Create the User record
        $user = parent::handleRegistration($data);

        // 2. Locate your Default Church
        // Since you're using UUIDs, find it by a consistent attribute or a known UUID string
        $defaultChurch = Church::where('slug', 'trinity-chapel-ruiru')->first() 
                         ?? Church::first(); // Fallback to the first created church

        Log::info('Default Church found for registration:', ['church_id' => $defaultChurch?->id]);
        if ($defaultChurch) {
            // 3. Create the Database Link (Pivot)
            $user->churches()->attach($defaultChurch->id);

            // 4. Set the Spatie Team Context and assign the role
            setPermissionsTeamId($defaultChurch->id);
            $user->assignRole('member');
            
            // Optional: Reset team context to null to prevent side effects in the session
            setPermissionsTeamId(null);
        }

        return $user;
    }
}