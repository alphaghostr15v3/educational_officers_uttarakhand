<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'image_path',
        'category',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'event_date' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('event_date', 'desc');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now())->orderBy('event_date', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now())->orderBy('event_date', 'desc');
    }
}
