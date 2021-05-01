<?php

namespace App\Models;

use App\Models\Eloquent\BaseBuilder;
use App\Models\Eloquent\BaseModel;
use App\Traits\SearchTrait;
use Carbon\Carbon;
use Eloquent;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Product
 *

 * @property mixed active
 * @property mixed price
 * @property int $id
 * @property string $product_name
 * @property string $sku
 * @property string $slug
 * @property int $gender 0 means boy,1 means girl,2 means boy and girl
 * @property string|null $description
 * @property int $featured
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Collection|ProductAttribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Discount|null $discount
 * @property-read mixed $converted_created_at
 * @property-read mixed $converted_updated_at
 * @property-read mixed $image
 * @property-read mixed $product_discount
 * @property-read mixed $product_price_discount
 * @property-read Collection|Image[] $images
 * @property-read int|null $images_count
 * @method static BaseBuilder|Product active()
 * @method static BaseBuilder|Product newModelQuery()
 * @method static BaseBuilder|Product newQuery()
 * @method static BaseBuilder|Product query()
 * @method static BaseBuilder|Product search($keyword, $matchAllFields = false)
 * @method static BaseBuilder|Product whereCreatedAt($value)
 * @method static BaseBuilder|Product whereDeletedAt($value)
 * @method static BaseBuilder|Product whereDescription($value)
 * @method static BaseBuilder|Product whereFeatured($value)
 * @method static BaseBuilder|Product whereGender($value)
 * @method static BaseBuilder|Product whereId($value)
 * @method static BaseBuilder|Product wherePrice($value)
 * @method static BaseBuilder|Product whereProductName($value)
 * @method static BaseBuilder|Product whereSku($value)
 * @method static BaseBuilder|Product whereSlug($value)
 * @method static BaseBuilder|Product whereStatus($value)
 * @method static BaseBuilder|Product whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Product extends BaseModel
{
    use SearchTrait;


    const ACTIVE = 1;
    const INACTIVE = 0;

    const FEATURED = 1;
    const NORMAL = 0;

    const GENDER = [
        '0' => 'پسر',
        '1' => 'دختر',
        '2' => 'بدون جنسیت',
    ];

    protected $search = [
        'product_name',
        'slug',
        'id'
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku',
        'product_name',
        'gender',
        'description',
        'quantity',
        'price',
        'status',
        'slug',
        'featured',
    ];


    public function scopeActive($query)
    {
        $query->where('status', self::ACTIVE);
    }

    public function getConvertedCreatedAtAttribute()
    {
        return Verta::instance($this->created_at);
    }

    public function getConvertedUpdatedAtAttribute()
    {
        return Verta::instance($this->updated_at);
    }

    /**
     * return all discount that still has time and not been expired
     */
    public function getProductDiscountAttribute()
    {
        $result = $this->load(['discount' => function ($query) {
            $query->where('end_date', '>', Carbon::now());
            $query->where('start_date', '<=', Carbon::now());
        }, 'categories' => function (BelongsToMany $query) {
            $query->whereHas('discount', function ($query) {
                $query->where('end_date', '>', Carbon::now());
                $query->where('start_date', '<=', Carbon::now());
            });
        }]);

        //check if product has discount(because product discount has priority)
        if ($result->discount) {
            return $result->discount['percent'];
        }


        //if product hasn't any discount we search on all product's categories and find maximum discount
        if ($result->categories->isNotEmpty()) {
            $allPercentPerCategories = [];
            foreach ($result->categories as $eachCategory) {
                array_push($allPercentPerCategories, $eachCategory->discount['percent']);
            };
            sort($allPercentPerCategories);
            return array_pop($allPercentPerCategories);
        }

        return 0;
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }
    /**
     * @return MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return HasMany
     */
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    /**
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the products's discount.
     */
    public function discount()
    {
        return $this->morphOne('App\Models\Discount', 'discountable');
    }

    public function getProductPriceDiscountAttribute()
    {
        return ((100 - $this->product_discount) * $this->price) / 100;
    }

    public function getImageAttribute()
    {
        return optional($this->morphOne('App\Models\Image', 'imageable')->first())->path;
    }

    public function getImagesAttribute()
    {
        return $this->morphMany('App\Models\Image', 'imageable')->pluck('path','id');
    }

}
