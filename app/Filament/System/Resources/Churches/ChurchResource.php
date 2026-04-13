<?php

namespace App\Filament\System\Resources\Churches;

use App\Filament\System\Resources\Churches\Pages\CreateChurch;
use App\Filament\System\Resources\Churches\Pages\EditChurch;
use App\Filament\System\Resources\Churches\Pages\ListChurches;
use App\Filament\System\Resources\Churches\Schemas\ChurchForm;
use App\Filament\System\Resources\Churches\Tables\ChurchesTable;
use App\Domains\Church\Models\Church;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ChurchResource extends Resource
{
    protected static ?string $model = Church::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Church';

    public static function form(Schema $schema): Schema
    {
        return ChurchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChurchesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChurches::route('/'),
            'create' => CreateChurch::route('/create'),
            'edit' => EditChurch::route('/{record}/edit'),
        ];
    }
}
