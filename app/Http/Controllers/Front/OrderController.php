<?php

namespace App\Http\Controllers\Front;

use App\Enums\UserRoles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddressRequest;
use App\Http\Requests\Front\LoginRequest;
use App\Http\Requests\Front\RegisterRequest;
use App\Mail\SendInvoice;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Quantity;
use App\Models\Size;
use App\Models\Type;
use App\Models\User;
use App\Services\AddressService;
use App\Services\CouponService;
use App\Services\DeliveryService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\QuantityService;
use App\Services\SizeService;
use App\Services\TypeService;
use Carbon\Carbon;
use Gumlet\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class OrderController extends Controller
{
    protected $productService = null;
    protected $typeService = null;
    protected $deliveryService = null;
    protected $orderService = null;
    protected $couponService = null;
    protected $quantityService = null;
    protected $sizeService = null;
    protected $addressService = null;

    public function __construct(
        ProductService  $productService,
        TypeService     $typeService,
        DeliveryService $deliveryService,
        OrderService  $orderService,
        CouponService $couponService,
        QuantityService $quantityService,
        SizeService $sizeService,
        AddressService $addressService
    )
    {
        $this->productService = $productService;
        $this->typeService = $typeService;
        $this->deliveryService = $deliveryService;
        $this->orderService = $orderService;
        $this->couponService = $couponService;
        $this->quantityService = $quantityService;
        $this->sizeService = $sizeService;
        $this->addressService = $addressService;
    }
    public function pay_order(Request $request,$invoice=null){
        if(!empty($invoice)){
            $obj = Order::where('invoice_number',$invoice)->first();
            if(empty($obj)){
                abort(404);
            }else{
                $product = Product::find($obj->product_id);
                $delivery = false;
                $result = json_decode($obj->attrs,true);
                $result['price'] = $obj->original_amount;
                $order = $obj;
                $tax_rate = 0;
                $shipping = 0;
                return view('front.pages.pay_order', compact('product', 'delivery','result','shipping','tax_rate', 'order'));

            }
        }else{
            abort(404);
        }
    }
    public function index(Request $request,$invoice=null)
    {
           $params = $request->post();

            $id = $params['product_id'];
            $product = $this->productService->getItem($id);
            $result = $product->calculatePrice($params);

            //$params = explode('&', base64_decode($hash));

            if(isset($params['delivery']) && $params['delivery'] > 0){
                $delivery_price = $params['delivery'];
            }elseif(isset($params['delivery'])){
                $delivery_price = 0;
            }else{
                $delivery_price = -1;
            }
            $delivery = false;
            if($delivery_price >=0 ){
                $delivery = $this->deliveryService->getByPrice($delivery_price);
                $result['delivery_id']  = $delivery->id;
            }

            $shipping = 0;
            $zip = DB::selectOne("select * from zip_codes where zip='91402'");
            $tax_rate = $zip->rate;

            Session::put('order_id', $result);
            $data = $this->create_pre_order($request);
            if(!empty($params['coupon'])){
                $coupon = Coupon::getCouponInfo($params['coupon']);
                $data['coupon_id']  = $coupon->id;
                $this->couponService->update(['used'=>$coupon->used +1], $coupon->id);
            }
            $order = $this->orderService->create($data);

        return view('front.pages.order', compact('product', 'delivery','result','shipping','tax_rate', 'order'));
    }

    public function image_upload(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $fileName = time().'.'.request()->file->getClientOriginalExtension();

        request()->file->move(public_path('files'), $fileName);

        return response()->json(['success'=>'You have successfully upload file.']);
    }

    /**
     * @throws \Gumlet\ImageResizeException
     */
    public function upload(Request $request)
    {
        $image_code = '';
        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $fileId = GoogleDriveController::upload($image, $request->order_id, $request->product_title);

        $image_code = '<div class = "upload_image_block" >
                            <div class="upload_image_preview">
                                
                               <div style="width:77px;height:57px;border: 1px solid #000;align-items: center;
                                  justify-content: center;
                                  display: flex;position: relative">
                               '.strtoupper($ext).'
                                <div class="delete_img" data-img='.$fileId.'>x</div>
                                </div>
                                <input type="hidden" name="images[]" value="'.$fileId.'">
                            </div>
                        </div>';
        $output = array(
            'success'  => 'Images uploaded successfully',
            'image'   => $image_code
        );

        return response()->json($output);
    }

    public function deleteImages($fileId) {
        try {
            GoogleDriveController::deleteFile($fileId);

            $output = array(
                'success'  => 'Images deleted successfully',
            );

            return response()->json($output);
        } catch (\Exception $exception) {
            $output = array(
                'error'  => $exception->getMessage(),
            );

            return response()->json($output)->status(500);
        }
    }

    public function create_order(Request $request){
        $order = Order::find($request->order_id);
        if($order->status == 'pending'){
            $form_data = $request->except('_token');
            unset($form_data['product_id']);
            unset($form_data['order_id']);
            $order = $this->orderService->update($form_data, $request->order_id);

        }else{
            $data = $this->create_pre_order($request);
            //$data['delivery_id'] = $attrs['delivery'];
            $data['amount'] = $data['original_amount'] + $data['tax'] +  $data['shipping_price'] ;
            unset($data['address_id']);
            $order = $this->orderService->update($data, $request->order_id);
        }

        if($request->payment_type == 'paypal'){
          //  $order = $this->orderService->create($data);
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('successTransaction'),
                    "cancel_url" => route('cancelTransaction'),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $request->amount
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {
                $order->paypal_order_id = $response['id'];
                if(auth()->user() && in_array(auth()->user()->role_id, [\App\Enums\UserRoles::SUPER_ADMIN,\App\Enums\UserRoles::MANAGER])){
                    $user = User::where('email', $order->email)->first();
                    if($user){
                        $order->user_id = $user->id;
                    }else{
                        $order->user_id = null;
                    }
                }
                $order->save();
                $order->load('user');

                $invoice = $order->generateInvoice();
                $order->sendInvoice($order, $invoice);

                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return response()->json([
                            'success' => true,
                            'payment_url' => $links['href']
                        ]);
                    }
                }

                return redirect()
                    ->route('error_order')
                    ->with('error', 'Something went wrong.');

            } else {
                return redirect()
                    ->route('error_order')
                    ->with('error', $response['message'] ?? 'Something went wrong.');
            }
        }else if ($request->payment_type == 'stripe'){
            $rules = [];
            // Check if stripe_card_id is provided
            if ($request->has('stripe_card_id')) {
                $rules['stripe_card_id'] = 'required';
            } else {
                // Validate credit card details
                $rules = [
                    'card_no' => 'required',
                    'exp_month' => 'required',
                    'exp_year' => 'required',
                    'cvc' => 'required',
                ];
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->passes()) {
                $stripe = Stripe::setApiKey(env('STRIPE_SECRET'));
                try {
                    // if guest or logged in admin or manager
                    if(!auth()->user() || in_array(auth()->user()->role_id, [\App\Enums\UserRoles::SUPER_ADMIN,\App\Enums\UserRoles::MANAGER]))
                    {
                        $token = $stripe->tokens()->create([
                            'card' => [
                                'number' => $request->card_no,
                                'exp_month' => $request->exp_month,
                                'exp_year' => $request->exp_year,
                                'cvc' => $request->cvc,
                            ],
                        ]);
                        if (!isset($token['id'])) {
                            return redirect()->back();
                        }
                        $charge = $stripe->charges()->create([
                            'card' => $token['id'],
                            'currency' => 'USD',
                            'amount' => $order->amount,
                            'description' => 'wallet',
                        ]);
                    }else{
                        $user = Auth::user();
                        if (!$user->stripe_customer_id) { // first payment
                            $token = $stripe->tokens()->create([
                                'card' => [
                                    'number' => $request->card_no,
                                    'exp_month' => $request->exp_month,
                                    'exp_year' => $request->exp_year,
                                    'cvc' => $request->cvc,
                                ],
                            ]);
                            if (!isset($token['id'])) {
                                return redirect()->back();
                            }
                            $customer = $stripe->customers()->create([
                                'email' => $user->email,
                                'source' => $token['id'],
                            ]);
                            $chargeParams = [
                                'customer' => $customer['id'],
                                'currency' => 'USD',
                                'amount' => $order->amount,
                                'description' => 'wallet',
                                'source' => $customer['default_source'],
                            ];
                            $user->stripe_customer_id = $customer['id'];
                            $user->stripe_card_ids = [$customer['default_source']];
                        } else {
                            if ($request->has('stripe_card_id')) {
                                $stripe_card_id = $request->stripe_card_id;

                                // Perform charge using the provided card
                                $chargeParams = [
                                    'customer' => $user->stripe_customer_id,
                                    'currency' => 'USD',
                                    'amount' => $order->amount,
                                    'description' => 'wallet',
                                    'source' => $stripe_card_id,
                                ];
                            } else {
                                $token = $stripe->tokens()->create([
                                    'card' => [
                                        'number' => $request->card_no,
                                        'exp_month' => $request->exp_month,
                                        'exp_year' => $request->exp_year,
                                        'cvc' => $request->cvc,
                                    ],
                                ]);
                                if (!isset($token['id'])) {
                                    return redirect()->back();
                                }

                                $card = $stripe->cards()->create($user->stripe_customer_id,  $token['id']);
                                $stripe_card_ids = $user->stripe_card_ids ?? [];
                                $stripe_card_ids[] = $card['id'];
                                $user->stripe_card_ids = $stripe_card_ids;
                                $chargeParams = [
                                    'customer' => $user->stripe_customer_id,
                                    'currency' => 'USD',
                                    'amount' => $order->amount,
                                    'description' => 'wallet',
                                    'source' => $card['id'],
                                ];
                            }
                        }

                        $charge = $stripe->charges()->create($chargeParams);
                        $user->save();
                    }


                    if($charge['status'] == 'succeeded') {
                        $order->stripe_order_id = $charge['id'];
                        $order->status = 'completed';
                        $order->paid_at = date('Y-m-d H:i:s');
                        if(auth()->user() && in_array(auth()->user()->role_id, [\App\Enums\UserRoles::SUPER_ADMIN,\App\Enums\UserRoles::MANAGER])){
                            $user = User::where('email', $order->email)->first();
                            if($user){
                                $order->user_id = $user->id;
                            }else{
                                $order->user_id = null;
                            }
                        }
                        $order->save();
                        $order->load('user');

                        $invoice = $order->generateInvoice();
                        $order->sendInvoice($order, $invoice);

                        return response()->json([
                            'success' => true,
                            'payment_url' => route('success_order')
                        ]);
                    } else {
                        return response()->json([
                            'error' => 'Money not add in wallet!'
                        ]);
                    }
                } catch (Exception $e) {
                    return response()->json([
                        'error' => $e->getMessage()
                    ]);
                } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
                    return response()->json([
                        'error' => $e->getMessage()
                    ]);
                } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                    return response()->json([
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }else if ($request->payment_type == 'terminal'){
            $terminals = StripeTerminalController::getReadersList();

            $payment_info = [
                'currency' => 'USD',
                'amount' => intval($order->amount * 100),
                'payment_method_types' => ['card_present'],
                'metadata' => [
                    'order_id' => $order->id
                ],
            ];
            $paymentIntent = StripeTerminalController::paymentIntents($payment_info);
            $processPayment = StripeTerminalController::processPayment($terminals[0]->id, $paymentIntent->id);
            if(env('SIMULATED_READER')){
                $presentPayment = StripeTerminalController::presentPaymentMethod($terminals[0]->id);
                if($presentPayment->action->status == 'succeeded') {
                    $order->status = 'completed';
                    $order->paid_at = date('Y-m-d H:i:s');
                    $order->payment_intent_id = $paymentIntent->id;
                    if (auth()->user() && in_array(auth()->user()->role_id, [\App\Enums\UserRoles::SUPER_ADMIN, \App\Enums\UserRoles::MANAGER])) {
                        $user = User::where('email', $order->email)->first();
                        if ($user) {
                            $order->user_id = $user->id;
                        } else {
                            $order->user_id = null;
                        }
                    }
                    $order->save();
                    $order->load('user');

                    $invoice = $order->generateInvoice();
                    $order->sendInvoice($order, $invoice);

                    return response()->json([
                        'success' => true,
                        'payment_url' => route('success_order')
                    ]);
                }
            }
            return response()->json([
                'waiting' => true,
                'order_id' => $order->id,
            ]);
        }else{
            $order->status = 'completed';
            $order->paid_at = date('Y-m-d H:i:s');
            if(in_array(auth()->user()->role_id, [\App\Enums\UserRoles::SUPER_ADMIN,\App\Enums\UserRoles::MANAGER])){
                $user = User::where('email', $order->email)->first();
                if($user){
                    $order->user_id = $user->id;
                }else{
                    $order->user_id = null;
                }
            }
            $order->save();
            $order->load('user');

            $invoice = $order->generateInvoice();
            $order->sendInvoice($order, $invoice);

            return response()->json([
                'success' => true,
                'payment_url' => route('success_order')
            ]);
        }
    }
    public function checkStatus(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::where('id', $orderId)->first();
        if ($order) {
            if ($order->status === 'completed') {
                return response()->json([
                    'status' => 'completed',
                    'payment_url' => route('success_order'),
                    'flash' => ['level' => 'success', 'message'=>'Payment passed successfully.'],
                ]);
            } elseif ($order->status === 'canceled') {
                return response()->json([
                    'status' => 'canceled',
                    'payment_url' => route('error_order'),
                    'flash' => ['level' => 'error', 'message'=>'Payment failed'],
                ]);
            }
        }

        return response()->json(['status' => 'pending']);
    }
    public function create_pre_order($request){
        $data = $request->except('_token');

        $attrs = Session::get('order_id');
//        $attrs['price'] = number_format($attrs['price'], 2);
        $attrs['price'] = (float) sprintf('%.2f', $attrs['price']);

        if(!empty($data['address_id'])){

            $sql = "select * from addresses where id={$data['address_id']}";
            $zip = DB::selectOne($sql);
            $data['address'] = $zip->address;
            $data['city'] = $zip->city;
            $data['unit'] = $zip->unit;
            $data['state'] = $zip->state;
            $data['zip'] = $zip->zip;

        }
        $data['attrs'] = json_encode($attrs);
        $data['original_amount'] = $attrs['price'];
        $data['qty'] = $attrs['quantity'];
        if(empty($data['zip'])){
            $data['zip'] = 91402;
            $data['address'] = 'Arminta St';
            $data['city'] = 'Los Angeles';
            $data['unit'] = '14701';
            $data['state'] = 'California';

        }
        $zips = DB::selectOne("select * from zip_codes where zip='{$data['zip']}'");
        $zip_rate = 0;
        if(!empty($zips)){
            $zip_rate = $zips->rate;
        }
        if(isset($attrs['delivery_id'])){
            $data['delivery_id'] = $attrs['delivery_id'];
        }

        $data['tax'] = $zip_rate * $data['original_amount'];
        $data['status'] = 'preOrder';

        return $data;

    }
    public function create_custom_order(Request $request){
        $data = $request->except('quantity');

        $filtered_data = [];
        $filtered_data['status'] = "customRequest";
        $typesList = $typeIds = [];
        if(isset($data['sizes']) && $data['sizes'] > 0){
            $typeIds[] = $data['sizes'];
        }else if(isset($data['sizes']) && $data['sizes'] == 0){
            if($data['size_type'] == 'in'){
                $a = '"';
            }else{
                $a = "'";
            }
            $typesList['Custom Size'] = $data['custom_width'].$a.'x'.$data['custom_height'].$a.' '.strtoupper($data['size_type']);
        }
        foreach($data as $p_key=>$p_val){
            $ex = explode('_',$p_key);
            if($ex[0] == 'attribute'){
                $typeIds[] = $p_val;
            }
        }
        $types   = Type::whereIn('id', $typeIds)->orderBy('attribute_id', 'asc')->get();
        foreach($types as $t){
            if($t->id == 51){
                $typesList['Grommets Count'] = $data['custom_grommet'];
            }else{
                $typesList[$t->attribute->name] = $t->name;
            }
        }
        $typesArr = [
                'price'=>'',
                'quantity'=>$data['custom_qty'],
                'mode'=>'',
                'calulation_size'=>'',
                'types'=>$typesList,
                'delivery'=>'',
                'coupon'=>[]
            ];
//{"price":165,"quantity":"5","mode":"sqr","calculation_size":"","types":{"Shirt Type":"Hooded Sweatshirt","Shirt Color":"Black","Printed Side":"Front & Back Printing"},"delivery":0,"coupon":[]}
        foreach ($data as $key => $value) {
            $newKey = str_replace('custom_', '', $key);
            $filtered_data[$newKey] = $value;
        }
        $filtered_data['attrs'] = json_encode($typesArr);

        if(isset($filtered_data['delivery_type']) && $filtered_data['delivery_type'] === 'on'){
            $filtered_data['delivery_type'] = 'shipping';
        }
        $userId = Auth::id();
        if(!empty($userId)){
            $filtered_data['user_id'] = $userId;
        }
        $filtered_data['notes'] = $filtered_data['message'];
        $filtered_data['is_custom'] = true;

        $order = $this->orderService->create($filtered_data);

        return response()->json();
    }

    public function login(LoginRequest $request){
        if (Auth::attempt($request->only(["email", "password"]))) {
            $user = auth()->user();
            $cards = $user->getSavedCards();

            if(in_array($user->role_id, [UserRoles::MANAGER, UserRoles::SUPER_ADMIN])){
                $cards = null;
            }
            $card_view = view('front.partials.card_view', compact('cards'))->render();
            return response()->json([
                "status" => true,
                "user_id" => auth()->user()->id,
                "name" => auth()->user()->name,
                "email" => auth()->user()->email,
                "phone" => auth()->user()->phone,
                "company" => auth()->user()->company,
                'card_view' => $card_view,
            ]);

        } else {
            return response()->json([
                "status" => false
            ]);
        }
    }

    public function add_address(AddressRequest $request){
        $address = $this->addressService->create($request->except('_token'));
        return response()->json([
            "status" => true,
            "address" => $address,
        ]);
    }
    public function check_zip(Request $request){
        $zip = $request->post('zip');
        $data = DB::select("select * from zip_codes where zip='{$zip}'");

        if(!empty($data)){
            $data = $data[0];
          $success = true;
          $rate = $data->rate;
          $city = $data->city;
          $state = $data->state;
        }else{
            $success = false;
            $rate = 0;
            $city = '';
            $state = '';
        }
        return response()->json([
            "status" => $success,
            "state" => $state,
            "rate"=>$rate,
            "city"=>$city
        ]);
    }
    public function register(RegisterRequest $request){
        $data = $request->except('_token');
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        Auth::attempt($request->only(["email", "password"]));
        return response()->json([
            "status" => true,
            "user_id" => $user->id
        ]);
    }

    public function coupon(Request $request){
        if($request->has('coupon')){
            $coupon = Coupon::whereRaw('BINARY name = ?', [$request->coupon])->first();

            if($coupon){
                if($coupon->limit == 0){
                    if($coupon->percent){
                        return response()->json([
                            "percent" => $coupon->percent,
                            "coupon" => $coupon->id,
                            "text" => 'Coupon code '. $coupon->name . ' is accepted.',
                            "details" => 'Details for '. $coupon->name . ': '. $coupon->percent.'% OFF',
                            "exp_date" => 'Exp: '. Carbon::parse($coupon->end_date)->format('Y-m-d')
                        ]);
                    }else if($coupon->fixed_price){
                        return response()->json([
                            "fixed_price" => $coupon->fixed_price,
                            "coupon" => $coupon->id,
                            "text" => 'Coupon code '. $coupon->name . ' is accepted.',
                            "details" => 'Details for '. $coupon->name . ': '. $coupon->fixed_price.'$ OFF',
                            "exp_date" => 'Exp: '. Carbon::parse($coupon->end_date)->format('Y-m-d')
                        ]);
                    }
                }else{
                    if(Auth::check()){
                        if($this->couponService->checkAvailableCoupon($coupon)){
                            if($coupon->percent){
                                return response()->json([
                                    "percent" => $coupon->percent,
                                    "coupon" => $coupon->id,
                                    "text" => 'Coupon code '. $coupon->name . ' is accepted.',
                                    "details" => 'Details for '. $coupon->name . ': '. $coupon->percent.'% OFF',
                                    "exp_date" => 'Exp: '. Carbon::parse($coupon->end_date)->format('Y-m-d')
                                ]);
                            }else if($coupon->fixed_price){
                                return response()->json([
                                    "fixed_price" => $coupon->fixed_price,
                                    "coupon" => $coupon->id,
                                    "text" => 'Coupon code '. $coupon->name . ' is accepted.',
                                    "details" => 'Details for '. $coupon->name . ': '. $coupon->fixed_price.'$ OFF',
                                    "exp_date" => 'Exp: '. Carbon::parse($coupon->end_date)->format('Y-m-d')
                                ]);
                            }
                        }

                        return response()->json([
                            "message" => 'Coupon Limit Reached',
                        ]);
                    }else{
                        return response()->json(['login' => true]);
                    }

                }

            }else{
                return response()->json([
                    "message" => 'Coupon not found',
                ]);
            }
        }
    }
}
