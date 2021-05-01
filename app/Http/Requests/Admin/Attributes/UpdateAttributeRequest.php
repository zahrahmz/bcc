<?php

namespace App\Http\Requests\Admin\Attributes;

use App\Http\Requests\BaseRequest;

class UpdateAttributeRequest extends BaseRequest
{
    public function patchRule()
    {
        return [
            'attribute_name' => ['required']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'attribute_name' => $this->getClean($this->get('attribute_name')),
        ]);
    }
}
