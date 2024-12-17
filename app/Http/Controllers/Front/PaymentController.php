<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Shippo;
use Shippo_Shipment;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaymentController extends Controller
{
    /**
     * process transaction.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processTransaction(Request $request)
    {
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
                        "value" => "1000.00"
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
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
    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            Order::where('paypal_order_id', $request['token'])->update(['status' => 'completed']);
            return redirect()
                ->route('success_order')
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('success_order')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        Order::where('paypal_order_id', $request['token'])->update(['status' => 'canceled']);

        return redirect()
            ->route('cancel_order')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }


    /**
     * Calculate shipment prices and Estimations
     *
     * @return \Illuminate\Http\Response
     */
    public function calculateShipmentPrices(Request $request): \Illuminate\Http\Response
    {
        return $this->getShippingData($request);
    }

    public function getShippingData(Request $request, $project=null)
    {
        $productId = $request->input('product_id');
        $quantityId = $request->input('quantity_id');
        $quantity = $request->post('quantity');
        $set = 1;

        if($project){
            $set = $project->sets->count();
        }

        $product = Product::select('shipping_info', 'quantity_discount','shipping_price')
            ->whereId($productId)
            ->first();

        if(empty($product->shipping_info)){
            return response(['message' => 'Calculation not available']);
        }
        if(!$quantity){
            $quantityDiscount =  json_decode($product->quantity_discount, true);
            $quantity = $quantityDiscount[$quantityId]['value'];
        }

        $shippingInfo =  json_decode($product->shipping_info, true);

        $details = [];
        $min_items = [];

        if(!empty($shippingInfo)){
            foreach ($shippingInfo as $item) {
                if ($item['until_pcs'] >= $quantity){
                    $min_items[$item['until_pcs']] = $item;
                }
            }
            $min = min(array_keys($min_items));
            $details = $min_items[$min];
        }


        if (!count($details)) {
            return response(['message' => 'Please try latter.']);
        }

        Shippo::setApiKey(env('SHIPPO_TOKEN'));

        $from_address = array(
            'name' => 'Aram Martirosyan',
            'company' => 'Yans Print',
            'street1' => ' 14701 Arminta St, Ste A',
            'city' => 'Panorama City',
            'state' => 'CA',
            'zip' => '91402',
            'country' => 'US',
            'phone' => '+1 555 341 9393',
            'email' => 'aram.designer@yahoo.com',
        );

        // Parcel information array
        // The complete reference for parcel object is here: https://goshippo.com/docs/reference#parcels
        $parcel = [
            'length' => $details['length'],
            'width' => $details['width'],
            'height' => $details['height'],
            'distance_unit' => 'in',
            'weight' => $details['weight'],
            'mass_unit' => 'lb',
        ];

        $zip_code = $request->post('zip_code');
        if(!$zip_code){
            $zip_code = $request->post('zip');
        }

        $address_id = $request->post('address_id');
        $address = $request->post('address');
        $city = $request->post('city');
        $state = $request->post('state');
        $unit = $request->post('unit');
        if(empty($zip_code) && !empty($address_id)){
            $sql = "select * from addresses where id={$address_id}";
            $zip = DB::selectOne($sql);
            $address = $zip->address;
            $city = $zip->city;
            $unit = $zip->unit;
            $state = $zip->state;
            $zip_code = $zip->zip;
        }

        // Collect the shipments to each address
        // Example to_address with the zip code
        // The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
        $to_address = array(
            'country' => 'US',
            'zip' => $zip_code ?: null,
        );

        $zips = DB::select("select * from zip_codes where zip='{$zip_code}'");
        $zip_rate = 0;
        if(!empty($zips)){
            $zip_rate = $zips[0]->rate;
        }
        $free_shipping_price = setting('free_shipping');
        if(($free_shipping_price > 0) && $free_shipping_price <= $request->post('total_price')){
            $result['FREE'] = [
                'terms'=>"on ORDERS over ".$free_shipping_price."$",
                'estimated_days'=>0,
                'price'=>0,
                'text'=>"Free Shipping ",
                "provider_id"=>'FREE_id',
                "provider"=>"free",
                'tax_rate'=>$zip_rate,
            ];
        }else{
            $shipment = Shippo_Shipment::create(array(
                'address_from' => $from_address,
                'address_to' => $to_address,
                'parcels' => array($parcel),
                'async' => false
            ));

            // Collect all shipments rates
            if(!isset($shipment['rates'])){
                return response(['message' => 'Please try latter.']);
            }
            $rates = $shipment['rates'];

            $standard_next_day = null;
            $cheapest_next_day = null;
            $priority_next_day = null;
            $cheapest_second_day = null;
            $cheapest_third_day = null;

            foreach ($rates as $rate) {
                if ($rate->provider === 'UPS' && $rate->duration_terms !== "") {
                    $prepared_object = [
                        'terms'=>$rate->duration_terms,
                        'estimated_days'=>$rate->estimated_days,
                        'price'=>$set * $rate->amount,
                        "provider_id"=>$rate->object_id,
                        "provider"=>$rate->provider,
                        'tax_rate'=>$zip_rate,
                    ];

                    if ($rate->estimated_days === 1) {
                        if (!isset($standard_next_day) || $rate->amount < $standard_next_day['price']) {
                            $prepared_object['text'] = 'STANDARD';
                            $standard_next_day = $prepared_object;
                        }
                        if (str_contains($rate->servicelevel->token, 'next_day_air')) {
                            if (in_array('FASTEST', $rate->attributes) && (!isset($priority_next_day) || $set * $rate->amount < $priority_next_day['price'])) {
                                $prepared_object['text'] = 'PRIORITY';
                                $priority_next_day = $prepared_object;
                            } else if (!isset($cheapest_next_day) || $set * $rate->amount < $cheapest_next_day['price']) {
                                $prepared_object['text'] = '1 Day';
                                $cheapest_next_day = $prepared_object;
                            }
                        }
                    } else if ($rate->estimated_days === 2) {
                        if (!isset($cheapest_second_day) || $set * $rate->amount < $cheapest_second_day['price']) {
                            $prepared_object['text'] = '2 Day';
                            $cheapest_second_day = $prepared_object;
                        }
                    } else if ($rate->estimated_days === 3) {
                        if (!isset($cheapest_third_day) || $set * $rate->amount < $cheapest_third_day['price']) {
                            $prepared_object['text'] = '3 Day';
                            $cheapest_third_day = $prepared_object;
                        }
                    }
                }
            }

            $result = [$priority_next_day, $cheapest_next_day, $standard_next_day, $cheapest_second_day, $cheapest_third_day];
            $result = array_filter($result, function($item){return isset($item);});
            $prices = array();
            foreach ($result as $key => $row) {
                $prices[$key] = $row['price'];
            }
        }

        // Sort the array based on price in ascending order
        array_multisort($prices, SORT_ASC, $result);

        if($request->post('no_pickup') != 1){
            $result['PickupFree'] = [
                'terms'=>'FREE',
                'estimated_days'=>0,
                'price' =>0,
                'text' =>'Pick-up',
                'tax_rate'=>1,
            ];
        }

        return response($result);
    }

    public static function getValueText($value)
    {
        if ($value == 'BESTVALUE') {
            return 'Best Value:';
        } else {
            return ucfirst(strtolower($value)) . " =>";
        }
    }

    /**
     * Calculate shipment prices and Estimations
     *
     * @return \Illuminate\Http\Response
     */
    public function getShipmentMethods(Request $request): \Illuminate\Http\Response
    {
        Shippo::setApiKey(env('SHIPPO_TOKEN'));

        $from_address = array(
            'name' => 'Mr Hippo',
            'company' => 'Shippo',
            'street1' => '215 Clayton St.',
            'city' => 'San Francisco',
            'state' => 'CA',
            'zip' => '94117',
            'country' => 'US',
            'phone' => '+1 555 341 9393',
            'email' => 'mr-hippo@goshipppo.com',
        );

        // Parcel information array
        // The complete reference for parcel object is here: https://goshippo.com/docs/reference#parcels
        $parcel = array(
            'length' => '5',
            'width' => '5',
            'height' => '5',
            'distance_unit' => 'in',
            'weight' => '2',
            'mass_unit' => 'lb',
        );
        $address_id = $request->post('address_id');


        $zip = $request->post('zip');
        $address = $request->post('address');
        $city = $request->post('city');
        $state = $request->post('state');
        $unit = $request->post('unit');
        if(empty($zip) && !empty($address_id)){
            $sql = "select * from addresses where id={$address_id}";
            $zip = DB::selectOne($sql);
            $address = $zip->address;
            $city = $zip->city;
            $unit = $zip->unit;
            $state = $zip->state;
            $zip = $zip->zip;
        }

        // Collect the shipments to each address
        // Example to_address with the zip code
        // The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
        $to_address = array(
            'country' => 'US',
            'address' => $address ?: null,
            'city' => $city ?: null,
            'state' => $state ?: null,
            'unit' => $unit ?: null,
            'zip' => $zip ?: null,
        );

        // For each destination address we now create a Shipment object.
        // async=false indicates that the function will wait until all rates are generated before it returns.
        // The reference for the shipment object is here: https://goshippo.com/docs/reference#shipments
        // By default Shippo API operates on an async basis. You can read about our async flow here: https://goshippo.com/docs/async
        $shipment = Shippo_Shipment::create(array(
            'address_from' => $from_address,
            'address_to' => $to_address,
            'parcels' => array($parcel),
            'async' => false
        ));
        $zips = DB::select("select * from zip_codes where zip='{$zip}'");
        $zip_rate = 0;
        if(!empty($zips)){
           $zip_rate = $zips[0]->rate;
        }
        // Collect all shipments rates
        $rates = $shipment['rates'];

        $providers = array_values(array_filter(
            $rates,
            function ($rate) {
                return $rate['provider'] === 'UPS';
            }
        ));

        $result = [];

        foreach ($providers as $provider) {
            $result[] = [
                'provider_id' => $provider['object_id'],
                'provider' => $provider['servicelevel']['display_name'] ?? $provider['servicelevel']['name'] ?? $provider['provider'],
                'description' => $provider['duration_terms'],
                'provider_image_200' => $provider['provider_image_200'],
                'provider_image_75' => $provider['provider_image_75'],
                'estimated_days' => intval($provider['estimated_days']),
                'amount' => floatval($provider['amount']),
                'tax_rate'=>$zip_rate,
            ];
        }

        return response($result);
    }

    public function success_order(){
        return view('front.pages.payment.success');
    }

    public function cancel_page(){
        return view('front.pages.payment.cancel');
    }

    public function error_page(){
        return view('front.pages.payment.error');
    }

    public static function fedexAutoriziation(){

        $url = 'https://apis.fedex.com/oauth/token';

        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => env('FEDEX_API_KEY'),
            'client_secret' => env('FEDEX_SECRET_KEY'),
        ];

        $response = Http::asForm()
            ->post($url, $data);

        // Access response data
        $responseData = $response->json();

        if(isset($responseData['access_token'])){
            return $responseData['access_token'];
        }else{
            return false;
        }

        // Do something with $responseData

    }

    public function delete_card(Request $request){
        $stripe_card_id = $request->id;
        $user = Auth::user();

        $stripe = Stripe::setApiKey(env('STRIPE_SECRET'));

        try {

            $stripe->cards()->delete($user->stripe_customer_id, $stripe_card_id);

            if ($user->stripe_card_ids && in_array($stripe_card_id, $user->stripe_card_ids)) {
                $stripe_card_ids = array_values(array_diff($user->stripe_card_ids, [$stripe_card_id]));
                $user->stripe_card_ids = $stripe_card_ids;
                $user->save();
            }

            return response()->json(['message' => 'Card deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete card' . $e->getMessage()]);
        }
    }
    public function default_card(Request $request){
        $stripe_card_id = $request->id;
        $user = Auth::user();

        $stripe = Stripe::setApiKey(env('STRIPE_SECRET'));

        try {

            $customer = $stripe->customers()->update($user->stripe_customer_id, [
                'default_source' => $stripe_card_id,
            ]);

            return response()->json(['message' => 'Default card updated']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update default card' . $e->getMessage()]);
        }
    }
    public function store_card(Request $request){
        try{
            $stripe = Stripe::setApiKey(env('STRIPE_SECRET'));

            $user = Auth::user();
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

            if (!$user->stripe_customer_id) {
                $customer = $stripe->customers()->create([
                    'email' => $user->email,
                    'source' => $token['id'],
                ]);

                $user->stripe_customer_id = $customer['id'];
                $user->stripe_card_ids = [$customer['default_source']];

            } else {

                $card = $stripe->cards()->create($user->stripe_customer_id,  $token['id']);
                $stripe_card_ids = $user->stripe_card_ids ?? [];
                $stripe_card_ids[] = $card['id'];
                $user->stripe_card_ids = $stripe_card_ids;
            }
            $user->save();

            return redirect(route('profile.payments'));
        }catch (\Exception $e){
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }

}
