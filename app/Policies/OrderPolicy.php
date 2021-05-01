<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the item.
     *
     * @param \App\Models\Admin $admin
     * @return mixed
     */
    public function view(Admin $admin)
    {
        $permission = Permission::query()->where('name', 'order-view')->first();
        return $admin->hasRole($permission->roles);
    }

    /**
     * Determine whether the user can create items.
     *
     * @param \App\Models\Admin $admin
     * @return mixed
     */
    public function create(admin $admin)
    {
        $permission = Permission::query()->where('name', 'order-create')->first();
        return $admin->hasRole($permission->roles);
    }

    /**
     * Determine whether the user can update the item.
     *
     * @param \App\Models\Admin $admin
     * @return mixed
     */
    public function update(Admin $admin)
    {
        $permission = Permission::query()->where('name', 'order-update')->first();
        return $admin->hasRole($permission->roles);
    }

    /**
     * Determine whether the user can delete the item.
     *
     * @param \App\Models\Admin $admin
     * @return mixed
     */
    public function delete(Admin $admin)
    {
        $permission = Permission::query()->where('name', 'order-delete')->first();
        return $admin->hasRole($permission->roles);
    }
}
