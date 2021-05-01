<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\AttributeValue
 *
 * @property int $id
 * @property string $value
 * @property int $attribute_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Attribute $attribute
 * @property-read mixed $converted_created_at
 * @property-read mixed $converted_updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductAttribute[] $productAttributes
 * @property-read int|null $product_attributes_count
 * @method static \App\Models\Eloquent\BaseBuilder|AttributeValue newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|AttributeValue newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|AttributeValue query()
 * @method static \App\Models\Eloquent\BaseBuilder|AttributeValue whereAttributeId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|AttributeValue whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|AttributeValue whereDeletedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|AttributeValue whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|AttributeValue whereUpdatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|AttributeValue whereValue($value)
 * @mixin \Eloquent
 */
class AttributeValue extends BaseModel
{
    protected $table = 'attribute_values';

    protected $fillable = [
        'value'
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
     * @return BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * @return BelongsToMany
     */
    public function productAttributes()
    {
        return $this->belongsToMany(ProductAttribute::class);
    }
}
