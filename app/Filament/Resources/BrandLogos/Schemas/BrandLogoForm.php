<?php

namespace App\Filament\Resources\BrandLogos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BrandLogoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->helperText('Shown as text in the marquee until a logo image is uploaded.'),
            FileUpload::make('image_path')
                ->label('Logo image')
                ->image()
                ->disk('public')
                ->directory('brand-logos')
                ->imageEditor(),
            Toggle::make('is_published')->label('Published')->default(true),
            ]);
    }
}
