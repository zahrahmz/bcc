<?php

namespace App\Http\Requests\Admin\Discounts;

use App\Http\Requests\BaseRequest;

class CreateDiscountRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'title'=>'required',
            'percent'=>'required',
            'type'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'discountable_id'=>'',
            'discountable_type'=>'',
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'عنوان اجباری است',
            'percent.required'=>'درصد اجباری است',
            'type.required'=>'نوع اجباری است',
            'start_date.required'=>'تاریخ شروع اجباری است',
            'end_date.required'=>'تاریخ پایان اجباری است',
        ];
    }
}
