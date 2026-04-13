<?php

namespace App\Filament\Resources\Ministries\Relations;

use App\Filament\Resources\MinistryMembers\Tables\MinistryMembersTable;
use App\Domains\Ministry\Models\MinistryMember;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class MinistryMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    public function table(Table $table): Table
    {
        return MinistryMembersTable::configure($table);
    }
}