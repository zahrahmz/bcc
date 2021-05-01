<?php


namespace App\Repositories\Site;

use App\Models\Product;
use App\Models\Slider;
use App\Models\WishList;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class WishListRepository extends BaseRepository
{
    public function __construct(WishList $wishList)
    {
        parent::__construct($wishList);
        $this->model = $wishList;
    }

    public function addToMyWishList(Product $product)
    {
        $this->insertOrIgnore([
            'user_id' => currentUserObj()->id,
            'product_id' => $product->id
        ]);
    }
}
