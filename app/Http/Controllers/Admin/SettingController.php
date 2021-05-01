<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Settings\CreateSettingRequest;
use App\Http\Requests\Admin\Settings\UpdateSettingRequest;
use App\Models\Setting;
use App\Repositories\Admin\SettingRepository;

/**
 * @property SettingRepository repository
 */
class SettingController extends BaseController
{
    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }


    public function index()
    {
        $this->setPageTitle(trans('settings.name'));
        $this->setSideBar('settings');
        $settings = $this->repository->list(true);
        return view('admin.settings.index', compact('settings'));
    }


    public function create()
    {
        $this->setPageTitle(trans('settings.create_setting'));
        $this->setSideBar('settings');
        $settings = $this->repository->all();
        return view('admin.settings.create', compact('settings'));
    }


    public function store(CreateSettingRequest $request)
    {
        $this->repository->createSetting($request->all());
        return redirect()->route('admin.settings.index')->with('message', trans('settings.setting_updated_successfully'));
    }


    public function edit(Setting $setting)
    {
        $this->setPageTitle(trans('settings.edit_setting'));
        $this->setSideBar('settings');
        return view('admin.settings.edit', compact('setting'));
    }


    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $this->setPageTitle(trans('settings.name'));
        $this->setSideBar('settings');
        $this->repository->updateSetting($request->all(), $setting);
        return redirect()->route('admin.settings.index')
            ->with('message', trans('settings.setting_updated_successfully'));
    }


    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('admin.settings.index', $setting->id)->with('message', trans('settings.setting_removed_successfully'));
    }
}
