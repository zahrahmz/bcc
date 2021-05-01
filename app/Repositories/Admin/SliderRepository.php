<?php

namespace App\Repositories\Admin;

use App\Exceptions\Slider\SliderCreateErrorException;
use App\Exceptions\Slider\SliderNotFoundException;
use App\Exceptions\Slider\SliderUpdateErrorException;
use App\Models\Image;
use App\Models\Slider;
use App\Repositories\BaseRepository;
use App\Traits\UploadableTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SliderRepository extends BaseRepository
{
    use  UploadableTrait;
    /**
     * SliderRepository constructor.
     * @param Slider $slider
     */
    public function __construct(Slider $slider)
    {
        parent::__construct($slider);
        $this->model = $slider;
    }

    /**
     * List all the
     *
     * @param bool $paginate
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function list($paginate = true, string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        if ($paginate) {
            $data = $this->paginate($columns, $order, $sort);
        } else {
            $data = $this->all($columns, $order, $sort);
        }

        return $data;
    }

    /**
     * Create the slider
     *
     * @param array $data
     *
     * @return Slider
     * @throws SliderCreateErrorException
     */
    public function createSlider(array $data): Slider
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new SliderCreateErrorException($e);
        }
    }


    public function updateSlider(array $attributes, Slider $slider): bool
    {
        try {
            $this->update($attributes,$slider->id);
        } catch (QueryException $e) {
            throw new SliderUpdateErrorException($e);
        }
    }
}
