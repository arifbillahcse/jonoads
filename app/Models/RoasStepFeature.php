<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContentCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoasStepFeature extends Model
{
    use FlushesSiteContentCache;

    protected $fillable = [
        'roas_step_id',
        'text',
        'sort_order',
    ];

    public function roasStep(): BelongsTo
    {
        return $this->belongsTo(RoasStep::class);
    }
}
