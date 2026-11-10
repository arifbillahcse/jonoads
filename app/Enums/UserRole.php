<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Editor = 'editor';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Editor => 'Editor',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Admin => 'Full access, including settings and user management.',
            self::Editor => 'Same access as an admin, except admin accounts cannot be deleted or changed.',
        };
    }

    public static function options(): array
    {
        return array_column(
            array_map(fn (self $c) => ['value' => $c->value, 'label' => $c->label()], self::cases()),
            'label',
            'value'
        );
    }
}
