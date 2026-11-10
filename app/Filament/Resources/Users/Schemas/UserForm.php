<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Select::make('role')
                    ->options(fn (): array => auth()->user()?->isAdmin()
                        ? UserRole::options()
                        : [UserRole::Editor->value => UserRole::Editor->label()])
                    ->rules([
                        fn (): \Closure => function (string $attribute, mixed $value, \Closure $fail): void {
                            if ($value === UserRole::Admin->value && ! auth()->user()?->isAdmin()) {
                                $fail('Only admins can create or assign admin accounts.');
                            }
                        },
                    ])
                    ->default(UserRole::Editor->value)
                    ->required()
                    ->native(false)
                    ->helperText('Editors and admins can change everything. Only admins can change or remove admin accounts.'),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->helperText(fn (string $operation): ?string => $operation === Operation::Edit->value
                        ? 'Leave blank to keep the current password.'
                        : null),
            ]);
    }
}
