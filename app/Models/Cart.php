<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;
use App\Models\Site\CartItem;

/**
 * App\Models\Cart
 *
 * @property int $id
 * @property int $user_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|CartItem[] $cartItems
 * @property-read int|null $cart_items_count
 * @property-read mixed $cart_item_count
 * @method static \App\Models\Eloquent\BaseBuilder|Cart newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Cart newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Cart query()
 * @method static \App\Models\Eloquent\BaseBuilder|Cart whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Cart whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Cart whereStatus($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Cart whereUpdatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Cart whereUserId($value)
 * @mixin \Eloquent
 */
class Cart extends BaseModel
{
    const ACTIVE = 'ACTIVE';
    const UNKNOWN = 'UNKNOWN';
    const GO_FOR_PAYMENT = 'GO_FOR_PAYMENT';
    const PAID = 'PAID';

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'status',
    ];


    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getCartItemCountAttribute()
    {
        return $this->cartItems()->sum('quantity');
    }
}
