<?php


namespace App\Repositories\Admin;

use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    public function listOrders($filter)
    {
        $query = $this
            ->model
            ->newQuery()
            ->with('user');

        $query->magicQuery(
            $filter,
            ['relation_user__name','relation_user__mobile','name_of_receiver','address','phone','id'],
            ['created_at', 'id','order_state','payment_status'],
            ['order_state','payment_status']
        );

        return $query->paginate();
    }

    public function showOrder($order)
    {
        return $this->model->newQuery()
            ->where('id',$order->id)
            ->with(['payments' => function($query){
                return $query->orderBy('id','desc');
            }])
            ->with('orderItems')
            ->with('user')
            ->with('user.addresses')
            ->first();
    }
}
