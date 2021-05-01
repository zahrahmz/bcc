<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\ProductAttribute
 *
 * @property int $id
 * @property int $quantity
 * @property int|null $price
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributeValue[] $attributesValues
 * @property-read int|null $attributes_values_count
 * @property-read mixed $formatted_price
 * @property-read mixed $size
 * @property-read \App\Models\Product $product
 * @method static \App\Models\Eloquent\BaseBuilder|ProductAttribute newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|ProductAttribute newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|ProductAttribute query()
 * @method static \App\Models\Eloquent\BaseBuilder|ProductAttribute whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|ProductAttribute whereDeletedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|ProductAttribute whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|ProductAttribute wherePrice($value)
 * @method static \App\Models\Eloquent\BaseBuilder|ProductAttribute whereProductId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|ProductAttribute whereQuantity($value)
 * @method static \App\Models\Eloquent\BaseBuilder|ProductAttribute whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductAttribute extends BaseModel
{
    protected $table = 'product_attributes';

    protected $fillable = [
        'quantity',
        'price',
    ];

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, '', ',');
    }

    /**
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsToMany
     */
    public function attributesValues()
    {
        return $this->belongsToMany(AttributeValue::class);
    }

    public function getSizeAttribute()
    {
        return $this->attributesValues()->first()->value;
    }
}
