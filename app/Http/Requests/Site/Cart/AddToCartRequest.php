<?php

namespace App\Http\Requests\Site\Cart;

use App\Http\Requests\BaseRequest;
use App\Models\ProductAttribute;
use Illuminate\Validation\Rule;

class AddToCartRequest extends BaseRequest
{
    public function postRule()
    {
        $product = $this->route('product');

        return [
            'quantity' => [
                'required',
                'integer',
                $this->customExistence()
            ],
            'product_attribute' => [
                'required',
                Rule::in($product->attributes()->pluck('id'))
            ]
        ];
    }

    private function customExistence()
    {
        return function ($field, $quantity, $fail) {
            $product_attribute_id = $this->get('product_attribute');
            $product_has_stack = ProductAttribute::query()
                    ->where('id', $product_attribute_id)
                    ->where('quantity', '>=', $quantity)
                    ->count();

            if (!$product_has_stack) {
                return $fail(trans('validation.out_of_stuck'));
            }


            return true;
        };
    }
}
