<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'image', 'is_ticker', 'ticker_order', 'is_published', 'publish_date', 'created_by'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Scope to get ticker items ordered by priority
     */
    public function scopeTickerOrdered($query)
    {
        return $query->where('is_ticker', true)
                     ->where('is_published', true)
                     ->orderBy('ticker_order', 'asc')
                     ->orderBy('created_at', 'desc');
    }
}
