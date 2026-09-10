<?php

namespace App\Filament\Resources\ComparisonMetrics;

use App\Filament\Resources\ComparisonMetrics\Pages\ManageComparisonMetrics;
use App\Filament\Resources\ComparisonMetrics\Schemas\ComparisonMetricForm;
use App\Filament\Resources\ComparisonMetrics\Tables\ComparisonMetricsTable;
use App\Models\ComparisonMetric;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ComparisonMetricResource extends Resource
{
    protected static ?string $model = ComparisonMetric::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::PresentationChartLine;

    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Comparison metric';

    protected static ?string $pluralModelLabel = 'Comparison metrics';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ComparisonMetricForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ComparisonMetricsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageComparisonMetrics::route('/'),
        ];
    }
}
