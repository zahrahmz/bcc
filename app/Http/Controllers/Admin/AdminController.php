<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\AdminUsers\CreateAdminUserRequest;
use App\Models\Site\User;
use App\Repositories\Admin\AdminUserRepository;
use App\Repositories\Admin\RoleRepository;
use App\Services\Admin\AdminUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Propaganistas\LaravelPhone\PhoneNumber;

class AdminController extends BaseController
{
    /**
     * @var AdminUserRepository
     */
    private $adminUserRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var AdminUserService
     */
    private $adminUserService;

    public function __construct(AdminUserRepository $adminUserRepository, RoleRepository $roleRepository, AdminUserService $adminUserService)
    {
        $this->adminUserRepository = $adminUserRepository;
        $this->roleRepository = $roleRepository;
        $this->adminUserService = $adminUserService;
    }

    public function index(Request $request)
    {
        $searchPhrase = $request->get('search') ?? null;
        $this->setPageTitle('مدیریت کابران');
        $this->setSideBar('admin-users');
        $adminUsers = $this->adminUserRepository->listProducts(true, $searchPhrase);
        return view('admin.users.admins.index', compact('adminUsers'));
    }

    public function create()
    {
        $this->setPageTitle('اضافه کردن مدیر');
        $this->setSideBar('admin-users');
        $roles = $this->roleRepository->listRoles();
        return view('admin.users.admins.create', compact('roles'));
    }

    public function store(CreateAdminUserRequest $request)
    {
        $data = $request->validated();
        $data['mobile'] = PhoneNumber::make($data['mobile'], 'IR')->formatForMobileDialingInCountry('IR');
        $data['password'] = Hash::make($data['password']);
        $this->adminUserService->createAdminUserAndAssignRole($data);
        return redirect()->route('admin.admins.index')->with('message', 'مدیر با موفقیت اضافه شد');
    }

    public function loginAS(User $user)
    {
        $manager = app('impersonate');
        $manager->findUserById($user->id,'site');

        if ($manager->isImpersonating()){
            $manager->leave();
        }

        $user->impersonate($user, 'site');
        return redirect('/');
    }
}
