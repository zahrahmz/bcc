<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Attribute
 *
 * @property int $id
 * @property string $attribute_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $converted_created_at
 * @property-read mixed $converted_updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributeValue[] $values
 * @property-read int|null $values_count
 * @method static \App\Models\Eloquent\BaseBuilder|Attribute newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Attribute newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Attribute query()
 * @method static \App\Models\Eloquent\BaseBuilder|Attribute whereAttributeName($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Attribute whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Attribute whereDeletedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Attribute whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Attribute whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Attribute extends BaseModel
{
    protected $fillable = [
        'attribute_name'
    ];

    public function getConvertedCreatedAtAttribute()
    {
        return Verta::instance($this->created_at);
    }

    public function getConvertedUpdatedAtAttribute()
    {
        return Verta::instance($this->updated_at);
    }


    /**
     * @return HasMany
     */
    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
