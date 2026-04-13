<?php

namespace App\Filament\System\Resources\Churches\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Str;

class ChurchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true) // Updates the slug when you click away or stop typing
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (($get('slug') ?? '') !== Str::slug($old)) {
                            return;
                        }
                    
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true) // Prevents duplicate URLs for different churches
                    ->hint('Auto-generated from name'),

                TextInput::make('email')
                    ->label('Email Address')
                    ->email() // Validates the format
                    ->required()
                    ->unique(ignoreRecord: true) // Prevents duplicate church records with the same email
                    ->prefixIcon('heroicon-m-envelope') // Adds a nice UI touch
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel() // Opens the numeric keypad on mobile devices
                    ->required()
                    ->mask('0799 999 999') // Guides the user for local formats
                    ->placeholder('0712 345 678')
                    ->prefixIcon('heroicon-m-phone')
                    ->maxLength(255),

                TextInput::make('location')
                    ->label('Location')
                    ->required()
                    ->maxLength(255),


            ]);
    }
}
