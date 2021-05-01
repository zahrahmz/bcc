<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Site\Order\CreateOrderRequest;
use App\Models\Shipment;
use App\Repositories\Site\AddressRepository;
use App\Repositories\Site\CartRepository;
use App\Repositories\Site\OrderRepository;
use App\Repositories\Site\ShipmentRepository;
use App\Services\Site\OrderService;
use App\Services\Site\PaymentService;

class OrderController extends BaseController
{
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * @var CartRepository
     */
    private $cartRepository;
    /**
     * @var ShipmentRepository
     */
    private $shipmentRepository;
    /**
     * @var AddressRepository
     */
    private $addressRepository;
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var PaymentService
     */
    private $paymentService;

    public function __construct(
        OrderService $orderService,
        CartRepository $cartRepository,
        ShipmentRepository $shipmentRepository,
        AddressRepository $addressRepository,
        OrderRepository $orderRepository,
        PaymentService $paymentService
    ) {
        $this->orderService = $orderService;
        $this->cartRepository = $cartRepository;
        $this->addressRepository = $addressRepository;
        $this->shipmentRepository = $shipmentRepository;
        $this->orderRepository = $orderRepository;
        $this->paymentService = $paymentService;
    }

    public function createOrderAndGoToGateway(CreateOrderRequest $request)
    {
        $cartData = $this->cartRepository->show();

        if (empty($cartData['cartId'])) {
            return back()->withErrors([]);
        }

        //check user doesn't have any out of stock product in cart
        if (!$this->orderService->checkOrderHasEnoughEntity($cartData['listOfProducts'])) {
            return back()->withErrors([
                'product_entity' => [trans('validation.remove_out_of_stack')]
            ]);
        }

        $addressData = $this->getAddressData($request);
        $shipmentData = $this->getShipmentData($request);

        $payment = $this->orderService->createOrderAndGetInitialPaymentData($cartData, $addressData, $shipmentData);
        return $payment->pay()->render();
    }


    private function getAddressData(CreateOrderRequest $request)
    {
        $address_id = $request->get('address_id');
        $addressData = $this->addressRepository->findShipmentById($address_id);
        return $addressData;
    }

    private function getShipmentData(CreateOrderRequest $request): Shipment
    {
        $shipment_id = $request->get('shipment_id');
        $shipmentData = $this->shipmentRepository->findShipmentById($shipment_id);
        return $shipmentData;
    }
}
