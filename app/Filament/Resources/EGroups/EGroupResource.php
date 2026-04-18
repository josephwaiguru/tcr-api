<?php

namespace App\Filament\Resources\EGroups;

use App\Filament\Resources\EGroups\Pages\CreateEGroup;
use App\Filament\Resources\EGroups\Pages\EditEGroup;
use App\Filament\Resources\EGroups\Pages\ListEGroups;
use App\Filament\Resources\EGroups\Schemas\EGroupForm;
use App\Filament\Resources\EGroups\Tables\EGroupsTable;
use App\Domains\EGroups\Models\EGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\EGroups\RelationManagers\JoinRequestsRelationManager;
use App\Filament\Resources\EGroups\RelationManagers\MembersRelationManager;


class EGroupResource extends Resource
{
    protected static ?string $model = EGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'EGroup';

    public static function form(Schema $schema): Schema
    {
        return EGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EGroupsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            JoinRequestsRelationManager::class,
            MembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEGroups::route('/'),
            'create' => CreateEGroup::route('/create'),
            'edit' => EditEGroup::route('/{record}/edit'),
        ];
    }
}
