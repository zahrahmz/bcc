<?php

namespace App\Http\Requests\Admin\AdminUsers;

use App\Http\Requests\BaseRequest;
use App\Models\Role;
use Illuminate\Validation\Rule;

class CreateAdminUserRequest extends BaseRequest
{
    public function postRule()
    {
        return [
            'name' => ['required'],
            'password' => ['required','min:8'],
            'mobile' => ['required','phone:IR','unique:admins,mobile'],
            'role' => ['required',Rule::in(Role::all()->pluck('id'))],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => $this->getClean($this->get('name')),
            'password' => $this->getClean($this->get('password')),
            'mobile' => $this->getClean($this->get('mobile')),
        ]);
    }
}
