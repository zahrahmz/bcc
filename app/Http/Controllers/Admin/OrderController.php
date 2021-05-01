<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Repositories\Admin\OrderRepository;
use App\Services\PdfHelper;

class OrderController extends BaseController
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $this->setPageTitle('سفارشات');
        $this->setSideBar('orders');
        return view('admin.orders.index');
    }

    public function show()
    {
        $this->setPageTitle('سفارش');
        $this->setSideBar('orders');
        return view('admin.orders.show');
    }
}
