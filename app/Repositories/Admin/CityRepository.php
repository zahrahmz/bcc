<?php


namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use Baloot\Models\City;
use Illuminate\Support\Facades\Cache;

class CityRepository extends BaseRepository
{
    public function __construct(City $city)
    {
        parent::__construct($city);
        $this->model = $city;
    }

    public function getCitiesOfProvince($province)
    {
        if (Cache::has('cities_of_province_list' . $province)) {
            return Cache::get('cities_of_province_list' . $province);
        }

        Cache::rememberForever('cities_of_province_list' . $province, function () use ($province) {
            $provinces = $this->model->newQuery()->where('province_id', $province->id)->pluck('name', 'id')->toArray();

            return $provinces;
        });
        return Cache::get('cities_of_province_list' . $province);
    }
}
