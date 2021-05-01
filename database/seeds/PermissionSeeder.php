<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::query()->insert([
            [
                'name' => 'product-view',
                'label' => 'نمایش محصول',
                'description' => 'نمایش محصول',
            ],
            [
                'name' => 'product-create',
                'label' => 'ایجاد محصول',
                'description' => 'ایجاد محصول',
            ],
            [
                'name' => 'product-update',
                'label' => 'اصلاح محصول',
                'description' => 'اصلاح محصول',
            ],
            [
                'name' => 'product-delete',
                'label' => 'حذف محصول',
                'description' => 'حذف محصول',
            ],
            [
                'name' => 'attribute-view',
                'label' => 'نمایش ویژگی',
                'description' => 'نمایش ویژگی',
            ],
            [
                'name' => 'attribute-create',
                'label' => 'ایجاد ویژگی',
                'description' => 'ایجاد ویژگی',
            ],
            [
                'name' => 'attribute-update',
                'label' => 'اصلاح ویژگی',
                'description' => 'اصلاح ویژگی',
            ],
            [
                'name' => 'attribute-delete',
                'label' => 'حذف ویژگی',
                'description' => 'حذف ویژگی',
            ],
            [
                'name' => 'admin-view',
                'label' => 'نمایش کاربر مدیر',
                'description' => 'نمایش کاربر مدیر',
            ],
            [
                'name' => 'admin-create',
                'label' => 'ایجاد کاربر مدیر',
                'description' => 'ایجاد کاربر مدیر',
            ],
            [
                'name' => 'admin-update',
                'label' => 'اصلاح کاربر مدیر',
                'description' => 'اصلاح کاربر مدیر',
            ],
            [
                'name' => 'admin-delete',
                'label' => 'حذف کاربر مدیر',
                'description' => 'حذف کاربر مدیر',
            ],
            [
                'name' => 'category-view',
                'label' => 'نمایش دسته بندی',
                'description' => 'نمایش دسته بندی',
            ],
            [
                'name' => 'category-create',
                'label' => 'ایجاد دسته بندی',
                'description' => 'ایجاد دسته بندی',
            ],
            [
                'name' => 'category-update',
                'label' => 'اصلاح دسته بندی',
                'description' => 'اصلاح دسته بندی',
            ],
            [
                'name' => 'category-delete',
                'label' => 'حذف دسته بندی',
                'description' => 'حذف دسته بندی',
            ],
            [
                'name' => 'setting-view',
                'label' => 'نمایش تنظیمات',
                'description' => 'نمایش تنظیمات',
            ],
            [
                'name' => 'setting-create',
                'label' => 'ایجاد تنظیمات',
                'description' => 'ایجاد تنظیمات',
            ],
            [
                'name' => 'setting-update',
                'label' => 'اصلاح تنظیمات',
                'description' => 'اصلاح تنظیمات',
            ],
            [
                'name' => 'setting-delete',
                'label' => 'حذف تنظیمات',
                'description' => 'حذف تنظیمات',
            ],
            [
                'name' => 'shipment-view',
                'label' => 'نمایش ارسال',
                'description' => 'نمایش ارسال',
            ],
            [
                'name' => 'shipment-create',
                'label' => 'ایجاد ارسال',
                'description' => 'ایجاد ارسال',
            ],
            [
                'name' => 'shipment-update',
                'label' => 'اصلاح ارسال',
                'description' => 'اصلاح ارسال',
            ],
            [
                'name' => 'shipment-delete',
                'label' => 'حذف ارسال',
                'description' => 'حذف ارسال',
            ],
            [
                'name' => 'slider-view',
                'label' => 'نمایش اسلایدر',
                'description' => 'نمایش اسلایدر',
            ],
            [
                'name' => 'slider-create',
                'label' => 'ایجاد اسلایدر',
                'description' => 'ایجاد اسلایدر',
            ],
            [
                'name' => 'slider-update',
                'label' => 'اصلاح اسلایدر',
                'description' => 'اصلاح اسلایدر',
            ],
            [
                'name' => 'slider-delete',
                'label' => 'حذف اسلایدر',
                'description' => 'حذف اسلایدر',
            ],
            [
                'name' => 'user-view',
                'label' => 'نمایش کاربر',
                'description' => 'نمایش کاربر',
            ],
            [
                'name' => 'user-create',
                'label' => 'ایجاد کاربر',
                'description' => 'ایجاد کاربر',
            ],
            [
                'name' => 'user-update',
                'label' => 'اصلاح کاربر',
                'description' => 'اصلاح کاربر',
            ],
            [
                'name' => 'user-delete',
                'label' => 'حذف کاربر',
                'description' => 'حذف کاربر',
            ],
            [
                'name' => 'discount-view',
                'label' => 'نمایش تخفیف',
                'description' => 'نمایش تخفیف',
            ],
            [
                'name' => 'discount-create',
                'label' => 'ایجاد تخفیف',
                'description' => 'ایجاد تخفیف',
            ],
            [
                'name' => 'discount-update',
                'label' => 'اصلاح تخفیف',
                'description' => 'اصلاح تخفیف',
            ],
            [
                'name' => 'discount-delete',
                'label' => 'حذف تخفیف',
                'description' => 'حذف تخفیف',
            ],

            [
                'name' => 'order-view',
                'label' => 'نمایش سفارش',
                'description' => 'نمایش سفارش',
            ],
            [
                'name' => 'order-create',
                'label' => 'ایجاد سفارش',
                'description' => 'ایجاد سفارش',
            ],
            [
                'name' => 'order-update',
                'label' => 'اصلاح سفارش',
                'description' => 'اصلاح سفارش',
            ],
            [
                'name' => 'order-delete',
                'label' => 'حذف سفارش',
                'description' => 'حذف سفارش',
            ],
        ]);
    }
}
