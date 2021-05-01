<?php


namespace App\Repositories\Site;

use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function __construct(Order $order)
    {
        parent::__construct($order);
        $this->model = $order;
    }

    public function createOrder($data) :Order
    {
        return $this->create($data);
    }
}
