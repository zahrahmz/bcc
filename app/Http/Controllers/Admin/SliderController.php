<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Sliders\CreateSliderRequest;
use App\Http\Requests\Admin\Sliders\UpdateSliderRequest;
use App\Http\Requests\Admin\Sliders\UploadImagesRequest;
use App\Models\Image;
use App\Models\Slider;
use App\Repositories\Admin\SliderRepository;

class SliderController extends BaseController
{
    /**
     * @var SliderRepository
     */
    private $sliderRepository;

    public function __construct(SliderRepository $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }


    public function index()
    {
        $this->setPageTitle(trans('sliders.name'));
        $this->setSideBar('sliders');
        $sliders = $this->sliderRepository->list();
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle(trans('sliders.create_slider'));
        $this->setSideBar('sliders');
        $sliders = $this->sliderRepository->list();
        return view('admin.sliders.create', compact('sliders'));
    }



    public function store(CreateSliderRequest $request)
    {
        $slider = $this->sliderRepository->createSlider($request->all());
        return redirect()->route('admin.sliders.edit', $slider->id)->with('message', trans('sliders.slider_created_successfully'));
    }

    /**
     * @param Slider $slider
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Slider $slider)
    {
        $this->setPageTitle(trans('sliders.edit_slider'));
        $this->setSideBar('sliders');
        return view('admin.sliders.edit', compact('slider'));
    }


    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $this->setPageTitle(trans('sliders.name'));
        $this->setSideBar('sliders');
        $this->sliderRepository->updateSlider($request->all(), $slider);
        return redirect()->route('admin.sliders.edit', $slider->id)
            ->with('message', trans('sliders.slider_updated_successfully'))
            ->with(['tab' => 'slider_attribute']);
    }


    public function uploadImages(UploadImagesRequest $request, Slider $slider)
    {
        $file = $request->validated();
        $this->sliderRepository->saveImages(collect($file),$slider);
        return redirect()->route('admin.sliders.edit', $slider->id)
            ->with('message', trans('sliders.sliders_image_uploaded_successfully'))
            ->with(['tab' => 'sliders_images']);
    }


    public function deleteImage(Slider $slider, Image $image)
    {
        $this->sliderRepository->deleteImage($image);
    }


    public function addPhoto(Slider $slider)
    {
        return view('admin.sliders.add-photo', compact('slider'));
    }


    public function delete(Slider $slider)
    {
        $this->sliderRepository->delete($slider);
        return redirect()->route('admin.sliders.index', $slider->id)->with('message', trans('sliders.slider_removed_successfully'));
    }
}
