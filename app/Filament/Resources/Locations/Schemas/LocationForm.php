<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            TextInput::make('city')->required()->maxLength(255),
            TextInput::make('badge')->maxLength(20)->placeholder('HQ')
                ->helperText('Optional superscript label next to the city.'),
            TextInput::make('discipline')->required()->maxLength(255)
                ->helperText('What the office does, e.g. "Media Buying".'),
            Toggle::make('is_published')->label('Published')->default(true),
            ]);
    }
}
