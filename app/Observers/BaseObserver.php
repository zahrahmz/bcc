<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BaseObserver
{
    public function created(Model $model)
    {
//        dd(Cache::tags(get_class($model))->getStore());
        $this->removeCaches($model);
    }

    public function updated(Model $model)
    {
        $this->removeCaches($model);
    }

    public function saved(Model $model)
    {
        $this->removeCaches($model);
    }


    public function deleted(Model $model)
    {
        $this->removeCaches($model);
    }


    private function removeCaches(Model $model): void
    {
//        Cache::tags($model::CACHE_TAG)->flush();
    }
}
