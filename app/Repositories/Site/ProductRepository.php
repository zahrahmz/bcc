<?php


namespace App\Repositories\Site;

use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
        $this->model = $product;
    }

    public function show(Product $product)
    {
        return $this->model->newQuery()
            ->with(['attributes.attributesValues', 'categories', 'discount'])
            ->whereHas('categories')
            ->whereHas('attributes.attributesValues')
            ->findOrFail($product->id);
    }

    public function getSimilarProductBaseOnCategory($product)
    {
        $productCategories = $product->categories->pluck('id');

        $similarProducts = $product
            ->whereHas('categories', function ($query) use ($productCategories) {
                $query->whereIn('categories.id', $productCategories);
            })->with('images', 'discount')->limit(10)->get();

        return $similarProducts;
    }

    public function listOfProduct(array $filters)
    {
        $products = $this->model->newQuery()->limit(50);
        $products->with(['attributes']);
        $products->with(['image']);

        if (!empty($filters['category']) || !empty($filters['brand'])) {
            $products->whereHas('categories', function ($query) use ($filters) {
                if (!empty($filters['category'])) {
                    $query->where('categories.id', $filters['category']);
                }

                if (!empty($filters['brand'])) {
                    $query->WhereIn('categories.id', $filters['brand']);
                }
            });
        }
        if (!empty($filters['size'])) {
            $products->whereHas('attributes', function ($query) use ($filters) {
                $query->where('quantity', '>', 1);
                $query->whereHas('attributesValues', function ($query) use ($filters) {
                    $query->whereIn('id', $filters['size']);
                });
            });
        }

        if (!empty($filters['gender'])) {
            $products->whereIn('gender', $filters['gender']);
        }

        $products = $products->get()->sortByDesc(function ($products) {
            return $products->attributes->sum('quantity');
        });


        return $products->paginate(15,$products->count(),$filters['page'] ?? 1);



        //order by somethings

//
//        $products = Product::query();
//        $products = $products->select(['*',DB::raw('sum(product_attributes.quantity) as all_quantity')]);
//        $products = $products->join('product_attributes','product_attributes.product_id','=','products.id');
//        $products = $products->groupBy('product_id');
//        $products->with(['images','discount']);
//        $products->whereHas('categories', function ($query) use ($data) {
//            //for filtering category
//            if ($data['category']) {
//                $query->where('categories.id', $data['category']);
//            }
//
//            if ($data['brand']) {
//                $query->WhereIn('categories.id', $data['brand']);
//            }
//        });
//        $products->whereHas('attributes.attributesValues', function ($query) use ($data) {
//            //for filtering size
//            if ($data['size']) {
//                $query->whereIn('id', $data['size']);
//            }
//        });
//
//        if ($data['gender']) {
//            $products->whereIn('gender', $data['gender']);
//        }
//
//
//        $products = $products->orderBy('products.id','DESC');
//dd($products->get()->toArray());
//        return $products->forPage($data['page'] ?? 1 ,15);
    }


    public function featuredProducts()
    {
        return $this->model->newQuery()
            ->where('status', Product::ACTIVE)
            ->where('featured', Product::ACTIVE)
            ->with(['attributes'])
            ->whereHas('attributes', function (Builder $query) {
                $query->where('quantity', '>', 0);
            })
            ->limit(12)->get();
    }
}
