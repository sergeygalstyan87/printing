<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Admin\ShippingInfoRequest;
use App\Models\Delivery;
use App\Models\Product;
use App\Services\AttributeService;
use App\Services\CategoryService;
use App\Services\GrommetService;
use App\Services\ProductService;
use App\Services\QuantityService;
use App\Services\SizeService;
use App\Services\TypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Gumlet\ImageResize;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productService = null;
    protected $categoryService = null;
    protected $attributeService = null;
    protected $typeService = null;
    protected $quantityService = null;
    protected $sizeService = null;
    protected $grommetService = null;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService,
        AttributeService $attributeService,
        TypeService $typeService,
        QuantityService $quantityService,
        SizeService $sizeService,
        GrommetService $grommetService
    )
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->attributeService = $attributeService;
        $this->typeService = $typeService;
        $this->quantityService = $quantityService;
        $this->sizeService = $sizeService;
        $this->grommetService = $grommetService;
    }

    public function index()
    {
        $items = $this->productService->getItemsWithoutStock();

        return view('dashboard.pages.products.index', compact('items'));
    }

    public function add()
    {
        $categories = $this->categoryService->getParents();
        $all_categories = $this->categoryService->getItems();
        $attributes = $this->attributeService->getItems();
        $types = $this->typeService->getItems();
        $quantities = $this->quantityService->getItems();
        $sizes = $this->sizeService->getItems();
        $grommets = $this->grommetService->getItems();
        $selected_types = [];
        return view('dashboard.pages.products.form', compact(['selected_types','categories', 'attributes', 'types', 'quantities', 'all_categories', 'sizes', 'grommets']));
    }

    public function store(ProductRequest $request)
    {
        $this->productService->create($request->except('_token'));
        return redirect()->route('dashboard.products.index');
    }

    public function edit($id)
    {
        $item = $this->productService->getItem($id);
        $categories = $this->categoryService->getParents();
        $all_categories = $this->categoryService->getItems();
        $attributes = $this->attributeService->getItemsFirst($item->attributes->pluck('id')->toArray());
        $types = $this->typeService->getItemsFirst($item->details->unique('type_id')->pluck('type_id')->toArray());
        $quantities = $this->quantityService->getItemsFirst($item->quantites->unique('quantity_id')->pluck('quantity_id')->toArray());
        $sizes = $this->sizeService->getItems();
        $grommets = $this->grommetService->getItems();
        $selected_types = [];

        if(!empty($item->detail_info)){
            $selected_types = json_decode($item->detail_info,true);
        }

        return view('dashboard.pages.products.form', compact(['item','selected_types', 'categories', 'attributes', 'all_categories', 'types', 'quantities', 'sizes', 'grommets']));
    }

    public function update(ProductRequest $request, $id)
    {
        $this->productService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.products.index');
    }

    public function delete($id)
    {
        $this->productService->delete($id);
        return redirect()->route('dashboard.products.index')->with('success', 'Product deleted successfully');
    }

    public function image_upload(Request $request){
        $urls = [];
        foreach ($request->images as $image){
            $path = upload($image, true);
            $urls[] = asset('storage/content/' . $path);
        }
        return response()->json(['success' => 1, 'images' => json_encode($urls)], 200);
    }

    public function single($id){
        $items = $this->productService->getByCategoryAll($id);
        return view('dashboard.pages.products.index', compact('items'));
    }

    public function change_order(Request $request){
        $this->productService->setOrder($request->all());
        return redirect()->back();
    }

    public function attrs($id){
        $item = $this->productService->getItem($id);
        $categories = $this->categoryService->getParents();
        $all_categories = $this->categoryService->getItems();
        $attributes = $this->attributeService->getItemsFirst($item->attributes->pluck('id')->toArray());
        $types = $this->typeService->getItems();
        $quantities = $this->quantityService->getItems();

        $sizes = $this->sizeService->getItems();
        $grommets = $this->grommetService->getItems();
        $selected_types = [];
        $type_lists = [];
        foreach($types as $t){
            $type_lists[$t->attribute_id][] = [
                'id'=>$t->id,
                'name'=>$t->name,
                'related_attrs'=>(!empty($t->related_attributes)) ? json_decode($t->related_attributes,true):[]
            ];
        }
        $types_list = json_encode($type_lists);
        if(!empty($item->detail_info)){
            $selected_types = json_decode($item->detail_info,true);
        }

        return view('dashboard.pages.products.attrs', compact(['item','selected_types', 'categories', 'attributes', 'all_categories', 'types', 'quantities', 'sizes', 'grommets','types_list']));

    }

    public function editShippingSizes(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'shipping_info.*.id' => 'required|numeric',
            'shipping_info.*.until_pcs' => 'required|numeric',
            'shipping_info.*.width' => 'required|numeric',
            'shipping_info.*.height' => 'required|numeric',
            'shipping_info.*.length' => 'required|numeric',
            'shipping_info.*.weight' => 'required|numeric',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $validated = $request->input();


        $item = Product::findOrFail($id);
        $shippingData = $validated['shipping_info'];

        $item->shipping_info = json_encode($shippingData);
        $item->save();

        return response()->json(['message' => 'Shipping info saved.']);
    }

    public function deleteShippingSizes(Request $request)
    {
        $product = Product::findOrFail($request->input('product_id'));

        $shippingInfo = json_decode($product->shipping_info, true);

        foreach ($shippingInfo as $key => $item) {

            if (isset($item['id']) && $item['id'] === $request->input('id')) {
                unset($shippingInfo[$key]);
            }
        }

        $product->shipping_info = json_encode(array_values($shippingInfo));

        $product->save();
        return response()->json(['message' => 'Shipping info deleted.']);

    }

    public function editAttrs(Request $request, $id){
        if(!empty($request->get('empty_data'))){
            $rel_data = $request->get('related_types');
            if(empty($rel_data)){
                $sql = "update products set hidden_types = null where id={$id}";
            }else{
                $saved_info = [];
                foreach($rel_data as $key=>$val){
                    if(!isset($saved_info[$val['id']])){
                        $saved_info[$val['id']] = [];
                    }
                    $saved_info[$val['id']][] = $val['hidden_id'];
                }
                $d = json_encode($saved_info,JSON_UNESCAPED_SLASHES);
                $sql = "update products set hidden_types = '{$d}' where id={$id}";
            }
            DB::update($sql);
            return true;
        }
        if(!empty($request->get('custom_sizes'))){
            $c = $request->get('custom_sizes');
            if($c == 2){
                $c = 0;
            }
            $sql = "update products set custom_sizes = {$c}, size_type=null where id={$id}";
            DB::insert($sql);
            return true;
        }

        if(!empty($request->get('custom_info'))){
            $c = $request->get('custom_info');
            $only_custom = $c['only_custom'] == 'false'? 0:1;
            if(!empty($c['discounts'])){
                $discounts = [];
                foreach($c['discounts'] as $k=>$v){
                    $l = $v['over'];
                    $discounts[$l] = $v['percent'];
                }
                $d = json_encode($discounts,JSON_UNESCAPED_SLASHES);
                $disc =  "square_discounts = '{$d}'";
            }else{
                $disc = "square_discounts = null ";
            }

            $sql = "update products set only_custom = {$only_custom}, max_width = {$c['max_width']},max_height = {$c['max_height']},default_width = {$c['default_width']},default_height = {$c['default_height']}, size_type = '{$c['size_type']}', {$disc} where id={$id}";
            DB::insert($sql);
            return true;
        }

        $fields = $request->get('fields');
        if(!empty($fields)){
            foreach($fields as $key=>$val){
                if(empty($val)){
                    unset($fields[$key]);
                }
            }

            uksort($fields, function ($a, $b) use ($fields) {
                return $fields[$a]['value'] <=> $fields[$b]['value'];
            });

            if(!empty($fields)){
                $ff = json_encode($fields);
                $sql = "update products set quantity_discount = '{$ff}' where id={$id}";
                DB::insert($sql);
                return true;
            }
        }

        $attrs = $request->get('attrs');
        if(!empty($attrs)){
           $ins = [];
            foreach($attrs as $key=>$val){
                $ins[$val['id']] = $val['types'];
            }
                $ff = json_encode($ins);
                $sql = "update products set detail_info = '{$ff}' where id={$id}";
                DB::insert($sql);
                return true;

        }

    }
    public function relAttrs($id){
        $item = $this->productService->getItem($id);

        $attributes = $this->attributeService->getItemsFirst($item->attributes->pluck('id')->toArray());
        $types = $this->typeService->getItems();

        $selected_types = [];
        $type_lists = [];

        if(!empty($item->detail_info)){
            $selected_types = json_decode($item->detail_info,true);
        }
        $type_names = [];
        foreach($selected_types as $t){
            $type_names = array_merge($type_names,array_values($t));
        }
        foreach($types as $t){
            foreach($type_names as $val){
                if($val == $t->id){
                    $type_lists[] = [
                        'id'=>$t->id,
                        'name'=>$t->name. ' ('.$t->attribute->name.')',
                    ];
                    break;
                }

            }
        }

        if(!empty($item->quantity_discount)){
            $i = json_decode($item->quantity_discount,true);
            foreach($i as $k=>$v){
                $type_lists[] = [
                    'id'=>'qty-'.$k,
                    'name'=>$v['value']. ' (Quantity)',
                ];
            }
        }

        $type_lists = json_encode($type_lists);
        $hidden_types = [];
        if(!empty($item->hidden_types)){
            $hidden_types = json_decode($item->hidden_types,true);
        }
        return view('dashboard.pages.products.rel-attrs', compact(['item','type_lists','selected_types','attributes','types','hidden_types']));

    }

    public function image_delete(Request $request)
    {
        $imagePath = $request->get('image');
        $fullPath = public_path('/storage/content/' . $imagePath);
        $fullPathSmall = public_path('storage/content/small-images/'.$imagePath);

        if (file_exists($fullPathSmall)) {
            unlink($fullPathSmall);
        }

        if (file_exists($fullPath)) {
            unlink($fullPath);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }
    }

    public function productionTimeIndex()
    {
        $products = $this->productService->getItemsWithoutStock();

        return view('dashboard.pages.products.product_deliveries', compact('products'));
    }
    public function getProductionTime(Request $request)
    {
        $product_id = $request->product_id;
        $item = $this->productService->getItem($product_id);

        $view = view('dashboard.pages.products.partials.product_deliveries_form', compact('item'));

        return response()->json(['html' => $view->render()]);
    }
    public function productionTimeStore(Request $request)
    {
        $product_id = $request->product_id;

        $existingDeliveries = Delivery::where('product_id', $product_id)->pluck('id')->toArray();
        $incomingDeliveryIds = collect($request->delivery)->pluck('id')->filter()->unique()->toArray();
        $deliveriesToDelete = array_diff($existingDeliveries, $incomingDeliveryIds);
        Delivery::whereIn('id', $deliveriesToDelete)->update([
            'isActive' => 0
        ]);

        if ($request->has('delivery')) {
            $data = $request->delivery;
            foreach ($data as $delivery) {
                $delivery['product_id'] = $product_id;

                if (isset($delivery['is_over']) && $delivery['is_over']) {
                    $delivery['is_over'] = $delivery['is_over'] === 'on' ? 1 : 0;
                }else{
                    $delivery['is_over'] = 0;
                }

                if (isset($delivery['id']) && $delivery['id']) {
                    Delivery::where('id', $delivery['id'])
                        ->update($delivery);
                } else {
                    Delivery::create($delivery);
                }
            }
        }

        return redirect()->route('dashboard.products.index');
    }

    public function productTemplates(){
        $products = $this->productService->getItemsWithoutStock();

        return view('dashboard.pages.products.templates.index', compact('products'));
    }

    public function getProductTemplates(Request $request)
    {
        $product_id = $request->product_id;
        $item = $this->productService->getItem($product_id);

        $view = view('dashboard.pages.products.templates.form', compact('item'));

        return response()->json(['html' => $view->render()]);
    }

    public function ProductTemplatesStore(Request $request)
    {
        Log::info('request');
        Log::info(json_encode($request->all(), JSON_PRETTY_PRINT));

        $product_id = $request->product_id;
        $templateDetails = $request->template_details;

        $product = $this->productService->getItem($product_id);
        $existingTemplateDetails = $product->template_details ?? [];

        // Delete files from filesystem that are not in the new request
        foreach ($existingTemplateDetails as $index => $existingDetail) {
            $newDetail = $templateDetails[$index] ?? [];

            foreach ($existingDetail as $key => $existingFiles) {
                if ($key === 'title') {
                    continue;
                }
                $newFiles = $newDetail[$key] ?? [];

                foreach ($existingFiles as $existingFile) {
                    if (!in_array($existingFile, $newFiles)) {
                        Log::info('is exist and delete');
                        Storage::disk('public_template_uploads')->delete($existingFile);
                    }
                }
            }
        }

        // new update
        foreach ($templateDetails as &$detail) {
            foreach ($detail as $key => &$value) {
                if ($key === 'title') {
                    continue;
                }

                if (is_array($value)) {
                    $filenames = [];
                    foreach ($value as $file) {
                        $imagePath = ($file && !is_string($file)) ? upload_templates($file) : $file;
                        $filenames[] = $imagePath;
                    }

                    $value = $filenames;
                    Log::info('new files value array');
                    Log::info(json_encode($value, JSON_PRETTY_PRINT));

                }
            }
        }

        Log::info('finished array');
        Log::info(json_encode($templateDetails, JSON_PRETTY_PRINT));

        $product->template_details = $templateDetails;
        $product->save();

        return redirect()->route('dashboard.products.index');
    }

    public function setAttributeAsOpened(Request $request, $id)
    {
        $product = $this->productService->getItem($id);
        $remove = false;

        $currentList = is_array($product->attr_id_open_list)
            ? $product->attr_id_open_list
            : (is_numeric($product->attr_id_open_list)
                ? [(int)$product->attr_id_open_list]
                : (json_decode($product->attr_id_open_list, true) ?? [])
            );

        $attrId = $request->attr_id;

        if ($attrId) {
            if (in_array($attrId, $currentList)) {
                $currentList = array_filter($currentList, fn($id) => $id != $attrId);
                $currentList = array_values($currentList);
                $remove = true;
            } else {
                $currentList[] = $attrId;
            }
        }

        $product->attr_id_open_list = $currentList;
        $product->save();

        return response()->json(['success' => true, 'is_removed' => $remove]);
    }
}
