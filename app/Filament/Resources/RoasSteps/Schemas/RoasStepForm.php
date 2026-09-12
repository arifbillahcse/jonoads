<?php

namespace App\Filament\Resources\RoasSteps\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RoasStepForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('number')
                    ->label('Step number')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(3)
                    ->required()
                    ->helperText('Also decides which third of the diagram ring lights up.'),
                TextInput::make('title')->required()->maxLength(255),
                Textarea::make('summary')
                    ->label('Short copy')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull()
                    ->helperText('Used beside the diagram on the homepage and engine page.'),
                Textarea::make('detail')
                    ->label('Breakdown intro')
                    ->rows(3)
                    ->columnSpanFull()
                    ->helperText('Opening line of the stage breakdown card.'),
                Textarea::make('icon_svg')
                    ->label('Icon (inline SVG)')
                    ->rows(4)
                    ->columnSpanFull()
                    ->helperText('Rendered as raw markup. Paste a full <svg> element only.'),
                Repeater::make('features')
                    ->label('What happens in this stage')
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
