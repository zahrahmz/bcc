<?php

namespace App\Models;

use App\Models\Eloquent\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends BaseModel
{
    use SoftDeletes;
    protected $guarded = [];

    const ACTIVE = 1;
    const INACTIVE = 0;

    const HOME_MIDDLE = 'home_page_middle_static_photos';
    const HOME_TOP = 'home_page_top_slider';


    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }


    public function getImageAttribute()
    {
        return optional($this->morphOne('App\Models\Image', 'imageable')->first())->path;
    }


}
