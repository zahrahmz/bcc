<?php

namespace App\Http\Requests\Admin\Categories;

use App\Http\Requests\BaseRequest;

class CreateCategoryRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'name' => 'required',
            'slug' => "unique:categories",
            'order' => 'required|numeric|unique:categories|min:1|max:255',
            'status' => 'required',
            'type' => 'required',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => $this->getClean($this->get('name')),
            'order' => $this->getClean($this->get('order')),
            'slug' => $this->getClean($this->get('slug')),
        ]);
    }
}
