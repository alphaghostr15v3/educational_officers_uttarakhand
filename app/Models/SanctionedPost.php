<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanctionedPost extends Model
{
    protected $fillable = [
        'designation_id',
        'level',
        'school_id',
        'district_id',
        'division_id',
        'sanctioned_count',
        'is_active',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
