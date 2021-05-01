<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.logout') }}" class="brand-link">
        <span class="btn btn-danger brand-text font-weight-light">خروج</span>
    </a>
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="@if($sidebarName == 'dashboard') active @endif nav-link">
                            <i class="nav-icon fa fa-list-alt text-danger"></i>
                            <p class="text">{{ trans('dashboard.name') }}</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview @if($sidebarName == 'products' or $sidebarName == 'categories' or $sidebarName == 'attributes' or $sidebarName == 'discounts' ) menu-open @endif">
                        <a href="#" class="nav-link @if($sidebarName == 'products' or $sidebarName == 'categories' or $sidebarName == 'attributes' or $sidebarName == 'discounts') active @endif">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                {{ trans('products.name') }}
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('view', \App\Models\Product::class)
                                <li class="nav-item">
                                    <a href="{{ route('admin.products.index') }}" class="nav-link @if($sidebarName == 'products') active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p> {{ trans('products.name') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('view', \App\Models\Attribute::class)
                                <li class="nav-item">
                                    <a href="{{ route('admin.attributes.index') }}" class="nav-link @if($sidebarName == 'attributes') active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>{{ trans('attributes.name') }}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('view', \App\Models\Category::class)
                                <li class="nav-item">
                                    <a href="{{ route('admin.categories.index') }}" class="@if($sidebarName == 'categories') active @endif nav-link">
                                        <i class="nav-icon fa fa-list-alt text-danger"></i>
                                        <p class="text">{{ trans('categories.name') }}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('view', \App\Models\Discount::class)
                                <li class="nav-item">
                                    <a href="{{ route('admin.discount.index') }}" class="@if($sidebarName == 'discounts') active @endif nav-link">
                                        <i class="nav-icon fa fa-list-alt text-danger"></i>
                                        <p class="text">{{ trans('discount.name') }}</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    @can('view', \App\Models\Order::class)
                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link @if($sidebarName == 'orders') active @endif">
                            <i class="fa fa-circle-o nav-icon"></i>
                            <p>سفارشات</p>
                        </a>
                    </li>
                    @endcan
                    {{-- کاربران--}}
                    @can('view', \App\Models\Admin::class)
                        <li class="nav-item has-treeview @if($sidebarName == 'admin-users') menu-open  @elseif($sidebarName == 'users') menu-open @endif">
                            <a href="#" class="nav-link @if($sidebarName == 'admin-users') active  @elseif($sidebarName == 'users') active @endif">
                                <i class="nav-icon fa fa-dashboard"></i>
                                <p>
                                    کاربران
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <a href="{{ route('admin.admins.index') }}" class="@if($sidebarName == 'admin-users') active @endif nav-link">
                                    <i class="nav-icon fa fa-circle-o text-info"></i>
                                    <p>مدیران</p>
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="@if($sidebarName == 'users') active @endif nav-link">
                                    <i class="nav-icon fa fa-circle-o text-info"></i>
                                    <p>مشتریان</p>
                                </a>
                            </ul>
                        </li>
                    @endcan

                    @can('view', \App\Models\Shipment::class)
                    <li class="nav-item">
                        <a href="{{ route('admin.shipments.index') }}" class="@if($sidebarName == 'shipments') active @endif nav-link">
                            <i class="nav-icon fa fa-list-alt text-danger"></i>
                            <p class="text">{{ trans('shipments.name') }}</p>
                        </a>
                    </li>
                    @endcan

                    @can('view', \App\Models\Slider::class)
                        <li class="nav-item">
                            <a href="{{ route('admin.sliders.index') }}" class="@if($sidebarName == 'sliders') active @endif nav-link">
                                <i class="nav-icon fa fa-list-alt text-danger"></i>
                                <p class="text">اسلایدر</p>
                            </a>
                        </li>
                    @endcan

                    @can('view', \App\Models\Setting::class)
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}" class="@if($sidebarName == 'settings') active @endif nav-link">
                                <i class="nav-icon fa fa-list-alt text-danger"></i>
                                <p class="text">تنظیمات</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </nav>
        </div>
    </div>
</aside>
