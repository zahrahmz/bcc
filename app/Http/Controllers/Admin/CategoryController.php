<?php
/**
 * Created by PhpStorm.
 * User: alireza
 * Date: 10/17/20
 * Time: 1:19 PM
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Categories\CreateCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Http\Requests\Admin\Categories\UploadImagesRequest;
use App\Models\Category;
use App\Models\Image;
use App\Repositories\Admin\CategoryRepository;

/**
 * @property CategoryRepository $categoryRepository
 */
class CategoryController extends BaseController
{
    /**
     * CategoryController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle(trans('categories.name'));
        $this->setSideBar('categories');
        $categories = $this->categoryRepository->list(true);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle(trans('categories.create_category'));
        $this->setSideBar('categories');
        $categories = $this->categoryRepository->allWith(Category::MENU,Category::ACTIVE);
        return view('admin.categories.create', compact('categories'));
    }


    public function store(CreateCategoryRequest $request)
    {
        $category =$this->categoryRepository->createCategory($request->all());
        if ($category === 0) {
            return redirect()->route('admin.categories.create')->with('message', ' حداکثر تعداد منو/دسته بندی اصلی ۵ عدد می باشد');
        }
        return redirect()->route('admin.categories.edit', $category->id)->with('message', trans('categories.category_created_successfully'));
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        $this->setPageTitle(trans('categories.edit_category'));
        $this->setSideBar('categories');
        $categories = $this->categoryRepository->allWith(Category::MENU,Category::ACTIVE);
        $category = $this->categoryRepository->findCategoryById($category->id);

        return view('admin.categories.edit', compact('category', 'categories'));
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->setPageTitle(trans('categories.name'));
        $this->setSideBar('categories');
        $this->categoryRepository->updateCategory($request->all(), $category);
        return redirect()->route('admin.categories.index')
            ->with('message', trans('categories.category_updated_successfully'));
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addPhoto(Category $category)
    {
        $this->setPageTitle('افزودن عکس');
        $this->setSideBar('افزودن عکس');
        return view('admin.categories.add_photo', compact('category'));
    }


    public function uploadImages(UploadImagesRequest $request, Category $category)
    {
        $file = $request->validated();
        $this->categoryRepository->saveImages(collect($file),$category);
        return redirect()->route('admin.categories.edit', $category->id)
            ->with('message', trans('categories.categories_image_uploaded_successfully'))
            ->with(['tab' => 'categories_images']);
    }


    public function deleteImage(Category $category,Image $image)
    {
        $this->categoryRepository->deleteImage($image);
    }

    public function delete(Category $category)
    {
        $this->categoryRepository->delete($category);
        return redirect()->route('admin.categories.index', $category->id)->with('message', trans('categories.category_removed_successfully'));
    }
}
