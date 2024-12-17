<?php

namespace App\Http\Controllers\Front;

use App\Enums\AttributeProperties;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImagesByType;
use App\Models\Set;
use App\Models\Size;
use App\Models\Type;
use App\Models\UploadedFileType;
use App\Services\AttributeService;
use App\Services\CategoryService;
use App\Services\DeliveryService;
use App\Services\ProductService;
use App\Services\ProjectService;
use App\Services\TypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class ProductController extends Controller
{
    protected $productService = null;
    protected $categoryService = null;
    protected $deliveryService = null;
    protected $typeService = null;
    protected $attributeService = null;
    protected $projectService = null;
    public function __construct(
        ProductService $productService,
        TypeService $typeService,
        DeliveryService $deliveryService,
        CategoryService $categoryService,
        AttributeService $attributeService,
        ProjectService $projectService
    )
    {
        $this->productService = $productService;
        $this->typeService = $typeService;
        $this->deliveryService = $deliveryService;
        $this->categoryService = $categoryService;
        $this->attributeService = $attributeService;
        $this->projectService = $projectService;
    }

    public function index(Request $request, $slug){
        $project = null;
        if($request->has('project_id')){
            $project_id = $request->project_id;
            $cookie = request()->cookie('basket_id');
            $project = $this->projectService->getItem($project_id);
            $basket = $project->basket[0];

            if ((Auth::user() && (Auth::user()->id != $basket->user_id)) || ($cookie && ($basket->id !=  request()->cookie('basket_id')))
                || (!Auth::user() && !$cookie)
            ){
                return redirect()->route('product', $slug);
            }
        }

        View::share('breadcrumb', 'Shop');

        $product = $this->productService->getBySlug($slug);
        $related_products = $this->productService->getRelated($product, 6);
        $deliveries = $this->deliveryService->getItems();
        $product_information = $product->getInformation();
        if(!empty($product_information) && !empty($product_information['types'])){
            foreach($product_information['types'] as $attrs){
                foreach($attrs as $a){
                    $ids[] = $a['id'];
                }
            }
        }
        $attr_ids = array_keys($product_information['types']);

        $a_ids = implode(',',$attr_ids);
        $types = $this->typeService->getByIds($ids);
        $sql = "select name, id, is_crude, description, help_text,is_apparel,is_multiple,attribute_properties from attributes where id IN ({$a_ids})";
        $connected_attributes = DB::select($sql);
        $apparel_product = false;
        foreach($attr_ids as $k=>$m){
            foreach($connected_attributes as $val){
                if( $val->is_apparel == 1){
                    $apparel_product = true;
                }
                if($val->id == $m){
                    $con_a[$m] = [
                        'name' => $val->name,
                        'is_paper_type' => $val->is_crude,
                        'description' => $val->description,
                        'help_text' => $val->help_text,
                        'is_apparel' => $val->is_apparel,
                        'is_multiple' => $val->is_multiple,
                        'attribute_properties' => json_decode($val->attribute_properties, true) ?? [],
                    ];
                }
            }
        }

        $sizesObj = Size::all();
        foreach ($sizesObj as $s){
            $i = explode('x',$s->in);
            $sizes[$s->id]['width']=trim($i[0]);
            $sizes[$s->id]['height']=trim($i[1]);
        }

        $product_images_by_type = $product->imagesByType
            ->where('uploaded_file_types_id', 2)
            ->groupBy('type_id')
            ->mapWithKeys(fn($group, $typeId) => [
                $typeId => $group->pluck('image')
                    ->map(fn($image) => asset('storage/content/product_images_by_type/' . $image))
                    ->all()
            ]);

        $default_product_images = collect($product->images)
            ->map(fn($image) => asset('storage/content/' . $image))
            ->all();

        if($apparel_product){
            return view('front.pages.product-shirts', compact('con_a','product', 'types', 'deliveries', 'related_products','product_information','sizes', 'project', 'product_images_by_type', 'default_product_images'));

        }else{
            return view('front.pages.product', compact('con_a','product', 'types', 'deliveries', 'related_products','product_information','sizes', 'project', 'product_images_by_type', 'default_product_images'));

        }
    }

    public function getAttributeHelperText(Request $request, $id)
    {
        $attribute = $this->attributeService->getItem($id);

        return response()->json(['attribute' => $attribute]);
    }

    public function getUploadedFileTypesBySelectedType(Request $request)
    {
        $sets = [];
        $uploadedFiles = [];
        $set_count = 1;
        $product_id = $request->product_id;

        $uploadedFiles = session()->get('uploaded_files.' . $product_id ) ?? [];


        if($request->has('setCount') && $request->setCount){
            $set_count = $request->setCount;
        }

        if($request->has('set_id') && $request->set_id){
            $typeIds = $request->type_ids;
            $sets = Set::whereIn('id', (array) $request->set_id)->get();
            foreach($sets as $set){
                $uploadedFiles[$set->id] = $set->uploaded_files ?? [];
            }
        }

        if($request->has('selected_values') && $request->selected_values){
            $typeIds = $request->selected_values;
        }
        $types = Type::whereIn('id', $typeIds)->get();

        $uploadedFileTypeIds = $types->pluck('uploadedFileTypeIds')
        ->filter()
        ->flatten()
        ->unique()
        ->values();

        $uploadedFileTypes = UploadedFileType::whereIn('id', $uploadedFileTypeIds)->get();
        $uploadedFileTypeTitles = $uploadedFileTypes->pluck('title')->map(fn($title) => strtolower($title))->toArray();

        $filteredUploadedFiles = array_map(function ($fileData) use ($uploadedFileTypeTitles) {
            return array_filter($fileData, function ($type) use ($uploadedFileTypeTitles) {
                return in_array(strtolower($type), $uploadedFileTypeTitles);
            }, ARRAY_FILTER_USE_KEY);
        }, $uploadedFiles);

        $view = view('front.pages.partials.product.upload.modal_body',
            [
                'uploadedFileTypeTitles' => $uploadedFileTypeTitles,
                'sets'=>$sets,
                'set_count'=>$set_count,
            ])->render();

        return response()->json(['view' => $view, 'uploadedFiles'=>$filteredUploadedFiles, 'uploadedFileTypeTitles' => $uploadedFileTypeTitles]);
    }

}
