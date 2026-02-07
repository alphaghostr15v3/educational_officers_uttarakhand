<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolDocument extends Model
{
    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
