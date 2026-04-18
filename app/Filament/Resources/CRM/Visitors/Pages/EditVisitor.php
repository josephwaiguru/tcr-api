<?php

namespace App\Filament\Resources\CRM\Visitors\Pages;

use App\Filament\Resources\CRM\Visitors\VisitorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVisitor extends EditRecord
{
    protected static string $resource = VisitorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
