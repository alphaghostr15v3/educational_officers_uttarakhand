<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeBirthday extends Model
{
    protected $fillable = [
        'name',
        'designation',
        'photo',
        'dob',
        'is_active'
    ];

    protected $casts = [
        'dob' => 'date',
        'is_active' => 'boolean'
    ];

    public function getImageUrlAttribute()
    {
        return $this->photo ? asset('uploads/birthdays/' . $this->photo) : asset('images/default-avatar.png');
    }
}
