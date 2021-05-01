<?php


namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use Baloot\Models\Province;
use Illuminate\Support\Facades\Cache;

class ProvinceRepository extends BaseRepository
{
    public function __construct(Province $province)
    {
        parent::__construct($province);
        $this->model = $province;
    }

    public function getProvinces()
    {
        if (Cache::has('province_list')) {
            return Cache::get('province_list');
        }

        Cache::rememberForever('province_list', function () {
            $provinces = $this->model->newQuery()->pluck('name', 'id')->toArray();
            return $provinces;
        });
        return Cache::get('province_list');
    }
}
