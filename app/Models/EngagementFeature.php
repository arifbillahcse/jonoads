<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EngagementFeature extends Model
{

    protected $fillable = [
        'engagement_model_id',
        'text',
        'sort_order',
    ];

    public function engagementModel(): BelongsTo
    {
        return $this->belongsTo(EngagementModel::class);
    }
}
