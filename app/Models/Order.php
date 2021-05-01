<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;
use App\Models\Site\User;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $cart_id
 * @property int $user_id
 * @property string $name_of_receiver
 * @property string $province
 * @property string $city
 * @property string $address
 * @property string $postal_code
 * @property string $phone
 * @property string $shipment_type_name
 * @property string $shipment_type_price
 * @property string $total_order_price
 * @property string $order_state وضعیت سفارش که توسط ادمین مشخص میشود
 * @property string $payment_status وضعیت پرداختی کاربر در درگاه بانک
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cart $cart
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $orderItems
 * @property-read int|null $order_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read User $user
 * @method static \App\Models\Eloquent\BaseBuilder|Order newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Order newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Order query()
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereAddress($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereCartId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereCity($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereNameOfReceiver($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereOrderState($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order wherePaymentStatus($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order wherePhone($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order wherePostalCode($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereProvince($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereShipmentTypeName($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereShipmentTypePrice($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereTotalOrderPrice($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereUpdatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends BaseModel
{
    const ORDER_STATUS_IN_PROGRESS= 'ORDER_STATUS_IN_PROGRESS';
    const ORDER_STATUS_APPROVED= 'ORDER_STATUS_APPROVED';
    const ORDER_STATUS_REJECTED= 'ORDER_STATUS_REJECTED';

    protected $table = 'orders';

    protected $fillable = [
        'cart_id',
        'user_id',
        'name_of_receiver',
        'province',
        'city',
        'address',
       'postal_code',
       'phone',
       'shipment_type_name',
       'shipment_type_price',
       'total_order_price',
       'order_state',
       'payment_status',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function getOrderStatuses()
    {
        return [
            self::ORDER_STATUS_IN_PROGRESS,
            self::ORDER_STATUS_APPROVED,
            self::ORDER_STATUS_REJECTED,
        ];
    }
}
