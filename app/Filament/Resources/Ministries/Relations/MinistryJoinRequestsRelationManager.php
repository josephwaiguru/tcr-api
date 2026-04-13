<?php

namespace App\Filament\Resources\Ministries\Relations;

use App\Domains\Ministry\Models\MinistryJoinRequest;
use App\Domains\Ministry\Services\MinistryService;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class MinistryJoinRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'joinRequests';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('skills_note'),
                TextColumn::make('availability')
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),
                BadgeColumn::make('status'),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function (MinistryJoinRequest $record) {
                        $service = app(MinistryService::class);
                        $member = $service->approve($record, Auth::id());

                        Notification::make()
                            ->title('Join request approved')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (MinistryJoinRequest $record) => $record->status === 'pending'),
                Action::make('reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->action(function (MinistryJoinRequest $record) {
                        $record->update(['status' => 'rejected']);

                        Notification::make()
                            ->title('Join request rejected')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (MinistryJoinRequest $record) => $record->status === 'pending'),
            ]);
    }
}