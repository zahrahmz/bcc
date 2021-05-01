<?php


namespace App\Repositories\Site;

use App\Models\Cart;
use App\Models\Site\CartItem;
use App\Repositories\BaseRepository;
use App\Services\Site\ProductService;
use Illuminate\Support\Facades\Cache;

/**
 * @method array|mixed show_withAuthCache()
 **/
class CartRepository extends BaseRepository
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(Cart $cart, ProductService $productService)
    {
        parent::__construct($cart);
        $this->model = $cart;
        $this->productService = $productService;
    }


    /**
     * Get details of products in cart
     */
    public function show()
    {
        $cart = Cart::query()->where([
            'user_id' => currentUserObj()->id,
            'status' => Cart::ACTIVE
        ])->first();

        $listOfProducts = [];
        $cartId = 0;
        $totalPriceWithDiscount = 0;
        $totalPriceWithoutDiscount = 0;

        if ($cart) {
            $cartItems = $cart->cartItems()->with([
                'productAttribute',
                'product'
            ])->get();
            foreach ($cartItems as $eachItem) {
                $cartId = $eachItem->cart_id;
                $listOfProducts[$eachItem->id]['cartItemId'] = $eachItem->id;
                $listOfProducts[$eachItem->id]['product_attribute_id'] = $eachItem->productAttribute->id;
                $listOfProducts[$eachItem->id]['product_name'] = $eachItem->product->product_name;
                $listOfProducts[$eachItem->id]['product_id'] = $eachItem->product->id;
                $listOfProducts[$eachItem->id]['product_size'] = $eachItem->productAttribute->size;
                $listOfProducts[$eachItem->id]['product_price'] = $eachItem->productAttribute->price;
                $listOfProducts[$eachItem->id]['product_price_discount'] = $this->productService->getProductPriceByProductAttribute($eachItem->productAttribute)['price_with_discount'];
                $listOfProducts[$eachItem->id]['image'] = $eachItem->product->image;
                $listOfProducts[$eachItem->id]['quantity'] = $eachItem->quantity;
                $listOfProducts[$eachItem->id]['has_enough_entity'] = !$eachItem->has_enough_entity_in_stock;
                $listOfProducts[$eachItem->id]['zero_entity'] = $eachItem->zero_entity_in_stock;
                $totalPriceWithDiscount += $listOfProducts[$eachItem->id]['product_price_discount'];
                $totalPriceWithoutDiscount += $listOfProducts[$eachItem->id]['product_price'];
            }
        }

        return [
            'listOfProducts' => $listOfProducts,
            'totalPriceWithDiscount' => $totalPriceWithDiscount,
            'totalPriceWithoutDiscount' => $totalPriceWithoutDiscount,
            'totalDiscount' => $totalPriceWithoutDiscount - $totalPriceWithDiscount,
            'cartId' => $cartId,
        ];
    }

    public function changeCartStatus($status)
    {
        $cart = getUserCurrentCart();
        $cart->status = $status;
        if ($cart->save()) {
            //remove count of product cache in cart
            Cache::forget('items_count_' . currentUserObj()->id);
        }
    }

    public function changeQuantityOfCartProduct(Cart $cart, CartItem $cartItem, $quantity)
    {
        $this->model->newQuery()->where('status', Cart::ACTIVE)
            ->findOrFail($cart->id)
            ->cartItems()
            ->where('id', $cartItem->id)
            ->increment('quantity', $quantity);
        Cache::forget('items_count_' . currentUserObj()->id);
        $cartItemData = $this->model->newQuery()
            ->findOrFail($cart->id)
            ->cartItems()
            ->where('id', $cartItem->id)
            ->with(['productAttribute:id,quantity'])
            ->get([
                'cart_id',
                'quantity',
                'product_attribute_id',
            ]);

        return collect([
            '1' => 1
        ]);
    }

    public function removeCartItem2(CartItem $cartItem): void
    {
        $cartItem->delete();
        Cache::forget('items_count_' . currentUserObj()->id);
    }
}
