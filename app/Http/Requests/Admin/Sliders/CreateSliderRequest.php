<?php

namespace App\Http\Requests\Admin\Sliders;

use App\Http\Requests\BaseRequest;
use App\Models\Slider;
use Illuminate\Validation\Rule;

class CreateSliderRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'section'=>[
                'required',
                Rule::in([Slider::HOME_MIDDLE,Slider::HOME_TOP])
            ]
        ];
    }
}
