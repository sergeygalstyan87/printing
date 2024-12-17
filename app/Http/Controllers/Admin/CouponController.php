<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $attributeService = null;

    public function __construct( CouponService $attributeService )
    {
        $this->attributeService = $attributeService;
    }

    public function index()
    {
        $items = $this->attributeService->getItems();
        return view('dashboard.pages.coupons.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.coupons.form');
    }

    public function store(CouponRequest $request)
    {
        $this->attributeService->create($request->except('_token'));
        return redirect()->route('dashboard.coupons.index');
    }

    public function edit($id)
    {
        $item = $this->attributeService->getItem($id);
        return view('dashboard.pages.coupons.form', compact(['item']));
    }

    public function update(CouponRequest $request, $id)
    {
        $this->attributeService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.coupons.index');
    }

    public function delete($id)
    {
        $this->attributeService->delete($id);
        return redirect()->route('dashboard.coupons.index')->with('success', 'Coupon deleted successfully');
    }
}
