<?php

namespace App\Filament\Resources\MinistryMembers\Pages;

use App\Filament\Resources\MinistryMembers\MinistryMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMinistryMember extends EditRecord
{
    protected static string $resource = MinistryMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
