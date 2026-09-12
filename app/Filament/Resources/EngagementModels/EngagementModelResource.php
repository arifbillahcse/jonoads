<?php

namespace App\Filament\Resources\EngagementModels;

use App\Filament\Resources\EngagementModels\Pages\ManageEngagementModels;
use App\Filament\Resources\EngagementModels\Schemas\EngagementModelForm;
use App\Filament\Resources\EngagementModels\Tables\EngagementModelsTable;
use App\Models\EngagementModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EngagementModelResource extends Resource
{
    protected static ?string $model = EngagementModel::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::AdjustmentsHorizontal;

    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 7;

    protected static ?string $modelLabel = 'Engagement model';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return EngagementModelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EngagementModelsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageEngagementModels::route('/'),
        ];
    }
}
