<?php

namespace App\Filament\Resources\EGroups\Pages;

use App\Filament\Resources\EGroups\EGroupResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Role;

class CreateEGroup extends CreateRecord
{
    protected static string $resource = EGroupResource::class;

    protected function afterCreate(): void
    {
        $group = $this->record;
        
        // Find the 'Leader' role ID
        $leaderRole = Role::where('name', 'leader')->first();

        // Attach the leader to the pivot table
        if($leaderRole) {
            $group->members()->attach($group->leader_id, [
                'role_id' => $leaderRole->id,
            ]);
        }
    }
}
