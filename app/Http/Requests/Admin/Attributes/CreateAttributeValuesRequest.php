<?php

namespace App\Http\Requests\Admin\Attributes;

use App\Http\Requests\BaseRequest;

class CreateAttributeValuesRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'value' => 'required'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'value' => $this->getClean($this->get('value')),
        ]);
    }
}
