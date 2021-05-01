<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
                return $this->getRule();
            case 'POST':
                return $this->postRule();
            case 'PUT':
                return $this->putRule();
            case 'PATCH':
                return $this->patchRule();
            case 'DELETE':
                return $this->deleteRule();
            default:
                return $this->default();
        }
    }

    public function getClean($phrase)
    {
        return convertArabicCharacters(convertArabicNumbers($phrase));
    }

    public function getRule()
    {
        return [];
    }

    public function postRule()
    {
        return [];
    }

    public function putRule()
    {
        return [];
    }

    public function patchRule()
    {
        return [];
    }

    public function deleteRule()
    {
        return [];
    }

    public function default()
    {
        return [];
    }
}
