<?php

namespace App\Http\Requests\Site\Auth;

use App\Http\Requests\BaseRequest;

class ForgotPasswordRequest extends BaseRequest
{
    public function postRule()
    {
        return [
          'mobile' => [
              'required',
              'phone:IR',
              'max:11',
              'exists:users,mobile'
          ]
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'mobile' => $this->getClean($this->get('mobile'))
        ]);
    }
}
