<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * Global values that appear across the site — contact address, community
 * links, footer line. Backed by the key/value site_settings table so adding a
 * new setting never needs a migration.
 */
class ManageSiteSettings extends Page
{
    protected static string | BackedEnum | null $navigationIcon = Heroicon::Cog6Tooth;

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Site settings';

    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->canManageSettings() ?? false;
    }

    public function getTitle(): string
    {
        return 'Site settings';
    }

    public function mount(): void
    {
        $this->form->fill(SiteSetting::all_values());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact')
                    ->schema([
                        TextInput::make('contact_email')
                            ->label('Contact email')
                            ->email()
                            ->required()
                            ->helperText('Shown in the footer and used for enquiry notifications.'),
                        TextInput::make('site_domain')
                            ->label('Display domain')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Booking')
                    ->schema([
                        TextInput::make('calendly_url')
                            ->label('Calendly booking link')
                            ->url()
                            ->helperText('Every "Schedule a call" button opens this. Leave it blank and they go to the contact form instead.'),
                    ]),

                Section::make('Brand')
                    ->schema([
                        FileUpload::make('hero_image')
                            ->label('Homepage hero image')
                            ->image()
                            ->disk('public')
                            ->directory('brand')
                            ->helperText('A wide, dark-ish photo works best — it sits behind the headline. Leave it empty and the animated chart runs instead.'),
                        FileUpload::make('logo_image')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('brand')
                            ->helperText('Replaces the "Jono" wordmark in the header and footer. SVG or a transparent PNG works best.'),
                    ]),

                Section::make('Links')
                    ->description('Leave a link blank to hide it from the footer.')
                    ->schema([
                        TextInput::make('skool_url')->label('Skool community')->url(),
                        TextInput::make('podcast_url')->label('Podcast')->url(),
                        TextInput::make('merch_url')->label('Merch store')->url(),
                    ])
                    ->columns(3),

                Section::make('Footer')
                    ->schema([
                        TextInput::make('footer_note')
                            ->label('Copyright line')
                            ->helperText('The year is added automatically.'),
                    ]),
            ])
            ->statePath('data');
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            $this->getFormContentComponent(),
        ]);
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make([
                    Action::make('save')
                        ->label('Save changes')
                        ->submit('save'),
                ]),
            ]);
    }

    public function save(): void
    {
        foreach ($this->form->getState() as $key => $value) {
            SiteSetting::query()
                ->where('key', $key)
                ->update(['value' => $value]);
        }

        // The model clears its cache on save, but these are bulk updates.
        cache()->forget(SiteSetting::CACHE_KEY);

        Notification::make()
            ->success()
            ->title('Settings saved')
            ->send();
    }
}
