<?php

namespace App\Http\Requests\Admin\Users;

use App\Http\Requests\BaseRequest;
use Baloot\Models\City;
use Baloot\Models\Province;
use Illuminate\Validation\Rule;

class AddressRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'province' => [
                'required',
                Rule::in(Province::query()->pluck('name')->toArray())
            ],
            'city' => [
                'required',
                Rule::in(City::query()->pluck('name')->toArray())
            ],
            'postal_code' => [
                'required',
                'integer',
                'digits:10'
            ],
            'name_of_receiver' => ['required'],
            'phone' =>[
                'required',
                'phone:IR',
                'unique:admins,mobile'
            ],
            'address' => ['required']
        ];
    }
}
