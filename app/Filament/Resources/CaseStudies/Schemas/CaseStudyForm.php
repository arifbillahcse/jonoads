<?php

namespace App\Filament\Resources\CaseStudies\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CaseStudyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Client')
                    ->schema([
                        TextInput::make('client')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Anonymised is fine — e.g. "Supplement Co."'),
                        TextInput::make('slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Left blank, this is generated from the client name.'),
                        Textarea::make('summary')
                            ->label('What we changed')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('detail')
                            ->label('Longer write-up')
                            ->rows(5)
                            ->columnSpanFull()
                            ->helperText('Only shown for the featured case study.'),
                        TextInput::make('video_url')
                            ->label('YouTube video')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Paste the YouTube link and the card gets a "Watch the Video" button. Leave it blank and no button appears.'),
                    ])
                    ->columns(2),

                Section::make('Results')
                    ->description('The figures that count up on the card. One or two reads best.')
                    ->schema([
                        Repeater::make('stats')
                            ->hiddenLabel()
                            ->relationship()
                            ->schema([
                                TextInput::make('label')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                Toggle::make('is_headline')
                                    ->label('Headline result')
                                    ->helperText('On a featured case study this drives the section heading and the before/after chart.')
                                    ->columnSpan(1),
                                TextInput::make('value')->numeric()->required(),
                                TextInput::make('prefix')->maxLength(10)->placeholder('$'),
                                TextInput::make('suffix')->maxLength(10)->placeholder('x'),
                                TextInput::make('decimals')
                                    ->label('Decimals')
                                    ->numeric()->minValue(0)->maxValue(2)->default(0)
                                    ->helperText('Set 1 for figures like 7.5x.'),
                            ])
                            ->columns(3)
                            ->orderColumn('sort_order')
                            ->reorderableWithDragAndDrop()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                            ->addActionLabel('Add result')
                            ->maxItems(3),
                    ]),

                Section::make('Visibility')
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Featured')
                            ->helperText('Featured cases get the longer write-up block on the work page.'),
                        Toggle::make('is_published')->label('Published')->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
