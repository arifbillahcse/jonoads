<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('role')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Head of Client Success'),
                Textarea::make('bio')
                    ->required()
                    ->rows(8)
                    ->columnSpanFull()
                    ->helperText('Leave a blank line between paragraphs — each becomes its own paragraph on the site.'),
                FileUpload::make('photo_path')
                    ->label('Headshot')
                    ->image()
                    ->disk('public')
                    ->directory('team')
                    ->imageEditor()
                    ->helperText('Until a real photo is uploaded, the card shows the initials below.'),
                TextInput::make('initials')
                    ->maxLength(4)
                    ->helperText('Left blank, this is generated from the name.'),
                Toggle::make('is_founder')
                    ->label('Founder')
                    ->helperText('Founders appear in the larger block above the team grid.'),
                Toggle::make('is_published')->label('Published')->default(true),
            ]);
    }
}
