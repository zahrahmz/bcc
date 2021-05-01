<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;

/**
 * App\Models\WishList
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \App\Models\Eloquent\BaseBuilder|WishList newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|WishList newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|WishList query()
 * @method static \App\Models\Eloquent\BaseBuilder|WishList whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|WishList whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|WishList whereProductId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|WishList whereUpdatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|WishList whereUserId($value)
 * @mixin \Eloquent
 */
class WishList extends BaseModel
{
    protected $fillable = [
        'product_id',
        'user_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
