<?php

namespace App\Filament\Resources\CaseStudies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CaseStudiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client')->searchable(),
                TextColumn::make('stats_count')->label('Results')->counts('stats'),
                TextColumn::make('summary')->limit(60)->wrap(),
                IconColumn::make('is_featured')->label('Featured')->boolean(),
                IconColumn::make('is_published')->label('Published')->boolean(),
            ])
            ->filters([
                TernaryFilter::make('is_published')->label('Published'),
                TernaryFilter::make('is_featured')->label('Featured'),
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
