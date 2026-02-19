<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block extends Model
{
    use HasFactory;

    protected $fillable = ['district_id', 'name', 'code', 'is_active'];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function schools(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(School::class);
    }
}
