<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $casts = [
        'colors' => 'array',
    ];
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'sku',
        'image_path',
        'is_active',
        'slug',
        'colors',
        'category_id',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }



}
