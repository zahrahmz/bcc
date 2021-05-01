<?php

namespace App\Http\Requests\Site\Product;

use App\Http\Requests\BaseRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Rule;

class productListRequest extends BaseRequest
{
    public function getRule()
    {
        return [
            'category' => ['filled',Rule::in(Category::query()->where('type', Category::CATEGORY)->pluck('id')->toArray())],
            'gender' => ['filled'],
            'gender.*' => ['filled',Rule::in(array_keys(Product::GENDER))],
            'size' => ['filled'],
            'size.*' => ['filled'],
            'brand' => ['filled'],
            'brand.*' => ['filled',Rule::in(Category::query()->where('type', Category::BRAND)->pluck('id')->toArray())]
        ];
    }
}
