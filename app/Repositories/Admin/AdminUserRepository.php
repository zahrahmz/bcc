<?php


namespace App\Repositories\Admin;

use App\Models\Admin;
use App\Repositories\BaseRepository;

class AdminUserRepository extends BaseRepository
{
    public function __construct(Admin $admin)
    {
        parent::__construct($admin);
        $this->model = $admin;
    }

    public function listProducts($paginate = false, $searchPhrase = null, string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        if ($paginate) {
            $data = $this->paginate($columns, $order, $sort, $searchPhrase);
        } else {
            $data = $this->all($columns, $order, $sort);
        }

        return $data;
    }
}
