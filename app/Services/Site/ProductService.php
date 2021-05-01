<?php


namespace App\Services\Site;

use App\Models\ProductAttribute;

class ProductService
{
    public function getProductPriceByProductAttribute(ProductAttribute $productAttribute)
    {
        $result = $productAttribute->load(['product']);

        if ($result->product['product_discount'] > 0) {
            $priceWithDiscount =  ($result->price * (100 - $result->product['product_discount'])) / 100;
        } else {
            $priceWithDiscount = $result->price;
        }

        return [
            'product_id' => $result->product_id,
            'product_attribute_id' => $result->id,
            'product_attribute_quantity' => $result->quantity,
            'product_discount' => $result->product['product_discount'],
            'price_with_discount' => $priceWithDiscount,
            'price' => $result->price
        ];
    }
}
