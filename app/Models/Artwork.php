<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

        // Generate a slug and append a 4-character random string
        $randomString = bin2hex(random_bytes(2)); // Generate 4-character random string
        $this->attributes['slug'] = Str::slug($value) . '-' . $randomString;
    }

    /**
     * Get the category that owns the Artwork
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the stock associated with the Artwork
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    /**
     * Get all of the transaction for the Artwork
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function collector(): HasMany
    {
        return $this->hasMany(Collector::class);
    }

    /**
     * Automatically generate artwork_code before saving.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($artwork) {
            // Get category initials
            $category = $artwork->category()->first();
            $categoryInitials = collect(explode(' ', $category->title))
                ->map(fn($word) => strtoupper($word[0]))
                ->join('');

            // Get title initials
            $titleInitials = collect(explode(' ', $artwork->title))
                ->map(fn($word) => strtoupper($word[0]))
                ->join('');

            // Get the last artwork in the same category
            $lastArtwork = Artwork::where('category_id', $artwork->category_id)
                ->orderBy('id', 'desc')
                ->first();

            // Increment number based on the last artwork
            $increment = $lastArtwork ? intval(substr($lastArtwork->artwork_code, -3)) + 1 : 1;

            // Generate artwork code
            $artwork->artwork_code = sprintf(
                '%s%s-%03d',
                $categoryInitials,
                $titleInitials,
                $increment
            );
        });
    }
}
