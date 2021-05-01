<?php

namespace App\Http\Requests\Admin\Attributes;

use App\Http\Requests\BaseRequest;

class CreateAttributeRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'attribute_name' => ['required','unique:attributes,attribute_name']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'attribute_name' => $this->getClean($this->get('attribute_name')),
        ]);
    }
}
