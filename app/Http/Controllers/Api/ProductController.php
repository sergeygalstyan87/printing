<?php

namespace App\Http\Controllers\Api;

use App\Enums\AttributeProperties;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImagesByType;
use App\Services\AttributeService;
use App\Services\CategoryService;
use App\Services\DeliveryService;
use App\Services\ProductService;
use App\Services\ProjectService;
use App\Services\TypeService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productService = null;
    protected $attributeService = null;
    protected $projectService = null;

    public function __construct(
        ProductService $productService,
        AttributeService $attributeService,
        ProjectService $projectService
    )
    {
        $this->productService = $productService;
        $this->attributeService = $attributeService;
        $this->projectService = $projectService;
    }


    public function getProductDetails(Request $request, $product_id)
    {
        $project_id = $request->project_id;
        $product = $this->productService->getItem($product_id);
        $project = $this->projectService->getItem($project_id);

        $product_fields = Product::select('id', 'title', 'short_desc')
            ->find($product_id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }

        $attributes = $product->getInformation()['types'];
        $selected_values = $project->attrs['selected_values'];

        $colors = [];
        $images = [];
        $coordinates = [];
        $print_side = [];
        $uploaded_file_type_id = [];

        foreach ($attributes as $attribute_id => $value) {
            $attribute = $this->attributeService->getItem($attribute_id);
            if ($attribute && $attribute->attribute_properties && in_array(AttributeProperties::print_side, $attribute->attribute_properties)) {
                if(in_array( AttributeProperties::print_side, $attribute->attribute_properties)){
                    foreach ($value as $type_id => $item) {
                        if (in_array($type_id, $selected_values)){
                            $print_side[] = [
                                'id' => $type_id,
                                'name' => $item['name'],
                                'uploaded_file_type_id' => isset($item['uploadedFileTypeIds']) ? $item['uploadedFileTypeIds'][0] : null,
                            ];

                            if(isset($item['uploadedFileTypeIds'])){
                                $uploaded_file_type_id[] =$item['uploadedFileTypeIds'][0];
                            }
                        }
                    }
                }
            }
        }

        foreach ($attributes as $attribute_id => $value) {
            $attribute = $this->attributeService->getItem($attribute_id);

            if ($attribute && $attribute->attribute_properties && in_array(AttributeProperties::is_show_on_upload, $attribute->attribute_properties)) {
                if (in_array(AttributeProperties::color, $attribute->attribute_properties)) {
                    foreach ($value as $type_id => $item) {
                        $image['id'] = $type_id;
                        $image['hex'] = $item['color_hex'];

                        $productImagesByTypes = ProductImagesByType::with('uploadedFileType')
                            ->where('type_id', $type_id)
                            ->where('product_id', $product_id)
                            ->get()
                            ->groupBy('uploaded_file_types_id');


                        foreach ($productImagesByTypes as $type) {
                            $type = $type[0];
                            $disk = Storage::disk('product_images_by_type');
                            $filePath = $type->image;
                            $fullPath = $disk->path($filePath);

                            if (in_array($type->uploaded_file_types_id, $uploaded_file_type_id)) {
                                $image[$type->uploaded_file_types_id] = [
                                    'id' => $type->uploaded_file_types_id,
                                    'name' => $type->uploadedFileType->title,
                                    'filename' => $type->image,
                                    'mimeType' => mime_content_type($fullPath),
                                    'filesize' => filesize($fullPath),
                                    'createdAt' => (new DateTime($type->created_at))->format('Y-m-d\TH:i:s.v\Z'),
                                    'updatedAt' => (new DateTime($type->updated_at))->format('Y-m-d\TH:i:s.v\Z'),
                                    'url' => asset('storage/content/product_images_by_type/' . $type->image),
                                    'width' => $type->width,
                                    'height' => $type->height,
                                    'top' => $type->top,
                                    'left' => $type->left,

                                ];
                            }
                        }

                        $images[] = $image;

                    }
                }
            }
        }

//            if($attribute && $attribute->attribute_properties && in_array( AttributeProperties::is_show_on_upload, $attribute->attribute_properties)){
//                if(in_array( AttributeProperties::color, $attribute->attribute_properties)){
//                    foreach ($value as $type_id => $item){
//
//                        $productImagesByTypes = ProductImagesByType::with('uploadedFileType')
//                            ->where('type_id', $type_id)
//                            ->where('product_id', $product_id)
//                            ->get()
//                            ->groupBy('uploaded_file_types_id')
//                            ->map(function ($group) {
//                                $firstItem = $group->first();
//                                return [
//                                    'id' => $firstItem->uploaded_file_types_id,
//                                    'uploaded_file_type_name' => $firstItem->uploadedFileType->title ?? null,
//                                    'image' => $firstItem->image
//                                        ? asset('storage/content/product_images_by_type/' . $firstItem->image)
//                                        : null,
//                                    'width' => $firstItem->width ?? null,
//                                    'height' => $firstItem->height ?? null,
//                                    'top' => $firstItem->top ?? null,
//                                    'left' => $firstItem->left ?? null,
//                                ];
//                            });
//
//                        $colors[] = [
//                            'id' => $type_id,
//                            'name'  => $item['name'],
//                            'hex'  => $item['color_hex'],
//                            'images'  => $productImagesByTypes,
//                        ];
//
//                        foreach ($productImagesByTypes as $uploaded_file_types_id => $group) {
//
//                            $coordinates[$type_id][] = [
//                                'type_id' => $type_id,
//                                'uploaded_file_type_id' => $group['id'] ?? null,
//                                'width' => $group['width'] ?? null,
//                                'height' => $group['height'] ?? null,
//                                'top' => $group['top'] ?? null,
//                                'left' => $group['left'] ?? null,
//                            ];
//                        }
//                    }
//                }
//            }
//            if($attribute && $attribute->attribute_properties && in_array( AttributeProperties::print_side, $attribute->attribute_properties)){
//                if(in_array( AttributeProperties::print_side, $attribute->attribute_properties)){
//                    foreach ($value as $type_id => $item){
//                        $print_side[] = [
//                            'id' => $type_id,
//                            'name'  => $item['name'],
//                            'uploaded_file_type_id'  => isset($item['uploadedFileTypeIds']) ? $item['uploadedFileTypeIds'][0] : null,
//                        ];
//                    }
//                }
//            }
//        }

        $response = array_merge(
            [
                'success' => true,
                'images' => $images,
//                'colors' => $colors,
                'print_side' => $print_side,
//                'coordinates' => $coordinates,
            ],
            $product_fields ? $product_fields->toArray() : [],
        );

        return response()->json($response);
    }
}
