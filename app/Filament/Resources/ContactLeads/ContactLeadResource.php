<?php

namespace App\Filament\Resources\ContactLeads;

use App\Filament\Resources\ContactLeads\Pages\ManageContactLeads;
use App\Filament\Resources\ContactLeads\Schemas\ContactLeadForm;
use App\Filament\Resources\ContactLeads\Tables\ContactLeadsTable;
use App\Models\ContactLead;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ContactLeadResource extends Resource
{
    protected static ?string $model = ContactLead::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Inbox;

    protected static string | UnitEnum | null $navigationGroup = 'Leads';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Enquiry';

    protected static ?string $pluralModelLabel = 'Enquiries';

    protected static ?string $recordTitleAttribute = 'name';

    /** Draws attention to enquiries nobody has picked up yet. */
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()->where('status', 'new')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function form(Schema $schema): Schema
    {
        return ContactLeadForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactLeadsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageContactLeads::route('/'),
        ];
    }
}
