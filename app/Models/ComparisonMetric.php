<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContentCache;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComparisonMetric extends Model
{
    use FlushesSiteContentCache, Publishable, SoftDeletes;

    protected $fillable = [
        'title',
        'baseline_label',
        'baseline_value',
        'jono_label',
        'jono_value',
        'suffix',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'baseline_value' => 'decimal:2',
            'jono_value' => 'decimal:2',
            'is_published' => 'boolean',
        ];
    }
}
