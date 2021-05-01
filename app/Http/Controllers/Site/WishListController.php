<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Repositories\Site\WishListRepository;

class WishListController extends BaseController
{

    /**
     * @var WishListRepository
     */
    private $wishListRepository;

    public function __construct(WishListRepository $wishListRepository)
    {
        $this->wishListRepository = $wishListRepository;
    }

    public function store(Product $product)
    {
        $this->wishListRepository->addToMyWishList($product);
        return redirect(route('site.product.show', ['product' => $product->id]));
    }
}
