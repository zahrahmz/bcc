<?php


namespace App\Repositories\Admin;

use App\Models\Role;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
        $this->model = $role;
    }

    /**
     * List all the products
     *
     * @param bool $paginate
     * @param null $searchPhrase
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listRoles($paginate = false, $searchPhrase = null, string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        if ($paginate) {
            $data = $this->paginate($columns, $order, $sort, $searchPhrase);
        } else {
            $data = $this->all($columns, $order, $sort);
        }

        return $data;
    }
}
