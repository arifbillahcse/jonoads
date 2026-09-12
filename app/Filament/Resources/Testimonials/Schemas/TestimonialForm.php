<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Textarea::make('quote')
                ->required()
                ->rows(5)
                ->columnSpanFull(),
            TextInput::make('attribution')
                ->required()
                ->maxLength(255)
                ->helperText('A name, or something like "Client feedback" if the quote stays anonymous.'),
            TextInput::make('author_title')->label('Job title')->maxLength(255),
            TextInput::make('company')->maxLength(255),
            Toggle::make('is_featured')->label('Featured'),
            Toggle::make('is_published')->label('Published')->default(true),
            ]);
    }
}
