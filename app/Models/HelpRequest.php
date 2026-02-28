<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'target_level',
        'target_division_id',
        'target_district_id',
        'target_block_id',
        'subject',
        'message',
        'status',
        'admin_reply'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function targetDivision()
    {
        return $this->belongsTo(Division::class, 'target_division_id');
    }

    public function targetDistrict()
    {
        return $this->belongsTo(District::class, 'target_district_id');
    }

    public function targetBlock()
    {
        return $this->belongsTo(Block::class, 'target_block_id');
    }
}
