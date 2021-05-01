<?php

namespace App\Repositories\Site;

use App\Exceptions\Shipment\ShipmentCreateErrorException;
use App\Exceptions\Shipment\ShipmentNotFoundException;
use App\Exceptions\Shipment\ShipmentUpdateErrorException;
use App\Models\Shipment;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class ShipmentRepository extends BaseRepository
{

    /**
     * ShipmentRepository constructor.
     * @param Shipment $shipment
     */
    public function __construct(Shipment $shipment)
    {
        parent::__construct($shipment);
        $this->model = $shipment;
    }

    /**
     * List all the
     *
     * @param bool $paginate
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function list($paginate = false, string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        if ($paginate) {
            $data = $this->paginate($columns, $order, $sort);
        } else {
            $data = $this->all($columns, $order, $sort);
        }

        return $data;
    }

    /**
     * Create the category
     *
     * @param array $data
     *
     * @return Shipment
     * @throws ShipmentCreateErrorException
     */
    public function createShipment(array $data): Shipment
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new ShipmentCreateErrorException($e);
        }
    }


    public function updateShipment(array $data, Shipment $shipment)
    {
        try {
            return $shipment->update($data);
        } catch (QueryException $e) {
            throw new ShipmentUpdateErrorException($e);
        }
    }

    /**
     * Find the category by ID
     *
     * @param int $id
     *
     * @return Shipment
     * @throws ShipmentNotFoundException
     */
    public function findShipmentById(int $id): Shipment
    {
        try {
            $shipment = $this->findOneOrFail($id);
            return $shipment;
        } catch (ModelNotFoundException $e) {
            throw new ShipmentNotFoundException($e);
        }
    }


    /**
     * Get the category via slug
     *
     * @param array $slug
     *
     * @return Shipment
     * @throws ShipmentNotFoundException
     */
    public function findShipmentBySlug(array $slug): Shipment
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new ShipmentNotFoundException($e);
        }
    }

    /**
     * Delete the category
     *
     * @param Shipment $shipment
     *
     * @return bool
     * @throws \Exception
     * @deprecated
     * @use removeShipment
     */
    public function deleteShipment(Shipment $shipment): bool
    {
        return $shipment->delete();
    }
}
