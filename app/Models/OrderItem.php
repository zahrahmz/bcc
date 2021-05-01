<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;

/**
 * App\Models\OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int $quantity
 * @property string $product_price
 * @property string $product_size
 * @property string $product_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Order $order
 * @method static \App\Models\Eloquent\BaseBuilder|OrderItem newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|OrderItem newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|OrderItem query()
 * @method static \App\Models\Eloquent\BaseBuilder|OrderItem whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|OrderItem whereDeletedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|OrderItem whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|OrderItem whereOrderId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|OrderItem whereProductName($value)
 * @method static \App\Models\Eloquent\BaseBuilder|OrderItem whereProductPrice($value)
 * @method static \App\Models\Eloquent\BaseBuilder|OrderItem whereProductSize($value)
 * @method static \App\Models\Eloquent\BaseBuilder|OrderItem whereQuantity($value)
 * @method static \App\Models\Eloquent\BaseBuilder|OrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderItem extends BaseModel
{
    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
        'quantity',
        'product_price',
        'product_size',
        'product_name',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
