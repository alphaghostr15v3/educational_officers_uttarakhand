<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Status Constants
    const STATUS_PENDING = 'pending';
    const STATUS_DISTRICT_FORWARDED = 'district_forwarded';
    const STATUS_DIVISION_RECOMMENDED = 'division_recommended';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $casts = [
        'promotion_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes for role-based status filtering
    public function scopePendingDistrict($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopePendingDivision($query)
    {
        return $query->where('status', self::STATUS_DISTRICT_FORWARDED);
    }

    public function scopePendingState($query)
    {
        return $query->where('status', self::STATUS_DIVISION_RECOMMENDED);
    }
}
