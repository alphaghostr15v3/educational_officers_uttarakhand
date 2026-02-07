<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_PENDINGDistrict = 'pending';
    const STATUS_DISTRICT_FORWARDED = 'district_forwarded';
    const STATUS_DIVISION_RECOMMENDED = 'division_recommended';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public function scopePendingDistrict($query)
    {
        return $query->where('status', self::STATUS_PENDINGDistrict);
    }

    public function scopePendingDivision($query)
    {
        return $query->where('status', self::STATUS_DISTRICT_FORWARDED);
    }

    public function scopePendingState($query)
    {
        return $query->where('status', self::STATUS_DIVISION_RECOMMENDED);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fromOffice()
    {
        return $this->belongsTo(School::class, 'from_office_id');
    }

    public function toOffice()
    {
        return $this->belongsTo(School::class, 'to_office_id');
    }

    public function fromSchool()
    {
        return $this->belongsTo(School::class, 'from_school_id');
    }

    public function toSchool()
    {
        return $this->belongsTo(School::class, 'to_school_id');
    }
}
