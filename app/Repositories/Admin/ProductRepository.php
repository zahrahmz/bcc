<?php

namespace App\Repositories\Admin;

use App\Models\AttributeValue;
use App\Exceptions\Products\ProductCreateErrorException;
use App\Exceptions\Products\ProductUpdateErrorException;
use App\Models\ProductAttribute;
use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
        $this->model = $product;
    }

    public function listProducts($paginate = false, $searchPhrase = null, string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        if ($paginate) {
            $data = $this->paginate($columns, $order, $sort, $searchPhrase);
        } else {
            $data = $this->all($columns, $order, $sort);
        }

        return $data;
    }

    public function createProduct(array $data): Product
    {
        try {
            DB::beginTransaction();
            $product = $this->create($data);
            $product->categories()->attach($data['categories']);
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            throw new ProductCreateErrorException($e);
        }
        return $product;
    }

    public function updateProduct(array $data, Product $product): bool
    {
        $filtered = collect($data)->all();

        try {
            DB::beginTransaction();
            $product->categories()->sync($data['categories']);
            $product = $product->update($filtered);
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            throw new ProductUpdateErrorException($e);
        }
        return $product;
    }

    public function detachCategories()
    {
        $this->model->categories()->detach();
    }

    public function getCategories(): Collection
    {
        return $this->model->categories()->get();
    }

    public function syncCategories(array $params)
    {
        $this->model->categories()->sync($params);
    }

    /**
     * Associate the product attribute to the product
     *
     * @param ProductAttribute $productAttribute
     * @return ProductAttribute
     */
    public function saveProductAttributes(ProductAttribute $productAttribute): ProductAttribute
    {
        $this->model->attributes()->save($productAttribute);
        return $productAttribute;
    }

    /**
     * List all the product attributes associated with the product
     *
     * @return Collection
     */
    public function listProductAttributes(): Collection
    {
        return $this->model->attributes()->get();
    }

    /**
     * Delete the attribute from the product
     *
     * @param ProductAttribute $productAttribute
     *
     * @return bool|null
     * @throws \Exception
     */
    public function removeProductAttribute(ProductAttribute $productAttribute): ?bool
    {
        return $productAttribute->delete();
    }

    /**
     * @param ProductAttribute $productAttribute
     * @param AttributeValue ...$attributeValues
     *
     * @return Collection
     */
    public function saveCombination(ProductAttribute $productAttribute, AttributeValue ...$attributeValues): Collection
    {
        return collect($attributeValues)->each(function (AttributeValue $value) use ($productAttribute) {
            return $productAttribute->attributesValues()->save($value);
        });
    }

    /**
     * @return Collection
     */
    public function listCombinations(): Collection
    {
        return $this->model->attributes()->map(function (ProductAttribute $productAttribute) {
            return $productAttribute->attributesValues;
        });
    }

    /**
     * @param ProductAttribute $productAttribute
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findProductCombination(ProductAttribute $productAttribute)
    {
        $values = $productAttribute->attributesValues()->get();

        return $values->map(function (AttributeValue $attributeValue) {
            return $attributeValue;
        })->keyBy(function (AttributeValue $item) {
            return strtolower($item->attribute->name);
        })->transform(function (AttributeValue $value) {
            return $value->value;
        });
    }

    public function AssignAttributes(Product $product, $params)
    {
        try {
            DB::beginTransaction();

            $productAttribute = new ProductAttribute([
                'quantity' => $params['quantity'],
                'price' => $params['price'],
            ]);

            $createdProductAttribute = $product->attributes()->save($productAttribute);
            $createdProductAttribute->attributesValues()->sync($params['attribute_value_id']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ProductCreateErrorException($e);
        }
    }
}
