<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('category')->required()->maxLength(255)
                ->helperText('What they do, shown under the name.'),
            TextInput::make('url')->url()->maxLength(255),
            FileUpload::make('logo_path')->label('Logo')->image()->disk('public')->directory('partners'),
            Toggle::make('is_published')->label('Published')->default(true),
            ]);
    }
}
