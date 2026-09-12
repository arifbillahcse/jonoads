<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContentCache;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TeamMember extends Model
{
    use FlushesSiteContentCache, HasFactory, Publishable, SoftDeletes;

    protected $fillable = [
        'name',
        'role',
        'bio',
        'photo_path',
        'initials',
        'is_founder',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_founder' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (TeamMember $member) {
            if (blank($member->initials)) {
                $member->initials = $member->deriveInitials();
            }
        });
    }

    /** Bio is stored newline-separated and rendered as paragraphs. */
    public function bioParagraphs(): array
    {
        $parts = preg_split('/\n+/', (string) $this->bio) ?: [];

        return array_values(array_filter(array_map('trim', $parts), 'strlen'));
    }

    public function deriveInitials(): string
    {
        $words = preg_split('/\s+/', trim((string) $this->name)) ?: [];
        $words = array_values(array_filter($words));

        return match (count($words)) {
            0 => '',
            1 => Str::upper(Str::substr($words[0], 0, 1)),
            default => Str::upper(Str::substr($words[0], 0, 1) . Str::substr(end($words), 0, 1)),
        };
    }

    public function scopeFounders(Builder $query): Builder
    {
        return $query->where('is_founder', true);
    }

    public function scopeTeam(Builder $query): Builder
    {
        return $query->where('is_founder', false);
    }
}
