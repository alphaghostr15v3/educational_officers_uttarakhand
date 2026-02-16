<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryPhoto extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
