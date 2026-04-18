<?php

namespace App\Filament\Resources\CRM\Visitors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Actions\Action;

class VisitorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('full_name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('phone')
                ->copyable() // Easy for the team to copy to WhatsApp
                ->label('Phone Number'),
            Tables\Columns\TextColumn::make('residence')
                ->badge()
                ->color('gray'),
            Tables\Columns\IconColumn::make('converted_to_user')
                ->boolean()
                ->label('Member?'),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->label('Visit Date')
                ->sortable(),
        ])
        ->filters([
            // Filter to see only people who haven't registered as members yet
            Tables\Filters\TernaryFilter::make('converted_to_user')
                ->label('Show Only New Leads'),
        ])
            ->recordActions([
                EditAction::make(),
                Action::make('promote')
        ->label('Make Member')
        ->icon('heroicon-o-user-plus')
        ->color('success')
        ->requiresConfirmation()
        ->visible(fn ($record) => !$record->converted_to_user)
        ->action(function ($record) {
            // Logic to move them to Users table or trigger an invite email
            $record->update(['converted_to_user' => true]);
            Notification::make()->title('Visitor promoted to Member!')->success()->send();
        })
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
