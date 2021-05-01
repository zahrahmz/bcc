<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ShipmentRequest;
use App\Models\Shipment;
use App\Repositories\Admin\ShipmentRepository;

class ShipmentController extends BaseController
{
    /**
     * @var ShipmentRepository
     */
    private $shipmentRepository;


    public function __construct(ShipmentRepository $shipmentRepository)
    {
        $this->shipmentRepository = $shipmentRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle(trans('shipments.name'));
        $this->setSideBar('shipments');
        $shipments = $this->shipmentRepository->list(true);
        return view('admin.shipments.index', compact('shipments'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle(trans('shipments.create_shipment'));
        $this->setSideBar('shipments');
        $shipments = $this->shipmentRepository->all();
        return view('admin.shipments.create', compact('shipments'));
    }


    public function store(ShipmentRequest $request)
    {
        $this->shipmentRepository->createShipment($request->all());
        return redirect()->route('admin.shipments.index')->with('message', trans('shipments.shipment_updated_successfully'));
    }


    public function edit(Shipment $shipment)
    {
        $this->setPageTitle(trans('shipments.edit_shipment'));
        $this->setSideBar('shipments');
        return view('admin.shipments.edit', compact('shipment'));
    }


    public function update(ShipmentRequest $request, Shipment $shipment)
    {
        $this->setPageTitle(trans('shipments.name'));
        $this->setSideBar('shipments');
        $this->shipmentRepository->updateShipment($request->all(), $shipment);
        return redirect()->route('admin.shipments.index')
            ->with('message', trans('shipments.shipment_updated_successfully'));
    }



    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return redirect()->route('admin.shipments.index', $shipment->id)->with('message', trans('shipments.shipment_removed_successfully'));
    }
}
