<?php


namespace App\Repositories\Admin;

use App\Models\Address;
use App\Repositories\BaseRepository;

class AddressRepository extends BaseRepository
{
    public function __construct(Address $address)
    {
        parent::__construct($address);
        $this->model = $address;
    }
}
