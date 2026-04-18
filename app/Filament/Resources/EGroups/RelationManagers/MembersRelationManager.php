<?php

namespace App\Filament\Resources\EGroups\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms;
use Filament\Filament;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. Select the User (Only shows if creating a new member)
            Forms\Components\Select::make('user_id')
                ->options(\App\Models\User::pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required()
                ->disabled(fn ($record) => $record !== null), // Lock user once joined

            // 2. Select the Role from your roles table
            Forms\Components\Select::make('role_id')
                ->label('Assigned Role')
                ->options(fn () => \App\Models\Role::pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ])
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('pivot.role_id')
                    ->label('Role')
                    ->formatStateUsing(fn ($state) => \App\Models\Role::find($state)?->name ?? 'N/A')
                    ->badge(),
        ]);
    }
}
