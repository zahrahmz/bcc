<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $order_id
 * @property string $order_reference
 * @property string|null $res_code
 * @property string|null $res_string
 * @property string|null $sale_order_id
 * @property string|null $sale_reference_id
 * @property string|null $card_holder_pan
 * @property string|null $bank_name
 * @property string $total_order_price
 * @property string|null $card_holder_info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @method static \App\Models\Eloquent\BaseBuilder|Payment newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Payment newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Payment query()
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereBankName($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereCardHolderInfo($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereCardHolderPan($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereOrderId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereOrderReference($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereResCode($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereResString($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereSaleOrderId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereSaleReferenceId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereTotalOrderPrice($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Payment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Payment extends BaseModel
{
    protected $table = 'payments';

    const FAIL_PAYMENT = 'FAIL_PAYMENT';
    const SUCCESSFUL_PAYMENT = 'SUCCESSFUL_PAYMENT';
    const UNKNOWN_PAYMENT = 'UNKNOWN_PAYMENT';

    protected $fillable = [
        'order_id',
        'order_reference',
        'res_code',
        'res_string',
        'sale_order_id',
        'sale_reference_id',
        'card_holder_pan',
        'sale_order_id',
        'card_holder_info',
        'total_order_price',
        'bank_name',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
