<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class ShipmentRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'price'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'شیوه ارسال اجباری است',
            'price.required'=>'هزینه ارسال اجباری است',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => $this->getClean($this->get('name')),
            'price' => $this->getClean($this->get('price'))
        ]);
    }
}
