<?php

namespace App\Filament\Resources\Industries;

use App\Filament\Resources\Industries\Pages\ManageIndustries;
use App\Filament\Resources\Industries\Schemas\IndustryForm;
use App\Filament\Resources\Industries\Tables\IndustriesTable;
use App\Models\Industry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class IndustryResource extends Resource
{
    protected static ?string $model = Industry::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Briefcase;

    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 6;

    protected static ?string $modelLabel = 'Industry';

    protected static ?string $pluralModelLabel = 'SMB industries';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return IndustryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IndustriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageIndustries::route('/'),
        ];
    }
}
