<?php

namespace App\Filament\Resources\EGroups\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Schemas\Components\Section;

class EGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                ->description('Core ministry details')
                ->schema([
                    Forms\Components\TextInput::make('name')->required()->maxLength(255),
                    Forms\Components\Select::make('leader_id')
                        ->relationship('leader', 'name') // Pulls from the 'leader' relation defined in Model
                        ->searchable()
                        ->preload() // Useful if you have a manageable number of users
                        ->required()
                        ->label('Group Leader'),                    Forms\Components\Textarea::make('description')->columnSpanFull(),
                ])->columns(1),

            Section::make('Logistics & Contact')
                ->schema([
                    Forms\Components\TextInput::make('location')->required(),
                    Forms\Components\Select::make('meeting_date')
                        ->options([
                            'Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday',
                            'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday',
                        ])->required(),
                    Forms\Components\TimePicker::make('meeting_time')->required(),
                    Forms\Components\TextInput::make('phone')->tel()->required(),
                    Forms\Components\TextInput::make('email')->email(),
                ])->columns(2),
            ]);
    }
}
