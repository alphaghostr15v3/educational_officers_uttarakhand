<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortalForm extends Model
{
    protected $fillable = [
        'title',
        'hindi_title',
        'icon',
        'file_path',
        'external_url',
        'is_active',
        'sort_order'
    ];
}
