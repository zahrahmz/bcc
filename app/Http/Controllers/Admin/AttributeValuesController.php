<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Attributes\CreateAttributeValuesRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Repositories\Admin\AttributeValueRepository;

class AttributeValuesController extends BaseController
{
    private $attributeValueRepository;

    public function __construct(AttributeValueRepository $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }


    public function create(Attribute $attribute)
    {
        $this->setPageTitle(trans('attributevalues.attribute_value_values'));
        $this->setSideBar('attributes');
        return view('admin.attributevalues.create', compact('attribute'));
    }


    public function store(CreateAttributeValuesRequest $request, Attribute $attribute)
    {
        $data = $request->validated();
        $this->attributeValueRepository->createAttributeValue($attribute, $data);
        return redirect()->route('admin.attributes.edit', $attribute->id)->with(['message' => trans('attributevalues.value_added_successfully')]);
    }

    public function delete(CreateAttributeValuesRequest $request, Attribute $attribute, AttributeValue $value)
    {
        $this->attributeValueRepository->deleteAttributeValue($value);
        return redirect()->route('admin.attributes.edit', $attribute->id)->with(['message' => trans('attributevalues.value_removed_successfully')]);
    }
}
