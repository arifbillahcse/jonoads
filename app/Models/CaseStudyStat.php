<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\FlushesSiteContentCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseStudyStat extends Model
{
    use FlushesSiteContentCache, HasFactory;

    protected $fillable = [
        'case_study_id',
        'label',
        'is_headline',
        'value',
        'prefix',
        'suffix',
        'decimals',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'decimals' => 'integer',
            'is_headline' => 'boolean',
        ];
    }

    public function caseStudy(): BelongsTo
    {
        return $this->belongsTo(CaseStudy::class);
    }

    /** What the counter counts up to, without the stored decimal padding. */
    public function animationTarget(): string
    {
        $value = (float) $this->value;

        return $this->decimals > 0
            ? number_format($value, $this->decimals, '.', '')
            : (string) (int) round($value);
    }

    /** What shows before the counter starts, and if JavaScript never runs. */
    public function zeroState(): string
    {
        return $this->prefix . number_format(0, $this->decimals) . $this->suffix;
    }

    /** The finished figure, e.g. "3x" or "$20". */
    public function displayValue(): string
    {
        return $this->prefix . number_format((float) $this->value, $this->decimals) . $this->suffix;
    }
}
