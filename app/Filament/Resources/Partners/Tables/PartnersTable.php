<?php

namespace App\Filament\Resources\Partners\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class PartnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('name')->searchable(),
            TextColumn::make('category')->searchable(),
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
