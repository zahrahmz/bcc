<?php

namespace App\Models;

use App\Models\Eloquent\BaseBuilder;
use App\Models\Eloquent\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property int $order
 * @property int|null $parent_id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $status is show
 * @property string|null $link for collection links
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Collection|Category[] $child
 * @property-read int|null $child_count
 * @property-read Collection|Category[] $children
 * @property-read int|null $children_count
 * @property-read Discount|null $discount
 * @property-read mixed $image
 * @property-read Category|null $parent
 * @property-read Category|null $parents
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static BaseBuilder|Category newModelQuery()
 * @method static BaseBuilder|Category newQuery()
 * @method static BaseBuilder|Category query()
 * @method static BaseBuilder|Category whereCreatedAt($value)
 * @method static BaseBuilder|Category whereDeletedAt($value)
 * @method static BaseBuilder|Category whereDescription($value)
 * @method static BaseBuilder|Category whereId($value)
 * @method static BaseBuilder|Category whereLink($value)
 * @method static BaseBuilder|Category whereName($value)
 * @method static BaseBuilder|Category whereOrder($value)
 * @method static BaseBuilder|Category whereParentId($value)
 * @method static BaseBuilder|Category whereSlug($value)
 * @method static BaseBuilder|Category whereStatus($value)
 * @method static BaseBuilder|Category whereType($value)
 * @method static BaseBuilder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends BaseModel
{
    const MENU = 1;
    const CATEGORY = 2;
    const BRAND = 3;

    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $guarded = [];

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this
            ->hasMany(Category::class, 'parent_id', 'id')
            ->where('type',self::MENU)
            ->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function parents()
    {
        return $this->belongsTo(Category::class, 'parent_id')->with('parents');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function discount()
    {
        return $this->morphOne('App\Models\Discount', 'discountable');
    }

    public function getTypeAttribute($type)
    {
        switch ($type) {
            case 1:
                return "منو";
            case 2:
                return "دسته بندی";
            case 3:
                return "برند";
        }
        return null;
    }

    public function getImageAttribute()
    {
        return optional($this->morphOne('App\Models\Image', 'imageable')->first())->path;
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
