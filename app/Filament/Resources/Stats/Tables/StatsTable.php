<?php

namespace App\Filament\Resources\Stats\Tables;

use App\Models\Stat as StatModel;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class StatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('group')
                ->label('Appears in')
                ->formatStateUsing(fn (string $state): string => StatModel::GROUPS[$state] ?? $state)
                ->badge()
                ->sortable(),
            TextColumn::make('label')->searchable()->wrap(),
            TextColumn::make('value')
                ->label('Shows as')
                ->getStateUsing(fn (StatModel $record): string => $record->displayValue()),
            IconColumn::make('is_published')->label('Published')->boolean(),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->defaultGroup('group')
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
