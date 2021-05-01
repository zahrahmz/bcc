<?php

namespace App\Http\Requests\Admin\Categories;

use App\Http\Requests\BaseRequest;

class UpdateCategoryRequest extends BaseRequest
{
    public function patchRule()
    {
        return [
            'name'=>'required',
            'order'=>'required|numeric|min:1|max:255',
            'status'=>'required',
            'type'=>'required',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => $this->getClean($this->get('name')),
            'order' => $this->getClean($this->get('order'))
        ]);
    }
}
