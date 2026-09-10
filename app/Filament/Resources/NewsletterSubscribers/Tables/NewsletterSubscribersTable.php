<?php

namespace App\Filament\Resources\NewsletterSubscribers\Tables;

use App\Models\NewsletterSubscriber;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NewsletterSubscribersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')->searchable()->copyable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => NewsletterSubscriber::STATUSES[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'pending' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')->label('Signed up')->dateTime('j M Y')->sortable(),
                TextColumn::make('confirmed_at')->label('Confirmed')->dateTime('j M Y')->placeholder('—'),
                TextColumn::make('source_page')->label('From')->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')->options(NewsletterSubscriber::STATUSES),
            ])
            ->defaultSort('created_at', 'desc')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
