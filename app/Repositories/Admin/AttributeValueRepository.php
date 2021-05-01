<?php

namespace App\Repositories\Admin;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AttributeValueRepository extends BaseRepository
{
    /**
     * AttributeValueRepository constructor.
     * @param AttributeValue $attributeValue
     */
    public function __construct(AttributeValue $attributeValue)
    {
        parent::__construct($attributeValue);
        $this->model = $attributeValue;
    }
    /**
     * @param Attribute $attribute
     * @param array $data
     * @return AttributeValue
     */
    public function createAttributeValue(Attribute $attribute, array $data) : AttributeValue
    {
        $attributeValue = new AttributeValue($data);
        $attributeValue->attribute()->associate($attribute);
        $attributeValue->save();
        return $attributeValue;
    }

//    /**
//     * Create the attribute value and associate to the attribute
//     *
//     * @param Attribute $attribute
//     * @return AttributeValue
//     */
//    public function associateToAttribute(Attribute $attribute) : AttributeValue
//    {
//        $this->model->attribute()->associate($attribute);
//        $this->model->save();
//        return $this->model;
//    }

    /**
     * Remove association from the attribute
     */
    public function deleteAttributeValue(AttributeValue $attributeValue)
    {
        return $attributeValue->delete();
    }

    /**
     * @return Collection
     */
    public function findProductAttributes() : Collection
    {
        return $this->model->productAttributes()->get();
    }
}
