<?php

namespace App\Filament\Resources\ComparisonMetrics\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ComparisonMetricForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
            TextInput::make('baseline_label')->label('Baseline label')->default('Avg agency')->required(),
            TextInput::make('baseline_value')->label('Baseline value')->numeric()->required(),
            TextInput::make('jono_label')->label('Our label')->default('Jono')->required(),
            TextInput::make('jono_value')->label('Our value')->numeric()->required(),
            TextInput::make('suffix')->maxLength(10)->placeholder('%'),
            Toggle::make('is_published')->label('Published')->default(true),
            ]);
    }
}
