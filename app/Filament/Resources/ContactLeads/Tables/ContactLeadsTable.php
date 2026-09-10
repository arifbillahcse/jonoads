<?php

namespace App\Filament\Resources\ContactLeads\Tables;

use App\Models\ContactLead;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactLeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('j M Y, H:i')
                    ->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable()->copyable(),
                TextColumn::make('company')->searchable()->placeholder('—'),
                TextColumn::make('monthly_spend')->label('Spend')->placeholder('—'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ContactLead::STATUSES[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'warning',
                        'contacted' => 'info',
                        'qualified' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(ContactLead::STATUSES),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make()->label('Open'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
