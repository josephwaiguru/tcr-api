<?php

namespace App\Filament\Resources\Ministries;

use App\Filament\Resources\Ministries\Pages\CreateMinistry;
use App\Filament\Resources\Ministries\Pages\EditMinistry;
use App\Filament\Resources\Ministries\Pages\ListMinistries;
use App\Filament\Resources\Ministries\Schemas\MinistryForm;
use App\Filament\Resources\Ministries\Relations\MinistryMembersRelationManager;
use App\Filament\Resources\Ministries\Relations\MinistryJoinRequestsRelationManager;
use App\Domains\Ministry\Models\Ministry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MinistryResource extends Resource
{
    protected static ?string $model = Ministry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Ministry';

    // protected static UnitEnum|string|null  $navigationGroup = 'Ministry Management';

    public static function form(Schema $schema): Schema
    {
        return MinistryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MinistriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MinistryMembersRelationManager::class,
            MinistryJoinRequestsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMinistries::route('/'),
            'create' => CreateMinistry::route('/create'),
            'edit' => EditMinistry::route('/{record}/edit'),
        ];
    }
}
