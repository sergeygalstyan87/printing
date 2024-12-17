<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService = null;

    public function __construct( SettingService $settingService )
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $items = $this->settingService->getItems();
        return view('dashboard.pages.settings.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.settings.form');
    }

    public function store(SettingRequest $request)
    {
        $this->settingService->create($request->except('_token'));
        return redirect()->route('dashboard.settings.index');
    }

    public function edit($id)
    {
        $item = $this->settingService->getItem($id);
        return view('dashboard.pages.settings.form', compact(['item']));
    }

    public function update(SettingRequest $request, $id)
    {
        $this->settingService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.settings.index');
    }

    public function delete($id)
    {
        $this->settingService->delete($id);
        return redirect()->route('dashboard.settings.index')->with('success', 'Setting deleted successfully');
    }
}
