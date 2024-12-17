<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\StripeTerminalController;
use App\Http\Requests\Admin\OrderRequest;
use App\Mail\OrderDeclineEmail;
use App\Mail\OrderProofEmail;
use App\Mail\OrderStatusEmail;
use App\Models\Attribute;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\AttributeService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\TypeService;
use App\Services\UserService;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    protected $orderService = null;
    protected $userService = null;
    protected $productService = null;
    protected $attributeService = null;
    protected $typeService = null;

    public function __construct(
        OrderService $orderService,
        UserService $userService,
        ProductService $productService,
        AttributeService $attributeService,
        TypeService      $typeService
    )
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
        $this->attributeService = $attributeService;
        $this->typeService = $typeService;
        $this->userService = $userService;
    }

    public function custom_order()
    {
        $items = Order::where('is_custom', 1)->where('status', '!=', 'completed')->orderBy('id', 'DESC')->get();
        return view('dashboard.pages.orders.custom_requests', compact(['items']));
    }
    public function index_old()
    {
        $items = $this->orderService->getItemsWithStatus();
        $itemsPrepress = $this->orderService->getItemsWithDeliveryStatus([0, 5]);
        $itemsProduction = $this->orderService->getItemsWithDeliveryStatus(1);
        $itemsReady = $this->orderService->getItemsWithDeliveryStatus(2);
        return view('dashboard.pages.orders.list', compact(['items', 'itemsPrepress', 'itemsProduction', 'itemsReady']));
    }

    public function index()
    {
        $items = $this->orderService->getItemsWithStatus();

        return view('dashboard.pages.orders.list', compact(['items']));
    }
    public function getNewOrders(Request $request)
    {
        $offset = $request->get('start');
        $limit = $request->get('length');
        $data = $this->orderService->getNewOrders($offset, $limit);

        return response()->json($data);
    }
    public function add()
    {
        return view('dashboard.pages.orders.form');
    }

    public function store(OrderRequest $request)
    {
        $this->orderService->create($request->except('_token'));
        return redirect()->route('dashboard.orders.index');
    }

    public function edit($id)
    {
        $item = $this->orderService->getItem($id);
        $proof = $this->orderService->getProof($id);
        $rate = null;
        if($item->shipping_provider_id){
            $rate = self::get_shipping_rates_data($item->shipping_provider_id);
        }
        return view('dashboard.pages.orders.form', compact(['item', 'proof', 'rate']));
    }
    public function edit_request($id)
    {
        $item = $this->orderService->getItem($id);
        $proof = $this->orderService->getProof($id);
        $rate = null;
        if($item->shipping_provider_id){
            $rate = self::get_shipping_rates_data($item->shipping_provider_id);
        }
        if($item->delivery_type === 'pickup'){
            $zip = DB::selectOne("select * from zip_codes where zip='91402'");
            $tax_rate = $zip->rate;
        }else{
            $tax_rate = DB::table('zip_codes')
                ->where('zip', $item->zip)
                ->value('rate');
        }

        return view('dashboard.pages.orders.requests_form', compact(['item', 'proof', 'rate', 'tax_rate']));
    }

    public function update(Request $request, $id)
    {
        $order = $this->orderService->update($request->except('_token'), $id);
        if($order->delivery_status == 3 || $order->delivery_status == 4){
            if ($order->user_id) {
                $email = $this->userService->getItem($order->user_id)->email;
            } else {
                $email = $order->email;
            }
            Mail::to($email)->send(new OrderStatusEmail($order, $email));
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        } else {
            return redirect()->route('dashboard.orders.index');
        }
    }

    public function uploadProof(Request $request, $id)
    {
        $proof_files = $request->file('file');
        $proof = $this->orderService->setOrderProof($proof_files, $id);
        $image_code = '<div class = "upload_image_block" >
                            <div class="upload_image_preview">
                               <div style="width:245px;height:57px;border: 1px solid #000;align-items: center;
                                  justify-content: center;
                                  display: flex;position: relative">
                               '.$proof->file.'
                                <input type="hidden" name="proofs[]" value="'.$proof->id.'">
                            </div>
                            <div class="delete_img" data-proof='.$proof->id.'>x</div>
                            </div>
                        </div>';

        if ($request->ajax()) {
            return response()->json(['success' => true, 'proof' => $image_code]);
        } else {
            return redirect()->route('dashboard.orders.edit', ['id' => $id]);
        }
    }

    public function deleteProof($id, Request $request) {
        $deleted = $this->orderService->deleteOrderProof($id);

        if ($request->ajax()) {
            if ($deleted) {
                return response()->json(['success' => true, 'message' => 'Successfully removed!']);
            } else {
                return response()->json(['success' => false, 'message' => 'Something went wrong!'])->status(500);
            }
        } else {
            return redirect()->route('dashboard.orders.edit', ['id' => $id]);
        }
    }

    public function sendProof(Request $request, $id)
    {
        $proof = $this->orderService->getProof($id);
        $order = $this->orderService->getItem($id);

        if ($order->user_id) {
            $email = $this->userService->getItem($order->user_id)->email;
        } else {
            $email = $order->email;
        }

        Mail::to($email)->send(new OrderProofEmail($proof->file, $order));

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        } else {
            return redirect()->route('dashboard.orders.edit', ['id' => $id]);
        }
    }

    public function update_price(Request $request, $id)
    {

        $data = $request->except('_token');
        $order = Order::find($id);
        if($order->status == 'customRequest'){
//            if($order->delivery_type == 'shipping'){
//                $zip = $order->zip;
//                $shipping_price = $data['shipping_price'];
//            }else{
//                $shipping_price = 0;
//                $zip = 91402;
//            }
//            $obj = DB::selectOne("select rate from zip_codes where zip = '{$zip}'");
//           if(!empty($obj)){
//               $tax = $data['original_amount']*$obj->rate;
//           }else{
//               $tax = 0;
//           }
//            $data['amount'] = $data['original_amount']+$tax+$shipping_price;
//            $data['tax'] = $tax;
            $details = json_decode($order->attrs);
            $details->price = $request->original_amount;
            $data['attrs'] = json_encode($details);
            $this->orderService->update( $data, $id);
            if ($request->ajax()) {
                return response()->json(['success' => true]);
            } else {
                return redirect()->route('dashboard.orders.index', ['filters[orders-active-filter]' => 'custom_request']);
            }
        }
    }

    public function delete($id, Request $request)
    {
        $is_custom = $request->post('is_custom');
        $this->orderService->delete($id);

        $route = 'dashboard.orders.index';

        if ($is_custom) {
            $route = 'dashboard.orders.custom_order';
        }

        return redirect()->route($route)->with('success', 'Order deleted successfully');
    }

    public function delete_images(){
        File::deleteDirectory(public_path('uploads'));
        Order::whereNotNull('images')->update(array('images' => null));
        return redirect()->back();
    }

    public function invoice($id){

        $item = $this->orderService->getItem($id);

        if(!empty($item->invoice_number)){
            $fileName = $item->invoice_path;
        }else{
            $fileName = $item->generateInvoice();
        }
        $filePath = 'app/public/invoice/' . $fileName;
        if (file_exists(storage_path($filePath))) {
                // If the file exists, return it as a download response
            return response()->download(storage_path($filePath), $fileName);
        } else {
            // If the file doesn't exist, return a 404 response
            abort(404);
        }
    }
    public function generate_invoice($id){

        $item = $this->orderService->getItem($id);

        if(!empty($item->invoice_number)){
            $fileName = $item->invoice_path;
        }else{
            $fileName = $item->generateInvoice();
        }
        $filePath = 'app/public/invoice/' . $fileName;
        if (file_exists(storage_path($filePath))) {
           //sent email to customer
            $item->sendInvoiceBYRequest($item, $fileName);
            $this->orderService->update( ['status'=>'pending','invoice_sent'=>date('Y-m-d H:i:s')], $id);
            return redirect()->route('dashboard.orders.index');
        } else {
            // If the file doesn't exist, return a 404 response
            abort(404);
        }
    }
    public function downloadFile($filename)
    {
        $file = storage_path('uploads/' . $filename); // Assuming your files are stored in the storage directory

        if (file_exists('uploads/' . $filename)) {
            return response()->download('uploads/' . $filename, basename($filename));
        } else {
            abort(404, 'File not found');
        }
    }

    public function createOrder()
    {
        $products = $this->productService->getItems();
        $zip = DB::selectOne("select * from zip_codes where zip='91402'");
        $pickUp_tax_rate = $zip->rate;
        return view('dashboard.pages.orders.makeOrder', compact(['products', 'pickUp_tax_rate']));
    }

    public function makeOrder(Request $request)
    {
        $validate = $request->validate([
            'product_id' => 'required',
            'attribute_id' => 'required',
            'type_id' => 'required',
            'qty' => 'required',
            'original_amount' => 'required',
        ], [
            'product_id.required' => 'The Product field is required.',
            'attribute_id.required' => 'The Attribute field is required.',
            'type_id.required' => 'The Type field is required.',
            'qty.required' => 'The Quantity field is required.',
            'original_amount.required' => 'The Order Price field is required.'
        ]);
        $attributes = [
            "attribute_id" => collect($request->attribute_id)->values()->all(),
            "type_id" => collect($request->type_id)->values()->all(),
        ];

        $types = [];

        foreach ($attributes['attribute_id'] as $index => $attributeId) {
            $attribute = $this->attributeService->getItem($attributeId);
            if ($attribute) {
                $type = ($this->typeService->getItem($attributes['type_id'][$index]));

                $types[$attribute->name] = $type->name;
            }
        }

        $data = $request->except(['_token', 'attribute_id', 'type_id']);
        $data['tax'] = round((float)$request->tax, 2);
        $data['amount'] = round((float)$request->total_price, 2);
        $data['attrs'] = json_encode([
            "price"=>$request->original_amount,
            "quantity"=>$request->qty,
            "mode"=>'-',
            "calculation_size"=>'-',
            "types"=>$types,
            "delivery"=>0,
            "coupon"=>[],
            "delivery_id"=>'-',
        ]);
        $data['is_custom'] = 1;
        if(!isset($data['payment_type'])){
            $data['payment_type'] = 'stripe';
        }

        if(isset($data['payment_type']) && $data['payment_type']==='cash'){
            // if type cash status is completed
            $data['status'] = 'completed';
        }

        if(!$data['amount']){
            $data['amount'] = $request->original_amount;
        }

        $order = $this->orderService->create($data);

        if($order->payment_type == 'cash'){
            $invoice = $order->generateInvoice();
            $order->sendInvoice($order, $invoice);
        }else if ($order->payment_type == 'terminal'){
//            $terminals = StripeTerminalController::getReadersList();

            $payment_info = [
                'currency' => 'USD',
                'amount' => intval($order->amount * 100),
                'payment_method_types' => ['card_present'],
                'metadata' => [
                    'order_id' => $order->id
                ],
            ];
            $paymentIntent = StripeTerminalController::paymentIntents($payment_info);
            $processPayment = StripeTerminalController::processPayment($paymentIntent->id);
            if(env('SIMULATED_READER')){
                $presentPayment = StripeTerminalController::presentPaymentMethod();
                if($presentPayment->action->status == 'succeeded') {
                    $order->status = 'completed';
                    $order->payment_intent_id = $paymentIntent->id;
                    $order->paid_at = date('Y-m-d H:i:s');
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

            return redirect()->route('dashboard.orders.edit', $order->id)
                ->with('show_terminal_modal', true)
                ->with('paymentIntentId', $paymentIntent->id);
        }

        return redirect()->route('dashboard.orders.index', ['filters[orders-active-filter]' => 'new']);
    }

    public function getTypes(Request $request)
    {
        if($request->has('product_id')){
            $product_id = $request->product_id;
            $product = Product::find($product_id);
            $attributes = $this->attributeService->getByProduct($product_id);
            if(!count($attributes)){
                $type_info = json_decode($product->detail_info,true);

                $attr_ids = [];
                if($type_info){
                    foreach($type_info as $attr_id => $type){
                        $attr_ids[] = $attr_id;
                    }
                }

                $attributes = Attribute::whereIn('id', $attr_ids)->get();
            }
            return response()->json(['attributes' => $attributes]);
        }else if($request->has('attribute_id')){
            $attribute_id = $request->attribute_id;
            $types = $this->typeService->getByAttribute($attribute_id);

            return response()->json(['types' => $types]);
        }

    }

    public function decline($id){
        $item = $this->orderService->getItem($id);

        return view('dashboard.pages.orders.decline_form', compact(['item']));
    }

    public function decline_and_refund_order(Request $request){
        $order = $this->orderService->getItem($request->id);

        if ($request->has('refund_amount') && $request->refund_amount > 0) {
            try {
                $refund = (new StripeTerminalController)->refundPayment($order, $request->refund_amount);
                if (is_array($refund) && array_key_exists('error', $refund)) {
                    return response()->json(['status' => 'error', 'message' => $refund['error']]);
                }

                if(is_object($refund)){
                    if ($refund->status === 'succeeded') {
                        $order->status = 'canceled';
                        $order->save();
                        return response()->json(['status' => 'success', 'message' => 'Order canceled and refunded successfully.']);
                    }
                }else {
                    return response()->json(['status' => 'failed', 'message' => 'Refund processing failed.']);
                }

            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Error canceling order: ' . $e->getMessage()]);
            }
        }
        return redirect()->back()->withInput();
    }
    public function decline_order(Request  $request){

        $item = $this->orderService->getItem($request->post('id'));
        $text = $request->post('decline_reason');
        Mail::to($item->email)->send(new OrderDeclineEmail($item, $item->email,$text));
        $item->status = 'canceled';
        $item->save();
        return redirect()->route('dashboard.orders.index', ['filters[orders-active-filter]' => 'new']);
    }

    public static function get_shipping_rates_data($shipmentId)
    {
        $shippoToken = env('SHIPPO_TOKEN');
        $url = "https://api.goshippo.com/rates/$shipmentId";

        // Initialize cURL
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: ShippoToken $shippoToken",
        ]);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            error_log("cURL error: $error_msg");
            throw new Exception("cURL error: $error_msg");
        }

        // Close cURL session
        curl_close($ch);

        // Decode JSON response
        $rate = json_decode($response);

        if ($rate->provider === 'UPS' && $rate->duration_terms !== "") {
            $prepared_object = [
                'terms'=>$rate->duration_terms,
                'estimated_days'=>$rate->estimated_days,
            ];

            if ($rate->estimated_days === 1) {
                if (!isset($standard_next_day) || $rate->amount < $standard_next_day['price']) {
                    $prepared_object['text'] = 'STANDARD';
                }
                if (str_contains($rate->servicelevel->token, 'next_day_air')) {
                    if (in_array('FASTEST', $rate->attributes) && (!isset($priority_next_day) || $rate->amount < $priority_next_day['price'])) {
                        $prepared_object['text'] = 'PRIORITY next business day';
                    } else if (!isset($cheapest_next_day) || $rate->amount < $cheapest_next_day['price']) {
                        $prepared_object['text'] = '1 Day';
                    }
                }
            } else if ($rate->estimated_days === 2) {
                if (!isset($cheapest_second_day) || $rate->amount < $cheapest_second_day['price']) {
                    $prepared_object['text'] = '2 Day';
                }
            } else if ($rate->estimated_days === 3) {
                if (!isset($cheapest_third_day) || $rate->amount < $cheapest_third_day['price']) {
                    $prepared_object['text'] = '3 Day';
                }
            }
        }

        return $prepared_object;
    }

}
