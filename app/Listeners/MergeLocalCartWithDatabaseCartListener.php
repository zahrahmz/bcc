<?php

namespace App\Listeners;

use App\Models\Site\CartItem;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MergeLocalCartWithDatabaseCartListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function handle($event)
    {
        try {
            DB::beginTransaction();
            if (cart()->content()->isNotEmpty()) {

                //if user has unfinished cart we return it,and do not create new cart for him
                $existedCartItemInCache = getUserCurrentCart();

                foreach (cart()->content() as $key => $eachItem) {
                    $item = [
                        'product_id' => $eachItem->options['product_id'],
                        'product_attribute_id' => !empty($eachItem->options['productAttribute_id']) ? $eachItem->options['productAttribute_id'] : null,
                        'attribute_value_id' => !empty($eachItem->options['attribute_value_id']) ? $eachItem->options['attribute_value_id'] : null,
                        'quantity' => $eachItem->qty,
                        'cart_id' => $existedCartItemInCache->id
                    ];
                    $existedCartItemInDatabase = CartItem::query()
                        ->where([
                            'product_id' => $item['product_id'],
                            'product_attribute_id' => $item['product_attribute_id'],
                            'attribute_value_id' => $item['attribute_value_id'],
                            'cart_id' => $item['cart_id'],
                        ])->first();


                    if (empty($existedCartItemInDatabase)) {
                        $existedCartItemInCache->cartItems()->create($item);
                        continue;
                    }
                }
                cart()->destroy();
            }

            if (currentUserObj()) {
                Cache::forget('items_count_' . currentUserObj()->id);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
