<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseStudyStat extends Model
{
    use HasFactory;


    protected $fillable = [
        'case_study_id',
        'label',
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
        ];
    }

    public function caseStudy(): BelongsTo
    {
        return $this->belongsTo(CaseStudy::class);
    }
}
