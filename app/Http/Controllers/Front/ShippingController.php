<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\BasketService;
use App\Services\CouponService;
use App\Services\DeliveryService;
use App\Services\ProductService;
use App\Services\ProjectService;
use App\Services\SetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
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

    public function shipping_index(Request $request)
    {
        $coupon_id = $request->coupon_id;
        $basket_id = $request->basket_id;

        $projects = $request->projects_ids;
        $onlyPickup = [];
        foreach ($projects as $project_id){
            $project = $this->projectService->getItem($project_id);
            if(!$project->product->shipping_info){
                $onlyPickup[] = $project->id;
            }
        }

        [
            'total_price' => $total_price,
            'tax' => $tax,
            'total_amount' => $total_amount
        ] = $this->calculate_projects_price_pickup($projects, $coupon_id);

        return view('front.pages.shipping.shipping', compact('projects', 'onlyPickup', 'total_price', 'tax', 'total_amount'));
    }

    public function shipping_calculation_form_view(Request $request)
    {
        $projects = json_decode($request->projects_ids, true);
        $project_list = [];

        foreach ($projects as $project_id) {
            $project = $this->projectService->getItem($project_id);

            if ($project->product->shipping_info) {
                $project_list[] = $project;
            }
        }

        $deliveryData = [];
        $allDeliveryTypes = [];
        $deliveryTypeTotals = [];
        foreach ($project_list as $project) {

            $request->merge([
                'product_id' => $project->product_id,
                'quantity_id' => $project->quantity_id,
                'quantity' => $project->qty,
                'total_price' => $project->attrs['per_set_price'],
            ]);

            $response = (new PaymentController)->getShippingData($request, $project);
            $responseData = json_decode($response->getContent(), true);

            foreach ($responseData as $method) {
                $key = $method['text'];

                if (!in_array($key, $allDeliveryTypes)) {
                    $allDeliveryTypes[] = $key;
                }

                $deliveryData[$key][$project->id] = [
                    'project' => $project,
                    'delivery_data' => $method,
                ];

                if (!isset($deliveryTypeTotals[$key])) {
                    $deliveryTypeTotals[$key] = 0;
                }
                $deliveryTypeTotals[$key] += $method['price'];
            }
        }

        $matrix = [];

        foreach ($project_list as $project) {
            $project_id = $project->id;
            $matrix[$project_id] = [
                'project' => $project
            ];

            foreach ($allDeliveryTypes as $deliveryType) {
                if (isset($deliveryData[$deliveryType][$project_id])) {
                    $matrix[$project_id][$deliveryType] = $deliveryData[$deliveryType][$project_id]['delivery_data'];
                } else {
                    $matrix[$project_id][$deliveryType] = null;
                }
            }
        }

        $view = view('front.pages.partials.shipping_datatable.table', compact('matrix', 'deliveryTypeTotals', 'allDeliveryTypes'))->render();

        return response()->json(['view' => $view]);

    }

    public function calculate_projects_price_pickup($projects, $coupon_id=null)
    {
        $total_price = 0;
        foreach ($projects as $project_id){
            $project = $this->projectService->getItem($project_id);
            $total_price += $project->original_amount;
        }

        if($coupon_id){
            $coupon = $this->couponService->getItem($coupon_id);
            if($coupon->fixed_price){
                $total_price -= $coupon->fixed_price;
            }else{
                $total_price -= $total_price * $coupon->percent / 100;
            }
        }

        $total_price = number_format($total_price, 2);

        $zip = DB::selectOne("select * from zip_codes where zip='91402'");
        $tax_rate = $zip->rate;
        $tax = number_format($total_price * $tax_rate, 2);
        $total_amount = number_format($total_price + $tax, 2);

        return [
            'total_price' => $total_price,
            'tax' => $tax,
            'total_amount' => $total_amount
        ];
    }

    public function show_payment_form(Request $request)
    {
        $is_pickup = $request->shipping_method_type === 'pickup' ? 1 : 0;

        if($is_pickup){
            $coupon_id = $request->coupon_id;

            $projects = json_decode($request->projects_ids, true);
            $onlyPickup = [];
            foreach ($projects as $project_id){
                $project = $this->projectService->getItem($project_id);
                if(!$project->product->shipping_info){
                    $onlyPickup[] = $project->id;
                }
            }

            [
                'total_price' => $total_price,
                'tax' => $tax,
                'total_amount' => $total_amount
            ] = $this->calculate_projects_price_pickup($projects, $coupon_id);

        }

        return view('front.pages.shipping.payment', compact('projects', 'onlyPickup', 'total_price', 'tax', 'total_amount'));

    }
}
