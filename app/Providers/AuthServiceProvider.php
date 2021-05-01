<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Shipment;
use App\Models\Site\User;
use App\Models\Slider;
use App\Policies\AdminUsersPolicy;
use App\Policies\AttributesPolicy;
use App\Policies\CategoriesPolicy;
use App\Policies\DiscountPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ProductsPolicy;
use App\Policies\SettingsPolicy;
use App\Policies\ShipmentsPolicy;
use App\Policies\SliderPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Product::class => ProductsPolicy::class,
        Attribute::class => AttributesPolicy::class,
        Admin::class => AdminUsersPolicy::class,
        Category::class => CategoriesPolicy::class,
        Setting::class => SettingsPolicy::class,
        Shipment::class => ShipmentsPolicy::class,
        Slider::class => SliderPolicy::class,
        User::class => UserPolicy::class,
        Discount::class => DiscountPolicy::class,
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
