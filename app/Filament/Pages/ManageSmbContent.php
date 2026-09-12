<?php

namespace App\Filament\Pages;

use App\Models\SmbContent;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
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
 * The SMB landing page is a single page of copy rather than a list, so it gets
 * one editing screen instead of a resource. Its industry list is a separate
 * resource so it can be reordered.
 */
class ManageSmbContent extends Page
{
    protected static string | BackedEnum | null $navigationIcon = Heroicon::Briefcase;

    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'SMB page';

    protected static ?int $navigationSort = 8;

    public ?array $data = [];

    public function getTitle(): string
    {
        return 'SMB page';
    }

    public function mount(): void
    {
        $this->form->fill(SmbContent::current()->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero')
                    ->schema([
                        TextInput::make('eyebrow')->required()->maxLength(255),
                        TextInput::make('headline')->required()->maxLength(255),
                        Textarea::make('intro')->required()->rows(4)->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Section headings')
                    ->schema([
                        TextInput::make('industries_heading')->label('Industries heading')->required()->maxLength(255),
                        TextInput::make('approach_heading')->label('Approach heading')->required()->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Closing call to action')
                    ->schema([
                        TextInput::make('cta_heading')->label('Heading')->required()->maxLength(255),
                        Textarea::make('cta_body')->label('Body')->required()->rows(3),
                    ])
                    ->columns(2),
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
        SmbContent::current()->update($this->form->getState());

        Notification::make()
            ->success()
            ->title('SMB page updated')
            ->send();
    }
}
