<?php

namespace App\Filament\Resources\NewsletterSubscribers;

use App\Filament\Resources\NewsletterSubscribers\Pages\ManageNewsletterSubscribers;
use App\Filament\Resources\NewsletterSubscribers\Tables\NewsletterSubscribersTable;
use App\Models\NewsletterSubscriber;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class NewsletterSubscriberResource extends Resource
{
    protected static ?string $model = NewsletterSubscriber::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Envelope;

    protected static string | UnitEnum | null $navigationGroup = 'Leads';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Subscriber';

    protected static ?string $recordTitleAttribute = 'email';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return NewsletterSubscribersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageNewsletterSubscribers::route('/'),
        ];
    }
}
