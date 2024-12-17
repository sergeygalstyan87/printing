<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SizeRequest;
use App\Services\SizeService;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    protected $sizeService = null;

    public function __construct( SizeService $sizeService )
    {
        $this->sizeService = $sizeService;
    }

    public function index()
    {
        $items = $this->sizeService->getItems();
        return view('dashboard.pages.sizes.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.sizes.form');
    }

    public function store(SizeRequest $request)
    {
        $this->sizeService->create($request->except('_token'));
        return redirect()->route('dashboard.sizes.index');
    }

    public function edit($id)
    {
        $item = $this->sizeService->getItem($id);
        return view('dashboard.pages.sizes.form', compact(['item']));
    }

    public function update(SizeRequest $request, $id)
    {
        $this->sizeService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.sizes.index');
    }

    public function delete($id)
    {
        $this->sizeService->delete($id);
        return redirect()->route('dashboard.sizes.index')->with('success', 'Size deleted successfully');
    }
}
