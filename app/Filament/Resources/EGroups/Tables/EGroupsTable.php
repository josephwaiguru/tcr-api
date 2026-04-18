<?php

namespace App\Filament\Resources\EGroups\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables;

class EGroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('leader.name')->label('Leader'),
                Tables\Columns\TextColumn::make('meeting_date')->badge()->color('info'),
                Tables\Columns\TextColumn::make('meeting_time')->time('g:i A'),
                Tables\Columns\TextColumn::make('members_count')->counts('members')->label('Members'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('meeting_date'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
