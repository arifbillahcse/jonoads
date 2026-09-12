<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('number')
                    ->label('Number')
                    ->required()
                    ->maxLength(8)
                    ->placeholder('01')
                    ->helperText('Shown beside the title. Keep the leading zero.'),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('summary')
                    ->label('Homepage copy')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('detail')
                    ->label('Services page copy')
                    ->rows(3)
                    ->columnSpanFull()
                    ->helperText('The shorter version used on the services page card.'),
                Repeater::make('features')
                    ->label('Capabilities')
                    ->relationship()
                    ->schema([
                        TextInput::make('text')->required()->maxLength(255),
                    ])
                    ->orderColumn('sort_order')
                    ->reorderableWithDragAndDrop()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['text'] ?? null)
                    ->addActionLabel('Add capability')
                    ->columnSpanFull(),
                Toggle::make('is_published')->label('Published')->default(true),
            ]);
    }
}
