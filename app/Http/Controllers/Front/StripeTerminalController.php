<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Refund;

class StripeTerminalController extends Controller
{
    public static function getReadersList()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $terminals = $stripe->terminal->readers->all(['limit' => 1]);

        return $terminals->data;
    }

    public static function paymentIntents($body)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $paymentIntent = $stripe->paymentIntents->create($body);

        return $paymentIntent;
    }

    public static function processPayment($paymentIntentId)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $capture = $stripe->terminal->readers->processPaymentIntent(
            env('STRIPE_READER_ID'),
            ['payment_intent' => $paymentIntentId]
        );

        return $capture;
    }

    public static function presentPaymentMethod()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $response = $stripe->testHelpers->terminal->readers->presentPaymentMethod(
            env('STRIPE_READER_ID')
        );

        return $response;
    }

    public function handleWebhook(Request $request)
    {
        Log::info('webhook working');
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');
        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);

            $paymentIntent = $event->data->object;
            $order = Order::where('id', $paymentIntent->metadata->order_id)->first();

            if ($order) {
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
            }
            $json = [];
            // Handle the event
            switch ($event->type) {
                case 'payment_intent.succeeded':
                    if ($order) {
                        $order->status = 'completed';

                        $order->save();
                        $order->load('user');

                        $invoice = $order->generateInvoice();
                        $order->sendInvoice($order, $invoice);
                        $json = [
                            'status' => 'success',
                        ];
                    }
                    break;
                case 'payment_intent.payment_failed':
                case 'payment_intent.canceled':
                    if ($order) {
                        $order->status = 'canceled';
                        $order->save();
                        $order->load('user');
                    }
                $json = [
                    'status' => 'canceled',
                ];
                    break;
            }
            return response()->json($json);
        } catch (\UnexpectedValueException $e) {
            Log::info(json_encode($e->getMessage()));
            return response()->json(['status' => 'invalid_payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::info(json_encode($e->getMessage()));
            return response()->json(['status' => 'invalid_signature'], 400);
        }
    }

    public function cancelPaymentIntent(Request $request)
    {
        $paymentIntentId = $request->input('payment_intent_id');

        if ($paymentIntentId) {
            try {
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $cancelIntent = $stripe->paymentIntents->cancel($paymentIntentId);
                return response()->json(['success' => true, 'message' => 'Payment canceled successfully.']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to cancel payment: ' . $e->getMessage()]);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Payment intent ID is missing.']);
        }
    }

    public function refundPayment($order, $amount = null)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $refundParams = [];
        try {
            if($order->payment_intent_id){
                $refundParams = ['payment_intent' => $order->payment_intent_id];
            }elseif ($order->stripe_order_id){
                $refundParams = ['charge' => $order->stripe_order_id];
            }

            if ($amount) {
                $amount = (int) ($amount * 100);
                $refundParams['amount'] = $amount;
            }

            $refund = $stripe->refunds->create($refundParams);

            return $refund;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

}
