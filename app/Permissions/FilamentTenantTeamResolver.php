<?php

namespace App\Permissions;

use Filament\Facades\Filament;
use Spatie\Permission\Contracts\PermissionsTeamResolver;

class FilamentTenantTeamResolver implements PermissionsTeamResolver
{
    public function getPermissionsTeamId(): int|string|null
    {
        return Filament::getTenant()?->id;
    }

    public function setPermissionsTeamId(int|string|\Illuminate\Database\Eloquent\Model|null $id): void
    {
        // No need to set the team ID, as it is determined dynamically based on the current tenant.
    }
}
