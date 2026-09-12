<?php

namespace App\Filament\Resources\ComparisonMetrics\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ComparisonMetricsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('title')->searchable()->wrap(),
            TextColumn::make('baseline_value')->label('Baseline')
                ->formatStateUsing(fn ($state, $record): string => $state . $record->suffix),
            TextColumn::make('jono_value')->label('Jono')
                ->formatStateUsing(fn ($state, $record): string => $state . $record->suffix),
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
