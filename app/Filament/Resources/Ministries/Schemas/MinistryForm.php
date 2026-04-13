<?php

namespace App\Filament\Resources\Ministries\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class MinistryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                Textarea::make('description'),

                Select::make('leader_id')
                    ->relationship('leader', 'name')
                    ->searchable()
                    ->required(),
            ]);
    }
}
