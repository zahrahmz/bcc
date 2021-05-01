<?php

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::query()->create([
           'name' => 'admin',
           'label' => 'ادمین',
           'description' => 'ادمین',
        ]);

        $role->permissions()->attach(
            Permission::query()->get()->pluck('id')
        );

        $role->admins()->attach(
            Admin::query()->get()->pluck('id')->toArray()
        );
    }
}
