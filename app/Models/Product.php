<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 * @property int $id
 * @property string $name
 * @property decimal $price
 * @property float $rating
 * @property bool $in_stock
 * @property int $category_id
 * @property Category $category
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 */

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'price' => 'double',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
