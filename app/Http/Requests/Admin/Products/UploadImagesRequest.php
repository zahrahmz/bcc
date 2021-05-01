<?php

namespace App\Http\Requests\Admin\Products;

use App\Http\Requests\BaseRequest;

class UploadImagesRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'images' => ['required'],
            'images.*' => [
                'required',
                'mimes:jpg,jpeg,png',
                'max:1096',
            ],
        ];
    }
}
