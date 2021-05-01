<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;
use ReflectionClass;
use ReflectionException;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property string $path
 * @property int $imageable_id
 * @property string $imageable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $imageable
 * @method static \App\Models\Eloquent\BaseBuilder|Image newModelQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Image newQuery()
 * @method static \App\Models\Eloquent\BaseBuilder|Image query()
 * @method static \App\Models\Eloquent\BaseBuilder|Image whereCreatedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Image whereDeletedAt($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Image whereId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Image whereImageableId($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Image whereImageableType($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Image wherePath($value)
 * @method static \App\Models\Eloquent\BaseBuilder|Image whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Image extends BaseModel
{
    const SLIDER_DEFAULT = 'no_image.png';
    const PRODUCT_DEFAULT = 'no_image.png';
    const CATEGORY_DEFAULT = 'no_image.png';

    protected $hidden = [
        'id',
        'imageable_id',
        'imageable_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'path'
    ];

    /**
     * Get the owning imageable model.
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    public function getPathAttribute($path)
    {
        $baseUrl = env('APP_IMAGE_URL') . '/';
        if (!is_null($path)) {
            return $baseUrl . $path;
        }

        return $baseUrl . $this->getDefaultImage(strtoupper($this->imageable_type . '_DEFAULT'));
    }


    public function getDefaultImage($constant)
    {
        try {
            $reflection = new ReflectionClass(get_class());
            return $reflection->getConstant($constant);
        } catch (ReflectionException $e) {
            throw new ReflectionException('Const Not Found');
        }
    }
}
