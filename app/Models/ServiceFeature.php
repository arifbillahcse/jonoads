<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContentCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceFeature extends Model
{
    use FlushesSiteContentCache;

    protected $fillable = [
        'service_id',
        'text',
        'sort_order',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
