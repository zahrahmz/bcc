<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Users\AddressRequest;
use App\Models\Site\User;
use App\Repositories\Admin\UserRepository;
use App\Repositories\Site\AddressRepository;
use App\Repositories\Site\CityRepository;
use App\Repositories\Site\ProvinceRepository;

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
    /**
     * @var AddressRepository
     */
    private $addressRepository;

    public function __construct(
        ProvinceRepository $provinceRepository,
        CityRepository $cityRepository,
        UserRepository $userRepository,
        AddressRepository $addressRepository
    ) {
        $this->provinceRepository = $provinceRepository;
        $this->cityRepository = $cityRepository;
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
    }

    public function create(User $user)
    {
        $provinces = $this->provinceRepository->getProvinces();
        return view('admin.addresses.create', compact('user', 'provinces'));
    }

    public function store(AddressRequest $request)
    {
        $data = $request->validated();
        $user = currentUserObj();
        $this->userRepository->saveUserAddress($user, $data);
        return redirect()->route('admin.users.edit', $user->id)->with('message', trans('users.user_address_created_successfully'));
    }

    public function index()
    {
        $user = currentUserObj();
        $addresses =  $this->addressRepository->getUserAddressList($user);
//        return view('admin.addresses.create',compact('user','provinces'));
    }
}
