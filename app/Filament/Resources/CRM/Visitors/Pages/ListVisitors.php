<?php

namespace App\Filament\Resources\CRM\Visitors\Pages;

use App\Filament\Resources\CRM\Visitors\VisitorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVisitors extends ListRecords
{
    protected static string $resource = VisitorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
