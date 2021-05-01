<?php

namespace App\Http\Requests\Admin\Settings;

use App\Http\Requests\BaseRequest;

class UpdateSettingRequest extends BaseRequest
{
    public function patchRule()
    {
        return [
            'name'=>'required',
            'value'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'نام تنظیمات اجباری است',
            'value.required'=>'مقدار اجباری است',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => $this->getClean($this->get('name')),
            'value' => $this->getClean($this->get('value'))
        ]);
    }
}
