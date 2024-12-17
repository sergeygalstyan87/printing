<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $sliderService = null;

    public function __construct( SliderService $sliderService )
    {
        $this->sliderService = $sliderService;
    }

    public function index()
    {
        $items = $this->sliderService->getItems();
        return view('dashboard.pages.sliders.index', compact('items'));
    }

    public function add()
    {
        $categories = (new CategoryService)->getParents();
        return view('dashboard.pages.sliders.form', compact(['categories']));
    }

    public function store(SliderRequest $request)
    {
        $this->sliderService->create($request->except('_token'));
        return redirect()->route('dashboard.sliders.index');
    }

    public function edit($id)
    {
        $item = $this->sliderService->getItem($id);
        $categories = (new CategoryService)->getParents();
        return view('dashboard.pages.sliders.form', compact(['item', 'categories']));
    }

    public function update(SliderRequest $request, $id)
    {
        $this->sliderService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.sliders.index');
    }

    public function delete($id)
    {
        $this->sliderService->delete($id);
        return redirect()->route('dashboard.sliders.index')->with('success', 'Slider deleted successfully');
    }
}
