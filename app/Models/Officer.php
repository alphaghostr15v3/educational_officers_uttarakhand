<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Officer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'division_id', 'district_id', 'name', 'designation', 
        'employee_code', 'email', 'mobile', 'date_of_joining', 
        'date_of_birth', 'address', 'photo', 'seniority_number', 'is_active'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }
}
