<?php


namespace App\Services\Admin;

use App\Repositories\Admin\AdminUserRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AdminUserService
{
    /**
     * @var AdminUserRepository
     */
    private $adminUserRepository;

    public function __construct(AdminUserRepository $adminUserRepository)
    {
        $this->adminUserRepository =$adminUserRepository;
    }

    public function createAdminUserAndAssignRole($data)
    {
        try {
            DB::beginTransaction();
            $adminUser = $this->adminUserRepository->create($data);
            $adminUser->roles()->attach($data['role']);
            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            //TODO::show error page
        }
    }
}
