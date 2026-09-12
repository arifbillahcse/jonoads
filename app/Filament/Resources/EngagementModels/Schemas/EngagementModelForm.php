<?php

namespace App\Filament\Resources\EngagementModels\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EngagementModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
                Repeater::make('features')
                    ->label('What it includes')
                    ->relationship()
                    ->schema([
                        TextInput::make('text')->required()->maxLength(255),
                    ])
                    ->orderColumn('sort_order')
                    ->reorderableWithDragAndDrop()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['text'] ?? null)
                    ->addActionLabel('Add item')
                    ->columnSpanFull(),
                Toggle::make('is_published')->label('Published')->default(true),
            ]);
    }
}
