<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\SliderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    protected $productService = null;
    protected $categoryService = null;
    protected $sliderService = null;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService,
        SliderService  $sliderService
    )
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->sliderService = $sliderService;
    }

    public function index($id){
        View::share('breadcrumb', 'Shop');

        $category = $this->categoryService->getItem($id);
        $sliders = $this->sliderService->getItemsWithCategory($id);
        $slidersMobile = $this->sliderService->getItemsWithCategoryMobile($id);
        $slidersTablet = $this->sliderService->getItemsWithCategoryTablet($id);
        $products = $this->productService->getByCategory($id);
        $count = $this->productService->getCategoryCount($id);

        return view('front.pages.category', compact('products', 'count', 'category', 'sliders', 'slidersMobile', 'slidersTablet'));
    }
}
