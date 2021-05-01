<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;

/**
 * App\Models\SettingValue
 *
 * @property int $id
 * @property int $setting_id
 * @property int $default
 * @property string $value
 * @property string|null $deleted_at
 * @property-read \App\Models\Setting $setting
 * @method static \App\Models\Eloquent\BaseBuilder|SettingValue newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|SettingValue newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|SettingValue query()
 * @method static \App\Models\Eloquent\BaseBuilder|SettingValue whereDefault($value)
 * @method static \App\Models\Eloquent\BaseBuilder|SettingValue whereDeletedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|SettingValue whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|SettingValue whereSettingId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|SettingValue whereValue($value)
 * @mixin \Eloquent
 */
class SettingValue extends BaseModel
{
    protected $table = 'setting_values';


    const DEFAULT = 1;

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
