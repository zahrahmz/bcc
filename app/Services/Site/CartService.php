<?php


namespace App\Services\Site;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function addToCart(Product $product, int $quantity, $productAttribute)
    {
        $attributes = [];
        $product = $product->load(['images','attributes.attributesValues','attributes'=> function ($query) use ($productAttribute) {
            $query->where('id', $productAttribute);
        }]);

        if (!Auth::check()) {
            $this->addToCartWhenUserNotLogin($product, $attributes, $quantity);
        } else {
            $this->addToCartWhenUserWasLogin($product, $quantity);
        }
        return true;
    }

    /**
     * @param Product $product
     * @return mixed|string
     */
    private function generateUniqueId(Product $product)
    {
        $uniqueId = $product->id;
        if ($product->attributes->isNotEmpty()) {
            $uniqueId .= $product->attributes->first()->id;
        }
        return $uniqueId;
    }

    /**
     * @param Product $product
     * @param array $attributes
     * @param int $quantity
     */
    public function addToCartWhenUserNotLogin(Product $product, array $attributes, int $quantity): void
    {
        $uniqueId = $this->generateUniqueId($product);
        $name = $product->product_name;
        $price = $product->product_price_discount;
        $attributes['product_id'] = $product->id;
        $attributes['image'] = $product->images()->first()->path;


        if ($product->attributes->isNotEmpty()) {
            $attribute = $product->attributes->first();
            $attributes['productAttribute_id'] = $attribute->id;
            $attributes['attribute_value_id'] = $product->attributes->first()->attributesValues->first()->id;
            $price = $product->product_price_discount;
        }

        cart()->add($uniqueId, $name, $quantity, $price, 0, $attributes);
    }

    /**
     * @param Product $product
     * @param int $quantity
     */
    public function addToCartWhenUserWasLogin(Product $product, int $quantity): void
    {
        try {
            DB::beginTransaction();
            $attribute = $product->attributes->first();

            //if user has unfinished cart we return it,and do not create new cart for him
            $cart = getUserCurrentCart();

            $cart->cartItems()->updateOrCreate(
                [
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'product_attribute_id' => $attribute->id,
                    'attribute_value_id' => $attribute->attributesValues()->first()->id,
                ],
                [
                    'quantity' => DB::raw("quantity + $quantity")
                ]
            );
            Cache::forget('items_count_' . currentUserObj()->id);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
