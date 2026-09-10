<?php

namespace App\Filament\Resources\BrandLogos;

use App\Filament\Resources\BrandLogos\Pages\ManageBrandLogos;
use App\Filament\Resources\BrandLogos\Schemas\BrandLogoForm;
use App\Filament\Resources\BrandLogos\Tables\BrandLogosTable;
use App\Models\BrandLogo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BrandLogoResource extends Resource
{
    protected static ?string $model = BrandLogo::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Squares2x2;

    protected static string | UnitEnum | null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Brand logo';

    protected static ?string $pluralModelLabel = 'Brand logos';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BrandLogoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BrandLogosTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageBrandLogos::route('/'),
        ];
    }
}
