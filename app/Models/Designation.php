<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable = [
        'name',
        'level',
        'parent_id',
        'order',
        'is_active',
    ];

    public function parent()
    {
        return $this->belongsTo(Designation::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Designation::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(SanctionedPost::class);
    }
}
