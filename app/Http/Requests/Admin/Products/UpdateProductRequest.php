<?php

namespace App\Http\Requests\Admin\Products;

use App\Http\Requests\BaseRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends BaseRequest
{
    public function patchRule()
    {
        $product = $this->route('product');
        return [
            'product_name' => ['required'],
            'sku' => ['required','unique:products,sku,' . ($this->route('product'))->id],
            'slug' => ['required'],
            'gender' => ['required',Rule::in(array_keys(Product::GENDER))],
            'description' => [''],
            'price' => [Rule::requiredIf($product->attributes()->count() < 0),'integer'],
            'status' => ['required',Rule::in([0,1])],
            'categories' => ['required'],
            'categories.*' => ['required',Rule::in(Category::all()->pluck('id')->toArray())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'product_name' => $this->getClean($this->get('product_name')),
            'sku' => $this->getClean($this->get('sku')),
            'slug' => $this->getClean($this->get('slug')),
            'mobile' => $this->getClean($this->get('mobile')),
            'price' => $this->getClean($this->get('price')),
        ]);
    }
}
