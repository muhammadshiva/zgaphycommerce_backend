<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'artwork_id',
        'total',
        'available',
    ];

    /**
     * Get the user that owns the Stock
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }
}
