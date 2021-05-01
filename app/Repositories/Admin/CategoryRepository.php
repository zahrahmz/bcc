<?php

namespace App\Repositories\Admin;

use App\Exceptions\Categories\CategoryCreateErrorException;
use App\Exceptions\Categories\CategoryNotFoundException;
use App\Exceptions\Categories\CategoryUpdateErrorException;
use App\Models\Category;
use App\Models\Image;
use App\Repositories\BaseRepository;
use App\Traits\UploadableTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class CategoryRepository extends BaseRepository
{

    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
        $this->model = $category;
    }

    /**
     * List all the
     *
     * @param bool $paginate
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function list($paginate = false, string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        if ($paginate) {
            $data = $this->paginate($columns, $order, $sort);
        } else {
            $data = $this->all($columns, $order, $sort);
        }

        return $data;
    }


    public function allWith($type, $status)
    {
        return Category::query()->where('type', $type)->where('status', $status)->get();
    }

    public function createCategory(array $data)
    {
        if (!$data['slug']) {
            $data['slug'] = str_replace(' ', '-', $data['name']);
        }

        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CategoryCreateErrorException($e);
        }
    }

    /**
     * Update the category
     *
     * @param array $data
     *
     * @param Category $category
     * @return bool
     * @throws CategoryUpdateErrorException
     */
    public function updateCategory(array $data, Category $category): bool
    {
        if (!$data['slug']) {
            $data['slug'] = str_replace(' ', '-', $data['name']);
        }


        try {
            return $category->update($data);
        } catch (QueryException $e) {
            throw new CategoryUpdateErrorException($e);
        }
    }


    public function findCategoryById(int $id)
    {
        try {
            $category = $this->model->with('image')->findOrFail($id);
            return $category;
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e);
        }
    }

    /**
     * Get the category via slug
     *
     * @param array $slug
     *
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function findCategoryBySlug(array $slug): Category
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e);
        }
    }

    /**
     * @return mixed
     */
    public function findCategoryImage(): Collection
    {
        return $this->model->image()->get();
    }

    public function getPluckAllCategory()
    {
        return $this->model->newQuery()->where('type', Category::CATEGORY)->pluck('name', 'id');
    }

    public function getPluckAllBrand()
    {
        return $this->model->newQuery()->where('type', Category::BRAND)->pluck('name', 'id');
    }
}
