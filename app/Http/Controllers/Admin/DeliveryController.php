<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryRequest;
use App\Services\DeliveryService;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    protected $deliveryService = null;

    public function __construct( DeliveryService $deliveryService )
    {
        $this->deliveryService = $deliveryService;
    }

    public function index()
    {
        $items = $this->deliveryService->getItems();
        return view('dashboard.pages.deliveries.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.deliveries.form');
    }

    public function store(DeliveryRequest $request)
    {
        $this->deliveryService->create($request->except('_token'));
        return redirect()->route('dashboard.deliveries.index');
    }

    public function edit($id)
    {
        $item = $this->deliveryService->getItem($id);
        return view('dashboard.pages.deliveries.form', compact(['item']));
    }

    public function update(DeliveryRequest $request, $id)
    {
        $this->deliveryService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.deliveries.index');
    }

    public function delete($id)
    {
        $this->deliveryService->delete($id);
        return redirect()->route('dashboard.deliveries.index')->with('success', 'Delivery deleted successfully');
    }
}
