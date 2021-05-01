<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;
use App\Models\Site\User;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $label
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin[] $admins
 * @property-read int|null $admins_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \App\Models\Eloquent\BaseBuilder|Role newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Role newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Role query()
 * @method static \App\Models\Eloquent\BaseBuilder|Role whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Role whereDescription($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Role whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Role whereLabel($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Role whereName($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends BaseModel
{
    protected $guarded = ['id'];
    protected $fillable = ['name', 'label', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }

    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param Permission $permission
     * @return boolean
     */
    public function hasPermission(Permission $permission, Admin $admin)
    {
        return $admin->hasRole($permission->roles);
    }

    /**
     * Determine if the role has the given permission.
     *
     * @param mixed $permission
     * @return boolean
     */
    public function inRole($permission)
    {
        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }
        return !!$permission->intersect($this->permissions)->count();
    }
}
