<?php

namespace App\Http\Requests\Admin\Products;

use App\Http\Requests\BaseRequest;

class updateProductPriceAttributeRequest extends BaseRequest
{
    public function patchRule()
    {
        return [
            'value' => ['required','integer'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'value' => $this->getClean($this->get('value')),
        ]);
    }
}
