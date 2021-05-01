<?php

namespace App\Http\Requests\Site\Order;

use App\Http\Requests\BaseRequest;
use App\Models\Address;
use App\Models\Shipment;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'shipment_id' => [
                'required',
                Rule::in(Shipment::query()->where('status', 1)->pluck('id'))
            ],
            'address_id' => [
                'required',
                Rule::in(Address::query()->where('user_id', currentUserObj()->id)->pluck('id'))
            ]
        ];
    }
}
