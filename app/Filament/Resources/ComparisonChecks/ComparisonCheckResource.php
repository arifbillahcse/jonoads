<?php

namespace App\Filament\Resources\ComparisonChecks;

use App\Filament\Resources\ComparisonChecks\Pages\ManageComparisonChecks;
use App\Filament\Resources\ComparisonChecks\Schemas\ComparisonCheckForm;
use App\Filament\Resources\ComparisonChecks\Tables\ComparisonChecksTable;
use App\Models\ComparisonCheck;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ComparisonCheckResource extends Resource
{
    protected static ?string $model = ComparisonCheck::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::CheckCircle;

    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Checklist item';

    protected static ?string $pluralModelLabel = 'Comparison checklist';

    protected static ?string $recordTitleAttribute = 'text';

    public static function form(Schema $schema): Schema
    {
        return ComparisonCheckForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ComparisonChecksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageComparisonChecks::route('/'),
        ];
    }
}
