<?php

namespace App\Repositories\Site;

use App\Exceptions\Slider\SliderCreateErrorException;
use App\Exceptions\Slider\SliderNotFoundException;
use App\Exceptions\Slider\SliderUpdateErrorException;
use App\Models\Slider;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class SliderRepository extends BaseRepository
{
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

    /**
     * Update the slider
     *
     * @param array $data
     *
     * @param Slider $slider
     * @return bool
     * @throws SliderUpdateErrorException
     * @throws \App\Exceptions\Slider\SliderUpdateErrorException
     */
    public function updateSlider(array $data, Slider $slider): bool
    {
        try {
            return $slider->update($data);
        } catch (QueryException $e) {
            throw new SliderUpdateErrorException($e);
        }
    }

    /**
     * Find the slider by ID
     *
     * @param int $id
     *
     * @return Slider
     * @throws SliderNotFoundException
     */
    public function findSliderById(int $id): Slider
    {
        try {
            $slider = $this->findOneOrFail($id);
            return $slider->load('images');
        } catch (ModelNotFoundException $e) {
            throw new SliderNotFoundException($e);
        }
    }

    /**
     * Get the slider via slug
     *
     * @param array $slug
     *
     * @return Slider
     * @throws SliderNotFoundException
     */
    public function findSliderBySlug(array $slug): Slider
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new SliderNotFoundException($e);
        }
    }

    /**
     * @return mixed
     */
    public function findSliderImages(): Collection
    {
        return $this->model->images()->get();
    }

    public function getSliders()
    {
        $result[Slider::HOME_MIDDLE] = [];
        $result[Slider::HOME_TOP] = [];

        $sliders = $this
            ->model
            ->newQuery()
            ->select([
                'link',
                'id',
                'section',
            ])
            ->where('status', Slider::ACTIVE)
            ->get();

        foreach ($sliders as $key => $slide){
            array_push($result[$slide->section], ['link' => $slide->link,'image' => $slide->image]);
        }

        return $result;
//        dd(\Spatie\Once\Cache::);
    }
}
