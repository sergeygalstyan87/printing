<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuantityRequest;
use App\Services\QuantityService;
use Illuminate\Http\Request;

class QuantityController extends Controller
{
    protected $attributeService = null;

    public function __construct( QuantityService $attributeService )
    {
        $this->attributeService = $attributeService;
    }

    public function index()
    {
        $items = $this->attributeService->getItems();
        return view('dashboard.pages.quantities.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.quantities.form');
    }

    public function store(QuantityRequest $request)
    {
        $this->attributeService->create($request->except('_token'));
        return redirect()->route('dashboard.quantities.index');
    }

    public function edit($id)
    {
        $item = $this->attributeService->getItem($id);
        return view('dashboard.pages.quantities.form', compact(['item']));
    }

    public function update(QuantityRequest $request, $id)
    {
        $this->attributeService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.quantities.index');
    }

    public function delete($id)
    {
        $this->attributeService->delete($id);
        return redirect()->route('dashboard.quantities.index')->with('success', 'Quantity deleted successfully');
    }
}
