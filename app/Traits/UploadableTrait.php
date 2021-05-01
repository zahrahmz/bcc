<?php

namespace App\Traits;

use App\Models\Eloquent\BaseModel;
use App\Models\Image;
use App\Tools\InterventionFilters\ImageFilter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageIntervention;

trait UploadableTrait
{
    public function saveImages(Collection $filesCollection, BaseModel $model)
    {
        $filesCollection->each(function (UploadedFile $file) use ($model) {
//            $path = $file->hashName('products');
//            $image = \Intervention\Image\Facades\Image::make($file);
//
//
//            $image->resize(null, 525, function ($constraint) {
//                $constraint->aspectRatio();
//                $constraint->upsize();
//            });
//
//            if(Storage::disk('s3')->put($path, (string) $image->encode())){
//                $productImage = new Image([
//                    'path' => $path
//                ]);
//                $product->images()->save($productImage);
//            }
            $dir = Config::get('custom_config.files.store_directory');
            $disk = Config::get('custom_config.files.disk');
            if (!File::isDirectory($dir)){
                File::makeDirectory($dir, 0777, true, true);
            }
            $path = $file->hashName($dir);
            $image = ImageIntervention::make($file);

            $image->filter(new ImageFilter($model));

            $isImageSaved = Storage::disk($disk)
                ->put($path, (string)$image->encode());

            if ($isImageSaved) {
                $createdImage = new \App\Models\Image([
                    'path' => $path,
                ]);
                $model->image()->save($createdImage);
            }
        });
    }

    public function deleteImage(BaseModel $model)
    {
        try {
            if ($model instanceof Image){
                $model->delete();
                return true;
            }

            if ($model->image != null){
                if ($model->relationMethodDefineInModel('image')){
                    $model->image()->delete();
                    return true;
                }
                if ($model->relationMethodDefineInModel('images')){
                    $model->images()->delete();
                    return true;
                }
            }
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }

        return true;
    }
}
