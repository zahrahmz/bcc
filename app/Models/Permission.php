<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $label
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \App\Models\Eloquent\BaseBuilder|Permission newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Permission newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Permission query()
 * @method static \App\Models\Eloquent\BaseBuilder|Permission whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Permission whereDescription($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Permission whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Permission whereLabel($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Permission whereName($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends BaseModel
{
    protected $guarded = ['id'];
    protected $fillable = ['name', 'label', 'description'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }





    /**************************************************************************************************************
    *                                   Role - Permission
     *************************************************************************************************************/

    /**
     * Determine if the permission belongs to the role.
     *
     * @param mixed $role
     * @return boolean
     */
    public function inRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        return !!$role->intersect($this->roles)->count();
    }
}
