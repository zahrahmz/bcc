<?php

namespace App\Models\Site;

use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Eloquent\BaseModel;
use App\Models\Product;
use App\Models\ProductAttribute;

/**
 * App\Models\Site\CartItem
 *
 * @property int $id
 * @property int $cart_id
 * @property int $quantity
 * @property int|null $product_id
 * @property int|null $product_attribute_id
 * @property int|null $attribute_value_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read AttributeValue|null $attributeValue
 * @property-read Cart $cart
 * @property-read mixed $has_enough_entity_in_stock
 * @property-read mixed $zero_entity_in_stock
 * @property-read Product|null $product
 * @property-read ProductAttribute|null $productAttribute
 * @property-read \App\Models\Site\User $user
 * @method static \App\Models\Eloquent\BaseBuilder|CartItem newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|CartItem newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|CartItem query()
 * @method static \App\Models\Eloquent\BaseBuilder|CartItem whereAttributeValueId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|CartItem whereCartId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|CartItem whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|CartItem whereDeletedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|CartItem whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|CartItem whereProductAttributeId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|CartItem whereProductId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|CartItem whereQuantity($value)
 * @method static \App\Models\Eloquent\BaseBuilder|CartItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CartItem extends BaseModel
{
    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id',
        'quantity',
        'product_id',
        'product_attribute_id',
        'attribute_value_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function getHasEnoughEntityInStockAttribute()
    {
        return $this->productAttribute->quantity < $this->quantity;
    }

    public function getZeroEntityInStockAttribute()
    {
        return $this->productAttribute->quantity < 1;
    }
}
