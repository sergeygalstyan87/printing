<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AlertRequest;
use App\Services\AlertService;
use Illuminate\Http\Request;

class AlertsController extends Controller
{
    protected $alertService = null;

    public function __construct( AlertService $alertService )
    {
        $this->alertService = $alertService;
    }

    public function index()
    {
        $items = $this->alertService->getItems();
        return view('dashboard.pages.alerts.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.alerts.form');
    }

    public function store(AlertRequest $request)
    {

        $this->alertService->create($request->except('_token'));
        return redirect()->route('dashboard.alerts.index');
    }

    public function edit($id)
    {
        $item = $this->alertService->getItem($id);
        return view('dashboard.pages.alerts.form', compact(['item']));
    }

    public function update(AlertRequest $request, $id)
    {
        $this->alertService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.alerts.index');
    }

    public function delete($id)
    {
        $this->alertService->delete($id);
        return redirect()->route('dashboard.alerts.index')->with('success', 'Alert deleted successfully');
    }
}
