<?php

namespace App\Filament\Resources\EGroups\Pages;

use App\Filament\Resources\EGroups\EGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEGroups extends ListRecords
{
    protected static string $resource = EGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
