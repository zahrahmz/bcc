<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;
use App\Traits\PersianDateConvertor;

/**
 * App\Models\Discount
 *
 * @property int $id
 * @property string $title
 * @property int $percent
 * @property int $status
 * @property string $start_date
 * @property string $end_date
 * @property int $discountable_id
 * @property string $discountable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $discountable
 * @property-read mixed $type
 * @method static \App\Models\Eloquent\BaseBuilder|Discount newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Discount newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Discount query()
 * @method static \App\Models\Eloquent\BaseBuilder|Discount whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Discount whereDeletedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Discount whereDiscountableId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Discount whereDiscountableType($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Discount whereEndDate($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Discount whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Discount wherePercent($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Discount whereStartDate($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Discount whereStatus($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Discount whereTitle($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Discount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Discount extends BaseModel
{
    use PersianDateConvertor;

    protected $fillable = [
        'start_date',
        'end_date',
        'title',
        'percent',
        'status'
    ];

    const DISCOUNTABLE_TYPES = [
        'برند' => Category::class,
        'محصول' => Product::class,
    ];


    const ACTIVE = 1;
    const NOT_ACTIVE = 0;

    /**
     * Get the owning discountable model.
     */
    public function discountable()
    {
        return $this->morphTo();
    }


    public function getTypeAttribute()
    {
        foreach (self::DISCOUNTABLE_TYPES as $discountTypeName => $discountableType) {
            if (ucfirst(class_basename((new $discountableType))) == ucfirst($this->discountable_type)) {
                return $discountTypeName;
            }
        }
        return false;
    }

    public function getStartDateAttribute()
    {
        return $this->formatToJalali(__FUNCTION__);
    }

    public function getEndDateAttribute()
    {
        return $this->formatToJalali(__FUNCTION__);
    }
}
