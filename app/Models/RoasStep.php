<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContentCache;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoasStep extends Model
{
    use FlushesSiteContentCache, Publishable, SoftDeletes;

    protected $fillable = [
        'number',
        'title',
        'summary',
        'detail',
        'icon_svg',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'number' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function features(): HasMany
    {
        return $this->hasMany(RoasStepFeature::class)->orderBy('sort_order');
    }
}
