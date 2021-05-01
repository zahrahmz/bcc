<?php


namespace App\Repositories\Site;

use App\Models\Address;
use App\Models\Site\User;
use App\Repositories\BaseRepository;
use App\Traits\UploadableTrait;

class UserRepository extends BaseRepository
{
    use  UploadableTrait;


    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->model = $user;
    }

    public function listUsers($paginate = false, $searchPhrase = null, string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        if ($paginate) {
            $data = $this->paginate($columns, $order, $sort, $searchPhrase);
        } else {
            $data = $this->all($columns, $order, $sort);
        }

        return $data;
    }

    public function saveUserAddress($user, $addressData)
    {
        $user->addresses()->save(new Address($addressData));
    }
}
