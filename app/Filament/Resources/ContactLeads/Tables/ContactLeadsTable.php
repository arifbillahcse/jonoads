<?php

namespace App\Filament\Resources\ContactLeads\Tables;

use App\Models\ContactLead;
use App\Support\CsvExport;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Icons\Heroicon;
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
            ->headerActions([
                Action::make('export')
                    ->label('Export CSV')
                    ->icon(Heroicon::ArrowDownTray)
                    ->action(fn (Table $table) => CsvExport::stream(
                        // Respects whatever filter and search the user has applied.
                        $table->getQuery(),
                        [
                            'created_at' => 'Received',
                            'name' => 'Name',
                            'email' => 'Email',
                            'company' => 'Company',
                            'phone' => 'Phone',
                            'monthly_spend' => 'Monthly spend',
                            'status' => 'Status',
                            'message' => 'Message',
                            'source_page' => 'Source page',
                        ],
                        'enquiries-' . now()->format('Y-m-d') . '.csv',
                    )),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
