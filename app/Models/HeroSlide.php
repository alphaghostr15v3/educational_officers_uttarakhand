<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
        'link',
        'sort_order',
        'is_active'
    ];

    public function getImageUrlAttribute()
    {
        return asset('uploads/hero_slides/' . $this->image_path);
    }
}
