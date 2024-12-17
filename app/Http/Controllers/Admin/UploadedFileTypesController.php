<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UploadedFileType;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\UploadedFileTypesService;
use Illuminate\Http\Request;

class UploadedFileTypesController extends Controller
{
    protected $uploadedFileTypesService = null;

    public function __construct(
        UploadedFileTypesService $uploadedFileTypesService
    )
    {
        $this->uploadedFileTypesService = $uploadedFileTypesService;
    }

    public function index()
    {
        $items = $this->uploadedFileTypesService->getItems();
        return view('dashboard.pages.uploadedFileTypes.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.uploadedFileTypes.form');
    }

    public function store(Request $request)
    {
        $this->uploadedFileTypesService->create($request->except('_token'));
        return redirect()->route('dashboard.uploadedFileTypes.index')->with('success', 'Uploaded File Type created successfully');
    }

    public function edit($id)
    {
        $item = $this->uploadedFileTypesService->getItem($id);
        return view('dashboard.pages.uploadedFileTypes.form', compact(['item']));
    }

    public function update(Request $request, $id)
    {
        $this->uploadedFileTypesService->update($request->except('_token'), $id);
        return redirect()->route('dashboard.uploadedFileTypes.index')->with('success', 'Uploaded File Type updated successfully');
    }

    public function delete($id)
    {
        $this->uploadedFileTypesService->delete($id);
        return redirect()->route('dashboard.uploadedFileTypes.index')->with('success', 'Uploaded File Type deleted successfully');
    }
}
