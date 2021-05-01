<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Site\Product\productListRequest;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Slider;
use App\Repositories\Admin\AttributeRepository;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Site\ProductRepository;
use App\Services\Site\ProductService;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Server\DumpServer;
use Symfony\Component\VarDumper\VarDumper;

class ProductController extends BaseController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var AttributeRepository
     */
    private $attributeRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductService $productService,
        AttributeRepository $attributeRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->attributeRepository = $attributeRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(productListRequest $request)
    {
        $data['gender'] = [];
        $data['category'] = [];
        $data['size'] = [];
        $data['brand'] = [];
        $data['page'] = $request->get('page');

        $data = array_merge($data, $request->validated());
        $this->setPageTitle('محصولات');
        $this->setCartContent();

        $products = $this->productRepository->listOfProduct($data);

        if ($request->has('api')) {
            return response()->json([
                'data' => $products,
                'status' => 200
            ]);
        }

        $categories = $this->categoryRepository->getPluckAllCategory();
        $brands = $this->categoryRepository->getPluckAllBrand();
        $attributes = $this->attributeRepository->getListOfAttributesWithValues();

        return view('site.products.index', compact('data', 'products', 'attributes', 'categories', 'brands'));
    }

    public function show(Product $product)
    {
        $this->setPageTitle($product->product_name);
        $this->setCartContent();
        $product = $this->productRepository->show($product);
        $similarProducts = $this->productRepository->getSimilarProductBaseOnCategory($product);
        return view('site.products.show', compact('product', 'similarProducts'));
    }


    /******************************************************************************************************
     *                                           API
     ******************************************************************************************************
     *
     */

    public function getProductPriceByProductAttribute(ProductAttribute $productAttribute)
    {
        $result = $this->productService->getProductPriceByProductAttribute($productAttribute);
        return response()->json(['data' => $result], 200);
    }
}
