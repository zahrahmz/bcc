<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\BaseController;
use App\Models\Order;
use App\Repositories\Admin\OrderRepository;
use App\Services\PdfHelper;
use App\Tools\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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

    public function index(Request $request)
    {
        $filters = $request->all();
        return response()->json(
            $products = $this->orderRepository->listOrders($filters),
            200
        );
    }

    public function show(Order $order)
    {
        return response()->json(
            $this->orderRepository->showOrder($order),
            200
        );
    }

    public function generatePdf(Order $order)
    {
        $order = $this->orderRepository->showOrder($order);
        $total = new \stdClass();
        $total->totalPrice = 0;
        $total->totalFinalPrice = 0;
        $total->totalQuantity = 0;
        foreach ($order->orderItems as $eachOrder){
            $total->totalPrice += $eachOrder->product_price;
            $total->totalFinalPrice += $eachOrder->product_price * $eachOrder->quantity;
            $total->totalQuantity += $eachOrder->quantity;
        }


        $payment = new \stdClass();
        $payment->successfulPaymentAmout = 0;
        foreach ($order->payments as $payment) {
            if ($payment->res_code === 0){
                $payment->successfulPaymentAmout = $payment->total_order_price;
            }
        }

        $html = view("admin.orders.order-pdf",compact('order','total','payment'));

        $pdf = new Pdf($html);

        return response()->make(
            $pdf->render(),
            200,
            [
                'content-type' => 'application/pdf'
            ]
        );
    }

    public function getFiltersValues()
    {
        return response()->json(
            $this->orderRepository->getFiltersValues(),
            200
        );
    }
}
