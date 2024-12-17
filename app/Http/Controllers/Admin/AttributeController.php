<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttributeRequest;
use App\Services\AttributeService;

class AttributeController extends Controller
{
    protected $attributeService = null;

    public function __construct( AttributeService $attributeService )
    {
        $this->attributeService = $attributeService;
    }

    public function index()
    {
        $items = $this->attributeService->getItems();
        return view('dashboard.pages.attributes.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.attributes.form');
    }

    public function store(AttributeRequest $request)
    {
        $this->attributeService->create($request->except('_token'));
        return redirect()->route('dashboard.attributes.index');
    }

    public function edit($id)
    {
        $item = $this->attributeService->getItem($id);
        return view('dashboard.pages.attributes.form', compact(['item']));
    }

    public function update(AttributeRequest $request, $id)
    {
        $this->attributeService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.attributes.index');
    }

    public function delete($id)
    {
        $this->attributeService->delete($id);
        return redirect()->route('dashboard.attributes.index')->with('success', 'Attribute deleted successfully');
    }
}
