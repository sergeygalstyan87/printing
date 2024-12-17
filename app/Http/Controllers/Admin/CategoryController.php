<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Services\CategoryService;
use App\Services\ProductService;

class CategoryController extends Controller
{

    protected $categoryService = null;
    protected $productService = null;

    public function __construct(
        CategoryService $categoryService,
        ProductService $productService
    )
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    public function index()
    {
        $items = $this->categoryService->getParents();
        return view('dashboard.pages.categories.index', compact('items'));
    }

    public function subcategories()
    {
        $items = $this->categoryService->getSubcategories();
        return view('dashboard.pages.categories.index', compact('items'));
    }

    public function add()
    {
        $categories = $this->categoryService->getParents();
        return view('dashboard.pages.categories.form', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryService->create($request->except('_token'));
        return redirect()->route('dashboard.categories.index');
    }

    public function edit($id)
    {
        $categories = $this->categoryService->getParents();
        $item = $this->categoryService->getItem($id);
        $products = $this->productService->getByCategoryAll($id);
        return view('dashboard.pages.categories.form', compact(['item', 'categories', 'products']));
    }

    public function update(CategoryRequest $request, $id)
    {
        $this->categoryService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.categories.index');
    }

    public function delete($id)
    {
        $this->categoryService->delete($id);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully');
    }
}
