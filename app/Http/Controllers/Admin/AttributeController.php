<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;

use App\Http\Requests\Admin\Attributes\CreateAttributeRequest;
use App\Http\Requests\Admin\Attributes\UpdateAttributeRequest;
use App\Models\Attribute;
use App\Repositories\Admin\AttributeRepository;

class AttributeController extends BaseController
{
    private $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function index()
    {
        $this->setPageTitle(trans('attributes.name'));
        $this->setSideBar('attributes');
        $attributes = $this->attributeRepository->listAttributes();
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $this->setPageTitle(trans('attributes.add_attribute'));
        $this->setSideBar('attributes');
        return view('admin.attributes.create');
    }


    public function store(CreateAttributeRequest $request)
    {
        $data = $request->validated();
        $this->attributeRepository->createAttribute($data);
        return redirect()->route('admin.attributes.index')->with('message', trans('attributes.attribute_added_successfully'));
    }

    public function edit(Attribute $attribute)
    {
        $this->setPageTitle(trans('attributes.attribute_edit'));
        $this->setSideBar('attributes');
        $attribute = $this->attributeRepository->findAttributeById($attribute);
        return view('admin.attributes.edit', compact('attribute'));
    }


    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $this->setPageTitle(trans('attributes.name'));
        $this->setSideBar('attributes');
        $data = $request->validated();
        $this->attributeRepository->updateAttribute($data, $attribute);
        return redirect()->route('admin.attributes.index')
            ->with('message', trans('attributes.attribute_updated_successfully'));
    }


    public function delete(Attribute $attribute)
    {
        //TODO::باید چک کنیم ببینیم اگر این ویژگی به محصولی  وصل هست از پاک کردنش جلوگیری کنیم تا ادمین ابتدا  محصول رو از ویژگی جدا کند
        $attribute->delete();
        return redirect()->route('admin.attributes.index')->with('message', trans('attributes.attribute_removed_successfully'));
    }
}
