<?php

namespace App\Http\Requests\Site\Cart;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ChangeQuantityRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'quantity' => [
                'required',
                Rule::in([1,-1])
            ]
        ];
    }
}
