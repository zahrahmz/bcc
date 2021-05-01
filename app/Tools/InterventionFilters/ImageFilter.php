<?php

namespace App\Tools\InterventionFilters;

use App\Models\Eloquent\BaseModel;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Constraint;
use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class ImageFilter implements FilterInterface
{
    private $height;

    public function __construct(BaseModel $model)
    {
        $this->height = Config::get(
            'custom_config.files.size.' .
            get_class($model) .
            '.height');
    }


    public function applyFilter(Image $image)
    {
        $image->resize(null, $this->height, function (Constraint $imageObj) {
            $imageObj->aspectRatio();
            $imageObj->upsize();
        });

        return $image;
    }
}
