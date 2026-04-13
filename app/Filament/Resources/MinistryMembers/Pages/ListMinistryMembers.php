<?php

namespace App\Filament\Resources\MinistryMembers\Pages;

use App\Filament\Resources\MinistryMembers\MinistryMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMinistryMembers extends ListRecords
{
    protected static string $resource = MinistryMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
