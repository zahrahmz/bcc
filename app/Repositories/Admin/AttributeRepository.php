<?php

namespace App\Repositories\Admin;

use App\Models\Attribute;
use App\Exceptions\Attributes\AttributeNotFoundException;
use App\Exceptions\Attributes\CreateAttributeErrorException;
use App\Exceptions\Attributes\UpdateAttributeErrorException;
use App\Models\AttributeValue;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;

class AttributeRepository extends BaseRepository
{
    /**
     * @var Attribute
     */
    protected $model;

    /**
     * AttributeRepository constructor.
     * @param Attribute $attribute
     */
    public function __construct(Attribute $attribute)
    {
        parent::__construct($attribute);
        $this->model = $attribute;
    }

    /**
     * @param array $data
     * @return Attribute
     * @throws CreateAttributeErrorException
     */
    public function createAttribute(array $data) : Attribute
    {
        try {
            $attribute = new Attribute($data);
            $attribute->save();
            return $attribute;
        } catch (QueryException $e) {
            throw new CreateAttributeErrorException($e);
        }
    }


    public function findAttributeById(Attribute $attribute)
    {
        try {
            return $attribute->load('values');
        } catch (ModelNotFoundException $e) {
            throw new AttributeNotFoundException($e);
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws UpdateAttributeErrorException
     */
    public function updateAttribute(array $data, Attribute $attribute) : bool
    {
        try {
            return $attribute->update($data);
        } catch (QueryException $e) {
            throw new UpdateAttributeErrorException($e);
        }
    }

    /**
     * @return bool|null
     */
    public function deleteAttribute() : ?bool
    {
        return $this->model->delete();
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function listAttributes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    /**
     * @return Collection
     */
    public function listAttributeValues() : Collection
    {
        return $this->model->values()->get();
    }


    public function associateAttributeValue(AttributeValue $attributeValue)
    {
        return $this->model->values()->save($attributeValue);
    }

    public function getListOfAttributesWithValues()
    {
        return $this->model->with('values')->get();
    }
}
