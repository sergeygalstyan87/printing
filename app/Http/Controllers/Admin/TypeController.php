<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TypeRequest;
use App\Models\Product;
use App\Models\ProductImagesByType;
use App\Models\Type;
use App\Services\AttributeService;
use App\Services\SizeService;
use App\Services\TypeService;
use App\Services\UploadedFileTypesService;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    protected $typeService = null;
    protected $attributeService = null;
    protected $uploadedFileTypesService = null;

    public function __construct(
        TypeService $typeService,
        AttributeService $attributeService,
        SizeService $sizeService,
        UploadedFileTypesService $uploadedFileTypesService
    )
    {
        $this->typeService = $typeService;
        $this->attributeService = $attributeService;
        $this->sizeService = $sizeService;
        $this->uploadedFileTypesService = $uploadedFileTypesService;
    }

    public function index()
    {
        $items = $this->typeService->getItems();
        return view('dashboard.pages.types.index', compact('items'));
    }

    public function add()
    {
        $attributes = $this->attributeService->getItems();
        $sizes = $this->sizeService->getCoreItems();
        $all_sizes = $this->sizeService->getItems();
        $uploadedFileTypes = $this->uploadedFileTypesService->getItems();

        return view('dashboard.pages.types.form', compact(['attributes','sizes','all_sizes', 'uploadedFileTypes']));
    }

    public function store(TypeRequest $request)
    {
        $this->typeService->create($request->except('_token'));
        return redirect()->route('dashboard.types.index');
    }

    public function edit($id)
    {

        $sizes = $this->sizeService->getCoreItems();
        $all_sizes = $this->sizeService->getItems();
        $item = $this->typeService->getItem($id);
        $attributes = $this->attributeService->getItems();
        $uploadedFileTypes = $this->uploadedFileTypesService->getItems();
        $products = Product::all();
        $product_images_by_type = ProductImagesByType::where('type_id', $id)->get()->groupBy('product_id');

        return view('dashboard.pages.types.form', compact(['item', 'attributes','sizes','all_sizes', 'uploadedFileTypes', 'products', 'product_images_by_type']));
    }

    public function update(TypeRequest $request, $id)
    {

        $this->typeService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.types.index');
    }

    public function delete($id)
    {
        $this->typeService->delete($id);
        return redirect()->route('dashboard.types.index')->with('success', 'Type deleted successfully');
    }

    public function single($id){
        $items = $this->typeService->getByAttribute($id);
        return view('dashboard.pages.types.index', compact('items'));
    }

    public  function storeProductImagesByType(Request $request, $id)
    {
        $product_id = $request->product_id;
        $data = $request->except(['_token', 'product_id']);

        $productImagesByTypes = ProductImagesByType::where('type_id', $id)
            ->where('product_id', $product_id)
            ->get()
            ->pluck('uploaded_file_types_id')
            ->toArray();

        $uploaded_file_types_id_from_request = array_keys($data);

        if($productImagesByTypes){
            $removed_ids = array_diff($productImagesByTypes, $uploaded_file_types_id_from_request);

            if(!empty($removed_ids)){
                foreach ($removed_ids as $removed_id){
                    $productImage = ProductImagesByType::where('uploaded_file_types_id', $removed_id)->first();

                    if ($productImage) {
                        $productImage->delete();
                    }
                }
            }
        }

        foreach ($data as $key => $value) {
            if($value){
                $imagePath = null;
                if($value['image']){
                    $imagePath = upload_product_images_by_type($value['image']);
                    $productImagesByType = ProductImagesByType::where('type_id', $id)
                        ->where('product_id', $product_id)
                        ->where('uploaded_file_types_id', $key)
                        ->first();

                    if($productImagesByType){
                        $productImagesByType->delete();
                    }
                }

                $dataToUpdate = [
                    'width' => $value['width'],
                    'height' => $value['height'],
                    'top' => $value['top'],
                    'left' => $value['left'],
                ];

                if (!empty($imagePath)) {
                    $dataToUpdate['image'] = $imagePath;
                }

                ProductImagesByType::updateOrCreate(
                    [
                        'product_id' => $product_id,
                        'type_id' => $id,
                        'uploaded_file_types_id' => $key,
                    ],
                    $dataToUpdate
                );
            }
        }
    }
}
