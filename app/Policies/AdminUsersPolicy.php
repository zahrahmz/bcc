<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminUsersPolicy
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
        $permission = Permission::query()->where('name', 'admin-view')->first();
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
        $permission = Permission::query()->where('name', 'admin-create')->first();
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
        $permission = Permission::query()->where('name', 'admin-update')->first();
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
        $permission = Permission::query()->where('name', 'admin-delete')->first();
        return $admin->hasRole($permission->roles);
    }
}
