<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReviewRequest;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $reviewService = null;

    public function __construct( ReviewService $reviewService )
    {
        $this->reviewService = $reviewService;
    }

    public function index()
    {
        $items = $this->reviewService->getItems();
        return view('dashboard.pages.reviews.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.reviews.form');
    }

    public function store(ReviewRequest $request)
    {
        $this->reviewService->create($request->except('_token'));
        return redirect()->route('dashboard.reviews.index');
    }

    public function edit($id)
    {
        $item = $this->reviewService->getItem($id);
        return view('dashboard.pages.reviews.form', compact(['item']));
    }

    public function update(ReviewRequest $request, $id)
    {
        $this->reviewService->update($request->except('_token'), $id);

        return redirect()->back();
    }

    public function delete($id)
    {
        $this->reviewService->delete($id);
        return redirect()->route('dashboard.reviews.index')->with('success', 'Review deleted successfully');
    }
}
