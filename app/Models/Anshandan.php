<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anshandan extends Model
{
    protected $fillable = [
        'user_id',
        'member_name',
        'depositor_name',
        'school_office',
        'amount',
        'month',
        'year',
        'payment_date',
        'receipt_no',
        'receipt_file',
        'payment_method',
        'transaction_id',
        'district_id',
        'block_id',
        'academic_year',
        'remarks',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
