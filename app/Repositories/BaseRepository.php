<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use App\Models\Eloquent\BaseModel;
use App\Traits\UploadableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;


class BaseRepository implements BaseContract
{
    use UploadableTrait;

    /**
     * @var Model|Builder
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function insertOrIgnore(array $attribute)
    {
        $this->model->insertOrIgnore($attribute);
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return bool
     */
    public function update(array $attributes, int $id): bool
    {
        return $this->find($id)->update($attributes);
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model->orderBy($orderBy, $sortBy)->get($columns);
    }

    public function paginate($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc', $searchPhrase = null)
    {
        if ($searchPhrase) {
            return $this->model->search($searchPhrase)->orderBy($orderBy, $sortBy)->paginate(config('custom_config.pagination.per_page'), $columns);
        } else {
            return $this->model->orderBy($orderBy, $sortBy)->paginate(config('custom_config.pagination.per_page'), $columns);
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findBy(array $data)
    {
        return $this->model->where($data)->all();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneByOrFail(array $data)
    {
        return $this->model->where($data)->firstOrFail();
    }


    public function delete(BaseModel $model)
    {
        try {
            $this->deleteImage($model);
            $model->delete();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function groupBy($column)
    {
        $this->model->groupBy($column);
        return $this;
    }
}
