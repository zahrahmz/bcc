<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Site\Cart\AddToCartRequest;
use App\Http\Requests\Site\Cart\ChangeQuantityRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Site\CartItem;
use App\Repositories\Site\AddressRepository;
use App\Repositories\Site\CartRepository;
use App\Repositories\Site\ShipmentRepository;
use App\Services\Site\CartService;

class CartController extends BaseController
{
    /**
     * @var CartService
     */
    private $cartService;
    /**
     * @var CartRepository
     */
    private $cartRepository;
    /**
     * @var AddressRepository
     */
    private $addressRepository;
    /**
     * @var ShipmentRepository
     */
    private $shipmentRepository;

    public function __construct(
        CartService $cartService,
        CartRepository $cartRepository,
        AddressRepository $addressRepository,
        ShipmentRepository $shipmentRepository
    ) {
        $this->cartService = $cartService;
        $this->cartRepository = $cartRepository;
        $this->addressRepository = $addressRepository;
        $this->shipmentRepository = $shipmentRepository;
    }

    public function addToCart(AddToCartRequest $request, Product $product)
    {
        $data = $request->validated();
        $productAttribute = $data['product_attribute'] ?? null;
        $quantity = $data['quantity'];
        $result = $this->cartService->addToCart($product, $quantity, $productAttribute);

        if (!$result) {
            $this->showErrorPage(400);
        }

        return redirect(route('site.product.show', ['product' => $product->id]));
    }


    public function show()
    {
//        dd(LLCCGPaymentFacade::sale(123));
        $this->setPageTitle('سبد خرید');
        $this->setCartContent();

        $cartData = $this->cartRepository->show();

        $listOfProducts = $cartData['listOfProducts'];
        $totalPriceWithDiscount = $cartData['totalPriceWithDiscount'];
        $totalPriceWithoutDiscount = $cartData['totalPriceWithoutDiscount'];
        $totalDiscount = $cartData['totalDiscount'];
        $cartId = $cartData['cartId'];

        $addresses = $this->addressRepository->getUserAddressList(currentUserObj());
        $shipments = $this->shipmentRepository->list();

        return view('site.cart.show', compact('listOfProducts', 'totalPriceWithDiscount', 'totalPriceWithoutDiscount', 'totalDiscount', 'cartId', 'addresses', 'shipments'));
    }

    public function removeCartItem(Cart $cart, CartItem $cartItem)
    {
        $this->cartRepository->removeCartItem2($cartItem);
        return redirect()->route('site.cart.show');
    }

    /******************************************************************************************************
     *                                           API
     *****************************************************************************************************
     */

    public function changeQuantityOfCartProduct(Cart $cart, CartItem $cartItem, ChangeQuantityRequest $request)
    {
        $cart = $this
            ->cartRepository
            ->changeQuantityOfCartProduct($cart, $cartItem, $request->get('quantity'));
        return response()->json(['cart' => $cart], 200);
    }
}
