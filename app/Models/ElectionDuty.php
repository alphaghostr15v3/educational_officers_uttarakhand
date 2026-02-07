<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectionDuty extends Model
{
    protected $fillable = [
        'user_id',
        'election_name',
        'duty_type',
        'location',
        'from_date',
        'to_date',
        'order_number',
        'status',
        'remarks'
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
