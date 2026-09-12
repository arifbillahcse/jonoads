<?php

namespace App\Filament\Resources\ContactLeads\Schemas;

use App\Models\ContactLead;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactLeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Enquiry')
                    ->description('Submitted from the site. These fields are read-only.')
                    ->schema([
                        TextInput::make('name')->disabled(),
                        TextInput::make('email')->disabled(),
                        TextInput::make('company')->disabled(),
                        TextInput::make('phone')->disabled(),
                        TextInput::make('monthly_spend')->label('Monthly spend')->disabled(),
                        TextInput::make('source_page')->label('Submitted from')->disabled(),
                        Textarea::make('message')->rows(6)->disabled()->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Follow-up')
                    ->schema([
                        Select::make('status')
                            ->options(ContactLead::STATUSES)
                            ->required()
                            ->native(false),
                        Textarea::make('internal_notes')
                            ->label('Internal notes')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Only visible here, never on the site.'),
                    ])
                    ->columns(2),
            ]);
    }
}
