<?php

namespace App\Filament\Resources\ComparisonChecks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ComparisonCheckForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            TextInput::make('text')->required()->maxLength(255)->columnSpanFull(),
            Toggle::make('is_published')->label('Published')->default(true),
            ]);
    }
}
