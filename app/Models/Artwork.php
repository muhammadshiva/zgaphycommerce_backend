<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Artwork extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'artwork_code',
        'title',
        'slug',
        'category_id',
        'description',
        'price',
        'series',
        'frame_width',
        'frame_height',
        'image',
        'qr_code_url',
        'qr_code_image',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
