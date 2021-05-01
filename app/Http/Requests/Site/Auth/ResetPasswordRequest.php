<?php

namespace App\Http\Requests\Site\Auth;

use App\Http\Requests\BaseRequest;

class ResetPasswordRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}
