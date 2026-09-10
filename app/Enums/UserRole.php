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
            self::Editor => 'Can edit site content, but not settings or users.',
        };
    }

    /** Settings, user management and anything else that reconfigures the site. */
    public function canManageSettings(): bool
    {
        return $this === self::Admin;
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
