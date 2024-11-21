<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "title",
        "slug",
    ];

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function setTitleAttribute($value)
    {
        $this->attributes["title"] = $value;
        $this->attributes["slug"] = Str::slug($value);
    }

    /**
     * Get the user associated with the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(Artwork::class, 'foreign_key', 'local_key');
    }
}
