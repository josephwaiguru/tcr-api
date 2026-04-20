<?php

namespace App\Filament\Resources\Ministries\Pages;

use App\Filament\Resources\Ministries\MinistryResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Role;

class CreateMinistry extends CreateRecord
{
    protected static string $resource = MinistryResource::class;

    /**
     * 
     * Add leader to members list
     * 
     * @return void
     */
    protected function afterCreate(): void
    {
        $ministry = $this->record;
        
        // Find the 'Leader' role ID
        $leaderRole = Role::where('name', 'leader')->first();

        // Attach the leader to the pivot table
        if($leaderRole) {
            $ministry->members()->attach($ministry->leader_id, [
                'role_id' => $leaderRole->id,
            ]);
        }
    }
}
