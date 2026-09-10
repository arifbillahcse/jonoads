<?php

namespace App\Filament\Resources\Stats\Schemas;

use App\Models\Stat as StatModel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class StatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Select::make('group')
                ->label('Appears in')
                ->options(StatModel::GROUPS)
                ->required()
                ->native(false),
            TextInput::make('label')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            Toggle::make('is_static')
                ->label('Fixed text (does not count up)')
                ->helperText('Use for figures like "24/7" that would look wrong animating from zero.')
                ->live()
                ->columnSpanFull(),
            TextInput::make('static_value')
                ->label('Text to show')
                ->visible(fn (Get $get): bool => (bool) $get('is_static'))
                ->required(fn (Get $get): bool => (bool) $get('is_static'))
                ->maxLength(50),
            TextInput::make('value')
                ->label('Counts up to')
                ->numeric()
                ->visible(fn (Get $get): bool => ! $get('is_static'))
                ->required(fn (Get $get): bool => ! $get('is_static')),
            TextInput::make('prefix')->maxLength(10)->placeholder('$')
                ->visible(fn (Get $get): bool => ! $get('is_static')),
            TextInput::make('suffix')->maxLength(10)->placeholder('M+')
                ->visible(fn (Get $get): bool => ! $get('is_static')),
            TextInput::make('decimals')
                ->label('Decimal places')
                ->numeric()->minValue(0)->maxValue(2)->default(0)
                ->visible(fn (Get $get): bool => ! $get('is_static')),
            Toggle::make('is_published')->label('Published')->default(true),
            ]);
    }
}
