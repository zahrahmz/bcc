<?php

namespace App\Providers;

use App\Models\Eloquent\BaseBuilder;
use App\Tools\FilterModel\FilterModel;

use Illuminate\Support\ServiceProvider;

class queryFilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        BaseBuilder::macro('magicQuery', function (array $queryParams, array $searchable = null, array $sortable = null, array $filterable = null) {
            return (new FilterModel($this, $this->model, $queryParams, $searchable, $sortable, $filterable))->handle();
        });
    }
}
