<?php

namespace App\Filament\Resources\Industries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class IndustryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('note')->required()->maxLength(255)
                ->helperText('The demand pattern shown under the name.'),
            Toggle::make('is_published')->label('Published')->default(true),
            ]);
    }
}
