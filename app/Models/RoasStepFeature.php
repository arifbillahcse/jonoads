<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoasStepFeature extends Model
{

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
