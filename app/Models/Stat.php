<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stat extends Model
{
    use HasFactory, Publishable, SoftDeletes;

    /** The strips a stat can belong to. */
    public const GROUPS = [
        'home_hero' => 'Homepage hero',
        'pedigree' => 'Pedigree bar',
        'engine_hero' => 'ROAS Engine hero',
        'engine_proof' => 'ROAS Engine results strip',
        'team_hero' => 'Team hero',
        'contact_hero' => 'Contact hero',
    ];

    protected $fillable = [
        'group',
        'label',
        'value',
        'prefix',
        'suffix',
        'decimals',
        'is_static',
        'static_value',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'decimals' => 'integer',
            'is_static' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function scopeGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }

    /**
     * The counter animates from zero, so the markup ships the target as data
     * attributes. Static figures such as "24/7" are printed as-is instead.
     */
    public function displayValue(): string
    {
        if ($this->is_static) {
            return (string) $this->static_value;
        }

        return $this->prefix . number_format((float) $this->value, $this->decimals) . $this->suffix;
    }
}
