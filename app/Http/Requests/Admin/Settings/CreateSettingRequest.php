<?php

namespace App\Http\Requests\Admin\Settings;

use App\Http\Requests\BaseRequest;

class CreateSettingRequest extends BaseRequest
{
    public function postRule()
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
}
