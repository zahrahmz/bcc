<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Users\AddressRequest;
use App\Models\Site\User;
use App\Repositories\Admin\CityRepository;
use App\Repositories\Admin\ProvinceRepository;
use App\Repositories\Admin\UserRepository;

class AddressController extends BaseController
{

    /**
     * @var ProvinceRepository
     */
    private $provinceRepository;
    /**
     * @var CityRepository
     */
    private $cityRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        ProvinceRepository $provinceRepository,
        CityRepository $cityRepository,
        UserRepository $userRepository
    ) {
        $this->provinceRepository = $provinceRepository;
        $this->cityRepository = $cityRepository;
        $this->userRepository = $userRepository;
    }

    public function create(User $user)
    {
        $this->setPageTitle('مدیریت مشتریان');
        $this->setSideBar('users');
        $provinces = $this->provinceRepository->getProvinces();
        return view('admin.addresses.create', compact('user', 'provinces'));
    }

    public function store(AddressRequest $request, User $user)
    {
        $data = $request->validated();
        $this->userRepository->saveUserAddress($user, $data);
        return redirect()->route('admin.users.edit', $user->id)->with('message', trans('users.user_address_created_successfully'));
    }









    /****************************************************************************************
    *                                   API
     *****************************************************************************************/
    public function getCitiesOfProvince($province)
    {
        $provinces = $this->cityRepository->getCitiesOfProvince($province);
        return response()->json($provinces, 200);
    }
}
