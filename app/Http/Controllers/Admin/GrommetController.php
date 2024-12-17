<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GrommetRequest;
use App\Services\GrommetService;
use Illuminate\Http\Request;

class GrommetController extends Controller
{
    protected $attributeService = null;

    public function __construct( GrommetService $attributeService )
    {
        $this->attributeService = $attributeService;
    }

    public function index()
    {
        $items = $this->attributeService->getItems();
        return view('dashboard.pages.grommets.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.grommets.form');
    }

    public function store(GrommetRequest $request)
    {
        $this->attributeService->create($request->except('_token'));
        return redirect()->route('dashboard.grommets.index');
    }

    public function edit($id)
    {
        $item = $this->attributeService->getItem($id);
        return view('dashboard.pages.grommets.form', compact(['item']));
    }

    public function update(GrommetRequest $request, $id)
    {
        $this->attributeService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.grommets.index');
    }

    public function delete($id)
    {
        $this->attributeService->delete($id);
        return redirect()->route('dashboard.grommets.index')->with('success', 'Grommet deleted successfully');
    }
}
