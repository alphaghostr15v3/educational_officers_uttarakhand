<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number', 'donor_name', 'mobile', 'district_id', 'amount', 
        'purpose', 'payment_status', 'payment_method', 'transaction_id', 'payment_date'
    ];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
