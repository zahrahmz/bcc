<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Discounts\CreateDiscountRequest;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Repositories\Admin\DiscountRepository;

/**
 * @property DiscountRepository repository
 */
class DiscountController extends BaseController
{
    /**
     * @var DiscountRepository
     */
    private $discountRepository;

    /**
     * DiscountController constructor.
     * @param DiscountRepository $repository
     */
    public function __construct(DiscountRepository $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle(trans('discount.name'));
        $this->setSideBar('discounts');
        $discounts = $this->discountRepository->list(true);
        return view('admin.discount.index', compact('discounts'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle(trans('discount.create_discount'));
        $this->setSideBar('discounts');
        $discounts = $this->discountRepository->all();
        $products = Product::query()->where('status', Product::ACTIVE)->get();
        $categories = Category::query()->where(['status'=>Category::ACTIVE,'type'=>Category::BRAND])->get();

        return view('admin.discount.create', compact('discounts', 'products', 'categories'));
    }

    public function store(CreateDiscountRequest $request)
    {
        $this->discountRepository->createDiscount($request->validated());
        return redirect()->route('admin.discount.index')->with('message', trans('discount.discount_updated_successfully'));
    }


    public function delete(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('admin.discount.index', $discount->id)->with('message', trans('discount.discount_removed_successfully'));
    }
}
