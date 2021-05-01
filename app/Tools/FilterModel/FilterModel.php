<?php


namespace App\Tools\FilterModel;


use App\Tools\FilterModel\Exceptions\InvalidFilterException;
use App\Tools\FilterModel\Traits\Filterable;
use App\Tools\FilterModel\Traits\Searchable;
use App\Tools\FilterModel\Traits\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FilterModel
{

    /** @var Builder */
    private $builder;
    /** @var Sortable|Filterable|Searchable */
    private $model;
    /** @var \Illuminate\Support\Collection */
    private $queryParams;
    private $classUses;
    /**
     * @var array
     */
    private $searchable;
    /**
     * @var array
     */
    private $sortable;
    /**
     * @var array|null
     */
    private $filterable;


    public function __construct(Builder &$builder, Model $model, array $queryParams, array $searchable = null, array $sortable = null, array $filterable = null)
    {
        $this->builder = $builder;
        $this->model = $model;
        $this->classUses = array_values(class_uses($model));
        $this->queryParams = collect($queryParams);
        $this->searchable = $searchable ?? (in_array(Searchable::class, $this->classUses) ? $this->model->getSearchableFields() : []);
        $this->sortable = $sortable ?? (in_array(Sortable::class, $this->classUses) ? $this->model->getSortableFields() : []);
        $this->filterable = $filterable ?? (in_array(Filterable::class, $this->classUses) ? $this->model->getFilterableFields() : []);
    }

    public function handle()
    {
        try {
            $this->addSort();
            $this->addFilter();
            $this->addSearch();
        }catch (\Exception $e){
            throw new InvalidFilterException();
        }
        return $this->builder;
    }

    private function canUseSort($sort)
    {
        return in_array($sort, $this->sortable);
    }

    private function canUseFilter($field)
    {
        return in_array($field, $this->filterable);
    }

    private function canUseSearch($field)
    {
        return in_array($field, $this->searchable);
    }

    private function addSort()
    {
        if (empty($this->sortable)) {
            return;
        }

        if (!($sort = $this->queryParams->get('sort'))) {
            return;
        }

        $sorts = explode(',', $this->queryParams->get('sort'));
        foreach ($sorts as $sort) {
            $direction = 'asc';
            if (Str::startsWith($sort, '-')) {
                $direction = 'desc';
                $sort = Str::substr($sort, 1);
            }
            if (!$this->canUseSort($sort)) {
                continue;
            }
            $this->builder->orderBy($sort, $direction);
        }
    }

    private function addSearch()
    {

        if (empty($this->searchable)) {
            return;
        }
        if (!$value = $this->queryParams->get('search')) {
            return;
        }


        $this->builder->where(function (Builder $query) use ($value) {
            foreach ($this->searchable as $key) {
                if (Str::startsWith($key, 'relation')) {
                    $key = Str::substr($key, 9);

                    $this->addRelationSearch($key, $value,$query);
                    continue;
                }

                if (in_array($key, $this->searchable)) {
                    if (!$this->canUseSearch($key)) {
                        continue;
                    }

                    $this->addExactSearch($key, $value,$query);
                    continue;
                }
            }
        });
    }


    private function addFilter()
    {
        if (empty($this->filterable)) {
            return;
        }

        foreach ($this->queryParams as $key => $value) {

            if (in_array($key, $this->filterable)) {
                if (!$this->canUseFilter($key)) {
                    continue;
                }
                $this->addExactFilter($key, $value);
                continue;
            }


            if (Str::startsWith($key, 'relation')) {
                $key = Str::substr($key, 9);

                if (!$this->canUseFilter($key)) {
                    continue;
                }

                $this->addRelationFilter($key, $value);
                continue;
            }

            if (Str::startsWith($key, 'exact')) {
                $key = Str::substr($key, 6);
                if (!$this->canUseFilter($key)) {
                    continue;
                }
                $this->addExactFilter($key, $value);
                continue;
            }

            if (Str::startsWith($key, 'contains')) {
                $key = Str::substr($key, 10);
                if (!$this->canUseFilter($key)) {
                    continue;
                }
                $this->addContainFilter($key, $value);
                continue;
            }
        }
    }

    private function getValue($field, $value)
    {
        return $value;
    }

    private function addExactFilter($key, $input)
    {
        $that = $this;
        $this->builder->where(function (Builder $query) use ($input, $key, $that) {
            foreach (explode(',', $input) as $value) {
                $query->orWhere($that->getKey($key), $that->getValue($key, $value));
            }
        });
    }

    private function addRelationFilter($key, $input)
    {
        $that = $this;
        $column = last(explode('.',$that->getKey($key)));
        $relation = Str::replaceLast('.' . $column,'',$that->getKey($key));

        $this->builder->whereHas($that->getKey($relation),function (Builder $query) use ($input, $column, $relation,$that) {
            $query->where(function ($query) use ($input, $column, $relation,$that){
                foreach (explode(',', $input) as $value) {
                    $query->orWhere($that->getKey($column), $that->getValue($column, $value));
                }
            });
        });
    }

    private function addContainFilter($key, $input)
    {
        $that = $this;
        $this->builder->where(function (Builder $query) use ($input, $key, $that) {
            foreach (explode(',', $input) as $value) {
                $query->orWhere($that->getKey($key), 'like', '%' . $that->getValue($key, $value) . '%');
            }
        });
    }


    private function addExactSearch($key, $input,$query)
    {
        $that = $this;
        $query->orWhere(function (Builder $query) use ($input, $key, $that) {
            foreach (explode(',', $input) as $value) {
                $query->Where($that->getKey($key), 'like', '%' . $that->getValue($key, $value) . '%');
            }
        });
    }


    private function addRelationSearch($key, $input,$query)
    {
        $that = $this;
        $column = last(explode('.', $that->getKey($key)));
        $relation = Str::replaceLast('.' . $column, '', $that->getKey($key));


        $query->orWhereHas($that->getKey($relation), function (Builder $query) use ($input, $column, $relation, $that) {
            $query->Where(function ($query) use ($input, $column, $relation, $that) {
                foreach (explode(',', $input) as $value) {
                    $query->orWhere($that->getKey($column), 'like', '%' . $that->getValue($column, $value) . '%');
                }
            });
        });
    }


    private function getKey($key)
    {
        return str_replace("__", ".", $key);
    }


}
