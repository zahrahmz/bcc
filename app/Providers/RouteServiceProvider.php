<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapSiteWebRoutes();
        $this->mapSiteApiRoutes();

        $this->mapAdminWebRoutes();
        $this->mapAdminApiRoutes();
    }

    /**
     * Define the "site web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapSiteWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/site/web.php'));
    }

    /**
     * Define the "admin web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminWebRoutes()
    {
        Route::middleware('web')
            ->prefix('admin')
            ->namespace($this->namespace)
            ->as('admin.')
            ->group(base_path('routes/admin/web.php'));
    }

    /**
     * Define the "admin web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminApiRoutes()
    {
        Route::middleware('web')
            ->prefix('api/admin')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin/api.php'));
    }

    protected function mapSiteApiRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('api')
            ->group(base_path('routes/site/api.php'));
    }
}
