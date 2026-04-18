<?php

namespace App\Filament\Resources\EGroups\Pages;

use App\Filament\Resources\EGroups\EGroupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEGroup extends EditRecord
{
    protected static string $resource = EGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
