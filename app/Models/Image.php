<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    
    use HasFactory;

    protected $fillable = [
        'type', // e.g., product, project, service
        'item_id', // id of the product/project/service
        'image',
    ];

    public function item()
    {
        return $this->morphTo();
    }
}
