<?php

namespace App\Filament\Resources\CRM\Visitors\Schemas;

use Filament\Schemas\Schema;

class VisitorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('full_name')->required(),
            Forms\Components\TextInput::make('email')->email(),
            Forms\Components\TextInput::make('phone')->tel()->required(),
            Forms\Components\Select::make('residence')
                ->options([
                    'Ruiru' => 'Ruiru',
                    'Kimbo' => 'Kimbo',
                    'Membley' => 'Membley',
                    'Kihunguro' => 'Kihunguro',
                ]),
            Forms\Components\Textarea::make('prayer_request')
                ->columnSpanFull(),
            ]);
    }
}
