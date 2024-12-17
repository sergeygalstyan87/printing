<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Services\BannerService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected $bannerService = null;

    public function __construct( BannerService $bannerService )
    {
        $this->bannerService = $bannerService;
    }

    public function index()
    {
        $items = $this->bannerService->getItems();
        return view('dashboard.pages.banners.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.banners.form');
    }

    public function store(BannerRequest $request)
    {
        $this->bannerService->create($request->except('_token'));
        return redirect()->route('dashboard.banners.index');
    }

    public function edit($id)
    {
        $item = $this->bannerService->getItem($id);
        return view('dashboard.pages.banners.form', compact(['item']));
    }

    public function update(BannerRequest $request, $id)
    {
        $this->bannerService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.index');
    }

    public function delete($id)
    {
        $this->bannerService->delete($id);
        return redirect()->route('dashboard.banners.index')->with('success', 'Banner deleted successfully');
    }

    public function image_delete(Request $request)
    {
        $imagePath = $request->get('image');

        $fullPath = public_path('storage/content/' . $imagePath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }
    }
}
