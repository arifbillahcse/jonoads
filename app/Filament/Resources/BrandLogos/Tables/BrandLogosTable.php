<?php

namespace App\Filament\Resources\BrandLogos\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class BrandLogosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            ImageColumn::make('image_path')->label('Logo')->disk('public')->height(24),
            TextColumn::make('name')->searchable(),
            IconColumn::make('is_published')->label('Published')->boolean(),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
