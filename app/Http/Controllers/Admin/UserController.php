<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Site\User;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $searchPhrase = $request->get('search') ?? null;
        $this->setPageTitle('مدیریت مشتریان');
        $this->setSideBar('users');
        $users = $this->userRepository->listUsers(true, $searchPhrase);
        return view('admin.users.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $this->setPageTitle('ویرایش کاربر');
        $this->setSideBar('users');
        $user = $user->load('addresses');
        return view('admin.users.users.edit', compact('user'));
    }
}
