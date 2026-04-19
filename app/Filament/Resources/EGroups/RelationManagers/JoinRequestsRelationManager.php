<?php

namespace App\Filament\Resources\EGroups\RelationManagers;

use App\Domains\EGroups\Notifications\JoinRequestApproved;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class JoinRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'joinRequests';

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
                
            ])
            ->actions([
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
                        try {
                            // Use a transaction to ensure we don't have partial success
                            \DB::transaction(function () use ($data, $record) {
                                
                                $group = \App\Domains\EGroups\Models\EGroup::find($record->e_group_id);
                                // Manual lookup to avoid relationship issues
                                $applicant = \App\Models\User::find($record->user_id);

                                if (!$group) {
                                    throw new \Exception('Group record not found.');
                                }

                                // Use syncWithoutDetaching to avoid duplicate errors
                                $group->members()->syncWithoutDetaching([
                                    $record->user_id => ['role_id' => $data['role_id']]
                                ]);

                                // 2. Notification (Optional: Wrap in try/catch if email isn't critical)
                                if ($applicant) {
                                    $applicant->notify(new JoinRequestApproved($group));
                                }

                                // 3. Remove the request
                                $record->delete();
                            });

                            Notification::make()
                                ->title('Member Added')
                                ->success()
                                ->send();

                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Error')
                                ->body('Failed to approve join request: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })

            ]);
    }
}
