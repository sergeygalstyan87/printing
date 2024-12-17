<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\BasketProject;
use App\Models\Project;
use App\Models\Set;
use App\Services\BasketService;
use App\Services\CouponService;
use App\Services\DeliveryService;
use App\Services\ProductService;
use App\Services\ProjectService;
use App\Services\SetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BasketsController extends Controller
{
    protected $projectService = null;
    protected $setService = null;
    protected $productService = null;

    protected $deliveryService = null;
    protected $basketService = null;
    protected $couponService = null;
    public function __construct(
        ProjectService $projectService,
        SetService $setService,
        BasketService $basketService,
        ProductService  $productService,
        DeliveryService $deliveryService,
        CouponService $couponService
    )
    {
        $this->projectService = $projectService;
        $this->setService = $setService;
        $this->basketService = $basketService;
        $this->productService = $productService;
        $this->deliveryService = $deliveryService;
        $this->couponService = $couponService;
    }

    public function index()
    {
        $user = Auth::user();
        $projects = [];
        $basketId = null;

        if ($user){
            $projects = $user->basket ? $user->basket->projects()->with(['product', 'delivery', 'sets'])->get() : [];
            $basketId = $user->basket ? $user->basket->id : null;
        }else{
            $basketId = request()->cookie('basket_id');

            if ($basketId) {
                $basket = Basket::with(['projects.product', 'projects.delivery', 'projects.sets'])->find($basketId);
                $projects = $basket ? $basket->projects : [];
            }
        }

        foreach ($projects as $project){
            $product = $this->productService->getItem($project->product_id);

            $params = $project->raw_attrs;

            $new_attrs = $product->calculatePrice($params);
            $old_attrs =  $project->attrs;

            if($new_attrs['price'] != $old_attrs['price']){
                $new_attrs['old_per_set_price'] = $old_attrs['per_set_price'];
                $new_attrs['old_price'] = $old_attrs['price'];
                $project->attrs = $new_attrs;
                $project->original_amount = $new_attrs['price'];
                $project->save();
            }
        }


        return view('front.pages.basket.index', compact('projects', 'basketId'));
    }

    public function addItem(Request $request)
    {
        $project = $this->createOrUpdateProject($request);
        $this->createOrUpdateSets($request, $project);

        $user = Auth::user();
        $cookie = null;

        if($user){
            $userWithBasket = $user->load('basket');

            if($userWithBasket->basket){
                $basket = $user->basket;
            }else{
                $basket = $this->basketService->create([
                    'user_id' => $user->id,
                ]);
            }
        }else{
            if ($request->hasCookie('basket_id')) {
                $cookieBasketId = $request->cookie('basket_id');
                $basket = Basket::find($cookieBasketId);
            }else{
                $basket = $this->basketService->create([]);
                // Set a cookie with the basket_id, valid for 30 days
                $cookie = cookie('basket_id', $basket->id, 60 * 24 * 30);
            }
        }

        BasketProject::create([
            'project_id' => $project->id,
            'basket_id' => $basket->id,
        ]);
        
        session()->forget('uploaded_files.' . $request->product_id);

        if($cookie){
            return redirect()->route('basket.index')->withCookie($cookie);
        }else{
            return redirect()->route('basket.index');
        }

    }

    public function updateItem(Request $request, Project $project)
    {
        $this->createOrUpdateProject($request, $project);
        $this->createOrUpdateSets($request, $project);
        session()->forget('uploaded_files.' . $request->product_id);
        return redirect()->route('basket.index');

    }

    public function createOrUpdateProject(Request $request, $project=null)
    {
        $params = $request->post();
        $data = $request->except('_token');

        $id = $params['product_id'];
        $product = $this->productService->getItem($id);
        $attrs = $product->calculatePrice($params);

        if(isset($params['delivery']) && $params['delivery'] > 0){
            $delivery_price = $params['delivery'];
        }elseif(isset($params['delivery'])){
            $delivery_price = 0;
        }else{
            $delivery_price = -1;
        }

        if($delivery_price >=0 ){
            $delivery = $this->deliveryService->getByPriceAndProduct($delivery_price, $id);
            $attrs['delivery_id']  = $delivery->id;
            $data['delivery_id']  = $delivery->id;
        }

        $data['attrs'] = $attrs;
        $data['original_amount'] = $attrs['price'];
        $data['qty'] = $attrs['quantity'];
        $data['raw_attrs'] = $request->except(['_token', 'uploaded_files', 'project_title']);

        if(empty($data['project_title'])){
            $data['project_title'] = $product->title;
        }

        if($project){
            return $this->projectService->update($data, $project->id);
        }else{
            return $this->projectService->create($data);
        }
    }

    public function createOrUpdateSets(Request $request, $project)
    {
        Set::where('project_id', $project->id)->delete();
        $attrs = $project->attrs;

        if(isset($attrs['apparel_info'])){
            $sets = array_keys(array_filter($attrs['apparel_info'], function ($item) {
                return isset($item['qty']);
            }));
        }else{
            $sets = $request->set_title;
            $uploaded_files = $request->uploaded_files ? json_decode($request->uploaded_files, true) : [];
        }

        if($request->type != 'Upload Print Ready Files'){
            $uploaded_files = [];
        }
        foreach ($sets as $key => $title) {
            $this->setService->create([
                'set_title' => $title,
                'project_id' => $project->id,
                'uploaded_files' => ($uploaded_files && isset($uploaded_files[$key])) ? $uploaded_files[$key] : null
            ]);
        }
    }

    public function removeItem(Project $project)
    {
        if($project){
            $sets = $project->sets->pluck('uploaded_files');
            foreach ($sets as $set) {
                if ($set){
                    foreach ($set as $type) {
                        foreach ($type as $folder) {
                            if(Storage::disk('tmp_upload')->exists($folder)){
                                Storage::disk('tmp_upload')->deleteDirectory($folder);
                            }
                        }
                    }
                }
            }

            $project->basket()->detach();
            $project->delete();
        }

        return redirect()->route('basket.index');
    }

    public function copyItem(Project $project)
    {
        if ($project) {
            // Create a new project with the same attributes
            $newProject = $project->replicate();
            $newProject->save();

            $sets = $project->sets;
            foreach ($sets as $set) {
                $newSet = $set->replicate();
                $newSet->project_id = $newProject->id;

                $uploadedFiles = $set->uploaded_files ?? [];
                $newUploadedFiles = [];

                foreach ($uploadedFiles as $type => $folders) {
                    foreach ($folders as $folder) {

                        $newFolderName = uniqid();

                        if (Storage::disk('tmp_upload')->exists($folder)) {

                            Storage::disk('tmp_upload')->makeDirectory($newFolderName);

                            $files = Storage::disk('tmp_upload')->files($folder);

                            foreach ($files as $file) {
                                $fileName = basename($file);
                                $newFileName = str_replace($folder, $newFolderName, $fileName); // Replace old folder name with new folder name

                                Storage::disk('tmp_upload')->copy($file, $newFolderName . '/' . $newFileName);
                                $newUploadedFiles[$type][] = $newFolderName;
                            }
                        }
                    }
                }
                $newSet->uploaded_files = $newUploadedFiles;

                $newSet->save();
            }

            $user = Auth::user();

            if ($user){
                $basketId = $user->basket->id;
            }else{
                $basketId = request()->cookie('basket_id');
            }

            DB::table('basket_projects')->insert([
                'basket_id' => $basketId,
                'project_id' => $newProject->id,
            ]);

        }

        return redirect()->route('basket.index');
    }

    public function addDesign(Request $request)
    {
        $project = $this->createOrUpdateProject($request);
        $iframe_url = getAddDesignUrl($request->product_id, $project->id);

        return view('front.pages.add_design', compact('project', 'iframe_url'));
    }

}
