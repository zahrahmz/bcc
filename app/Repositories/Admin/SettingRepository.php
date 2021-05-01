<?php

namespace App\Repositories\Admin;

use App\Exceptions\Setting\SettingCreateErrorException;
use App\Exceptions\Setting\SettingNotFoundException;
use App\Exceptions\Setting\SettingUpdateErrorException;
use App\Models\Setting;
use App\Models\SettingValue;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class SettingRepository extends BaseRepository
{

    /**
     * SettingRepository constructor.
     * @param Setting $setting
     */
    public function __construct(Setting $setting)
    {
        parent::__construct($setting);
        $this->model = $setting;
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
    public function list($paginate = false, string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        if ($paginate) {
            $data = $this->paginate($columns, $order, $sort);
        } else {
            $data = $this->all($columns, $order, $sort);
        }

        return $data;
    }

    /**
     * Create the category
     *
     * @param array $data
     *
     * @return Setting
     * @throws SettingCreateErrorException
     */
    public function createSetting(array $data): Setting
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new SettingCreateErrorException($e);
        }
    }

    /**
     * Update the category
     *
     * @param array $data
     *
     * @param Setting $setting
     * @return bool
     * @throws SettingUpdateErrorException
     * @throws \App\Exceptions\Setting\SettingUpdateErrorException
     */
    public function updateSetting(array $data, Setting $setting): bool
    {
        try {
            return $setting->update($data);
        } catch (QueryException $e) {
            throw new SettingUpdateErrorException($e);
        }
    }

    /**
     * Find the category by ID
     *
     * @param int $id
     *
     * @return Setting
     * @throws SettingNotFoundException
     */
    public function findSettingById(int $id): Setting
    {
        try {
            $setting = $this->findOneOrFail($id);
            return $setting;
        } catch (ModelNotFoundException $e) {
            throw new SettingNotFoundException($e);
        }
    }


    /**
     * Get the category via slug
     *
     * @param array $slug
     *
     * @return Setting
     * @throws SettingNotFoundException
     */
    public function findSettingBySlug(array $slug): Setting
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new SettingNotFoundException($e);
        }
    }

    /**
     * Delete the category
     *
     * @param Setting $setting
     *
     * @return bool
     * @throws \Exception
     * @deprecated
     * @use removeSetting
     */
    public function deleteSetting(Setting $setting): bool
    {
        return $setting->delete();
    }


    public function getDefaultBankGateway(): string
    {
        return $this->model
            ->newQuery()
            ->where('status', Setting::ACTIVE)
            ->where('key', 'BANK_GATEWAY')
            ->first()->settingValues->where('default', SettingValue::DEFAULT)->first()->value;
    }
}
