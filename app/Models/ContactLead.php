<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactLead extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUSES = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'qualified' => 'Qualified',
        'archived' => 'Archived',
    ];

    protected $fillable = [
        'name',
        'email',
        'company',
        'phone',
        'monthly_spend',
        'message',
        'status',
        'internal_notes',
        'source_page',
        'ip_address',
        'user_agent',
    ];

    public function scopeUnhandled(Builder $query): Builder
    {
        return $query->where('status', 'new');
    }
}
