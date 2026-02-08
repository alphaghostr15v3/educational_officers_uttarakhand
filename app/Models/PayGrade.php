<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayGrade extends Model
{
    protected $fillable = [
        'name',
        'range',
        'grade_pay',
        'is_active',
    ];
}
