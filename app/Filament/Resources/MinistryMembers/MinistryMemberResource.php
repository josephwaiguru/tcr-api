<?php

namespace App\Filament\Resources\MinistryMembers;

use App\Filament\Resources\MinistryMembers\Pages\CreateMinistryMember;
use App\Filament\Resources\MinistryMembers\Pages\EditMinistryMember;
use App\Filament\Resources\MinistryMembers\Pages\ListMinistryMembers;
use App\Filament\Resources\MinistryMembers\Schemas\MinistryMemberForm;
use App\Filament\Resources\MinistryMembers\Tables\MinistryMembersTable;
use App\Domains\Ministry\Models\MinistryMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MinistryMemberResource extends Resource
{
    protected static ?string $model = MinistryMember::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'MinistryMember';

    // protected static UnitEnum|string|null $navigationGroup = 'Ministry Management';

    public static function form(Schema $schema): Schema
    {
        return MinistryMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MinistryMembersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMinistryMembers::route('/'),
            'create' => CreateMinistryMember::route('/create'),
            'edit' => EditMinistryMember::route('/{record}/edit'),
        ];
    }
}
