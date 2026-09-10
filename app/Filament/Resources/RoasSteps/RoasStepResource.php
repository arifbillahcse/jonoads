<?php

namespace App\Filament\Resources\RoasSteps;

use App\Filament\Resources\RoasSteps\Pages\ManageRoasSteps;
use App\Filament\Resources\RoasSteps\Schemas\RoasStepForm;
use App\Filament\Resources\RoasSteps\Tables\RoasStepsTable;
use App\Models\RoasStep;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RoasStepResource extends Resource
{
    protected static ?string $model = RoasStep::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::ArrowPath;

    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'ROAS Engine step';

    protected static ?string $pluralModelLabel = 'ROAS Engine';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return RoasStepForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RoasStepsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRoasSteps::route('/'),
        ];
    }
}
