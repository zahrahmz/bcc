<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Site\ProductRepository;
use App\Repositories\Site\SliderRepository;

class HomeController extends BaseController
{
    /**
     * @var SliderRepository
     */
    private $sliderRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        SliderRepository $sliderRepository,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository
    ) {
        $this->sliderRepository = $sliderRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $this->setPageTitle('فروشگاه اینترنتی بی سی سی');
        $this->setCartContent();
        $featuredProducts= $this->productRepository->featuredProducts();
        $brands = $this->categoryRepository->allWith(Category::BRAND, Category::ACTIVE);
        $sliders =  $this->sliderRepository->getSliders();
        return view('home', compact('sliders', 'featuredProducts', 'brands'));
    }
}
