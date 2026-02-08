<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Circular extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'circular_number', 'circular_date', 
        'file_path', 'uploaded_by', 'level', 'division_id', 'district_id', 'is_published'
    ];

    protected $casts = [
        'circular_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
