<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class NewsletterSubscriber extends Model
{
    use HasFactory;

    public const STATUSES = [
        'pending' => 'Pending confirmation',
        'confirmed' => 'Confirmed',
        'unsubscribed' => 'Unsubscribed',
    ];

    protected $fillable = [
        'email',
        'status',
        'confirmation_token',
        'confirmed_at',
        'unsubscribed_at',
        'source_page',
        'ip_address',
    ];

    protected $hidden = [
        'confirmation_token',
    ];

    protected function casts(): array
    {
        return [
            'confirmed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }

    /** Signed so the link cannot be forged for somebody else's address. */
    public function unsubscribeUrl(): string
    {
        return URL::signedRoute('newsletter.unsubscribe', ['subscriber' => $this->getKey()]);
    }

    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', 'confirmed');
    }
}
