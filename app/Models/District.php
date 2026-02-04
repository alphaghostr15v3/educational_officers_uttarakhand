<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['division_id', 'name', 'code', 'description', 'is_active'];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function officers(): HasMany
    {
        return $this->hasMany(Officer::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }
}
