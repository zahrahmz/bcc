<?php

namespace App\Http\Requests\Admin\Products;

use App\Http\Requests\BaseRequest;
use App\Models\AttributeValue;
use Illuminate\Validation\Rule;

class AssignAttributeRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'attribute_value_id' => ['required','array'],
            'attribute_value_id.*' => ['required',Rule::in(AttributeValue::query()->pluck('id'))],
            'quantity' => ['required','integer'],
            'price' => ['required','integer'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'quantity' => $this->getClean($this->get('quantity')),
            'price' => $this->getClean($this->get('price'))
        ]);
    }
}
