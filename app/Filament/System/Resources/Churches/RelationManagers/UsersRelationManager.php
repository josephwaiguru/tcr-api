<?php

namespace App\Filament\System\Resources\Churches\RelationManagers;

use App\Filament\System\Resources\Churches\ChurchResource;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $relatedResource = ChurchResource::class;

    protected static ?string $recordTitleAttribute = 'name'; // MUST be a column in the users table

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name') // This tells Filament to use 'name' for the search input
            ->columns([
                TextColumn::make('name')
                    ->searchable(), // Explicitly mark 'name' as searchable
                TextColumn::make('email')
                    ->searchable(),
            ])
            ->headerActions([
                // Use AttachAction to link existing users to this church
                AttachAction::make()
                    ->preloadRecordSelect()
                    // ->recordSelectSearchColumns(['name', 'email']), // Force it to search these columns
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        
                        // Let the admin choose a role for this church during attachment
                        Select::make('role')
                            ->options([
                                'member' => 'Member',
                                'pastor' => 'Pastor',
                                'admin' => 'Church Admin',
                            ])
                            ->required(),
                    ])
                    ->after(function (Model $record, array $data) {
                        // $record is the User being attached
                        // $this->getOwnerRecord() is the Church
                        
                        setPermissionsTeamId($this->getOwnerRecord()->id);
                        $record->assignRole($data['role']);
                    }),
            ])
            ->actions([
                DetachAction::make()
                    ->after(function (Model $record) {
                        // Clean up roles when they leave the church
                        setPermissionsTeamId($this->getOwnerRecord()->id);
                        $record->roles()->detach(); 
                    }),
            ]);
    }
}
