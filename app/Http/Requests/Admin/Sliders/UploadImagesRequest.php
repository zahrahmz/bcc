<?php

namespace App\Http\Requests\Admin\Sliders;

use App\Http\Requests\BaseRequest;

class UploadImagesRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'image' => ['required','mimes:jpg,jpeg,png','max:1096']
        ];
    }
}
