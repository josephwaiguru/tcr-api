<?php

namespace App\Filament\Resources\EGroups\RelationManagers;

use App\Filament\Resources\EGroups\EGroupResource;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use App\Filament\Notifications\Notification;

class JoinRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'joinRequests';

    // protected static ?string $relatedResource = EGroupResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Applicant Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'declined' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Requested On'),
            ])
            ->headerActions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-m-check-badge')
                    ->color('success')
                    // Modal form to select a role during approval
                    ->form([
                        Select::make('role_id')
                            ->label('Assign Role')
                            ->options(\App\Models\Role::pluck('name', 'id'))
                            ->default(1) // Assuming 'Member' is ID 1
                            ->required(),
                    ])
                    ->action(function (array $data, $record): void {
                        // 1. Attach user to egroup via pivot with selected role_id
                        $record->eGroup->users()->attach($record->user_id, [
                            'role_id' => $data['role_id'],
                        ]);

                        // 2. Remove the request
                        $record->delete();

                        Notification::make()
                            ->title('Member Added')
                            ->success()
                            ->send();
                    }),
                // DeleteAction::make()->label('Decline'),
            ]);
    }
}
