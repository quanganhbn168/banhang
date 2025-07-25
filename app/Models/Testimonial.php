<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /** @use HasFactory<\Database\Factories\TestimonialFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'position',
        'content',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
