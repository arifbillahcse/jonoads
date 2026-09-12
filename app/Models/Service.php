<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContentCache;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use FlushesSiteContentCache, Publishable, SoftDeletes;

    protected $fillable = [
        'number',
        'title',
        'summary',
        'detail',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function features(): HasMany
    {
        return $this->hasMany(ServiceFeature::class)->orderBy('sort_order');
    }
}
