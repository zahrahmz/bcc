<?php
namespace App\Models;

use App\Models\Eloquent\BaseModel;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $name
 * @property string $key
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SettingValue[] $settingValues
 * @property-read int|null $setting_values_count
 * @method static \App\Models\Eloquent\BaseBuilder|Setting newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Setting newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Setting query()
 * @method static \App\Models\Eloquent\BaseBuilder|Setting whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Setting whereDeletedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Setting whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Setting whereKey($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Setting whereName($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Setting whereStatus($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Setting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Setting extends BaseModel
{
    protected $table = 'settings';

    const ACTIVE = 1;

    public function settingValues()
    {
        return $this->hasMany(SettingValue::class);
    }
}
