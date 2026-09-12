<?php

namespace App\Filament\Resources\Stats;

use App\Filament\Resources\Stats\Pages\ManageStats;
use App\Filament\Resources\Stats\Schemas\StatForm;
use App\Filament\Resources\Stats\Tables\StatsTable;
use App\Models\Stat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StatResource extends Resource
{
    protected static ?string $model = Stat::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::ChartBar;

    protected static string | UnitEnum | null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Stat';

    protected static ?string $pluralModelLabel = 'Stats';

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Schema $schema): Schema
    {
        return StatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StatsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageStats::route('/'),
        ];
    }
}
