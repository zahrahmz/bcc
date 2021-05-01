<?php


namespace App\Repositories\Site;

use App\Exceptions\Address\AddressNotFoundException;
use App\Exceptions\Shipment\ShipmentNotFoundException;
use App\Models\Address;
use App\Models\Shipment;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddressRepository extends BaseRepository
{
    public function __construct(Address $address)
    {
        parent::__construct($address);
        $this->model = $address;
    }

    public function saveUserAddress($user, $addressData)
    {
        $user->addresses()->save(new Address($addressData));
    }

    public function getUserAddressList($user)
    {
        return $user->addresses()->get();
    }

    /**
     * Find the category by ID
     *
     * @param int $id
     *
     * @return Shipment
     * @throws ShipmentNotFoundException
     */
    public function findShipmentById(int $id): Address
    {
        try {
            $shipment = $this->findOneOrFail($id);
            return $shipment;
        } catch (ModelNotFoundException $e) {
            throw new AddressNotFoundException($e);
        }
    }
}
