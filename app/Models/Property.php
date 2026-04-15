<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    protected $fillable = [
        'name',
        'description',
        'short_description',
        'category_id',
        'price',
        'area',
        'rooms',
        'floor',
        'floors_total',
        'address',
        'image',
        'gallery',
        'status',
        'is_featured',
        'alias',
        'position',
    ];

    protected $casts = [
        'gallery'     => 'array',
        'is_featured' => 'boolean',
        'price'       => 'integer',
        'area'        => 'float',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('assets/admin/images/default/default-property.jpg');
    }
}
