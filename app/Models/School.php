<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'udise_code',
        'district_id',
        'division_id',
        'block',
        'address',
        'email',
        'phone',
        'type',
        'is_active',
    ];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function staffs(): HasMany
    {
        return $this->hasMany(Staff::class);
    }

    public function sanctionedPosts(): HasMany
    {
        return $this->hasMany(SanctionedPost::class);
    }

    public function studentStrengths(): HasMany
    {
        return $this->hasMany(StudentStrength::class);
    }

    public function infrastructure(): HasMany
    {
        return $this->hasMany(SchoolInfrastructure::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(SchoolDocument::class);
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class);
    }
}
