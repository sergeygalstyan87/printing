<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Mail\OrderStatusEmail;
use App\Models\Order;
use App\Models\OrdersProof;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class TrelloController extends Controller
{
    public static function getLists(){
        $api_key = env('TRELLO_API_KEY');
        $token = env('TRELLO_TOKEN');
        $board_id = env('TRELLO_BOARD_ID');
        $response = Http::get("https://api.trello.com/1/boards/$board_id/lists", [
            'key' => $api_key,
            'token' => $token,
        ]);

        return $response->json();
    }

    public static function addCard($order){
        $api_key = env('TRELLO_API_KEY');
        $token = env('TRELLO_TOKEN');

        $list_id = self::getLists()[0]['id'];

        $desc = self::convertToMarkdown($order);
        $response = Http::post("https://api.trello.com/1/cards", [
            'idList' => $list_id,
            'key' => $api_key,
            'token' => $token,
            'name' => $order->est_number,
            'desc' => $desc,
        ]);

        $card_id = $response->json()['id'];

        $proof = OrdersProof::where(['order_id' => $order->id])->first();
        if($proof){
            $file_path = public_path('storage/content/proofs/'.$proof->file);
            if ($file_path && $proof->file) {
                self::uploadFileToCard($card_id, $file_path, $proof->file);
            }
        }

        self::createWebHook($card_id);
    }

    protected static function convertToMarkdown($order)
    {
        $descriptionData = json_decode($order->attrs, true);
        $markdown = "### Order Details\n\n";
        $markdown .= "**Product:** {$order->product->title}\n";
        $markdown .= "**Quantity:** {$descriptionData['quantity']}\n";
        $markdown .= "**Delivery Type:** {$order->delivery_type}\n";
        if($order->delivery){
            $markdown .= "**Production days:** {$order->delivery->days}\n";
        }
        if($order->shipping_provider_id){
            $rate = OrderController::get_shipping_rates_data($order->shipping_provider_id);
            $shipping_method = $rate['text'] . ': ' . $rate['terms'];
            $markdown .= "**Shipping method:** {$shipping_method }\n";
        }

        $markdown .= "\n### Types\n";
        foreach ($descriptionData['types'] as $key => $value) {
            $markdown .= "**{$key}:** {$value}\n";
        }

        return $markdown;
    }

    protected static function uploadFileToCard($card_id, $file_path, $file_name)
    {
        $api_key = env('TRELLO_API_KEY');
        $token = env('TRELLO_TOKEN');

        $response = Http::attach(
            'file', file_get_contents($file_path), $file_name
        )->post("https://api.trello.com/1/cards/{$card_id}/attachments", [
            'key' => $api_key,
            'token' => $token,
        ]);

        return $response->json();
    }

    public static function createWebHook($card_id){
        $api_key = env('TRELLO_API_KEY');
        $token = env('TRELLO_TOKEN');
        $callbackUrl = route('trelloCallback');
        $response = Http::post("https://api.trello.com/1/tokens/{$token}/webhooks/", [
            'key' => $api_key,
            'callbackURL' => $callbackUrl,
            'idModel' => $card_id,
            'description' => "Webhook for card's list update",
        ]);
    }

    public function trelloCallback(Request $request)
    {
        $data = $request->all();
        $est_number = $data['action']['data']['card']['name'];
        $order = Order::where('est_number', $est_number)->first();

        $response_data = $data['action']['data'];
        if(isset($response_data['listAfter'])){
            $order_delivery_status = $data['action']['data']['listAfter']['name'];
            $delivery_status = null;
            switch ($order_delivery_status){
                case 'Design & Prespress':
                    $delivery_status= 0;
                    break;
                case 'Production':
                    $delivery_status= 1;
                    break;
                case 'Ready':
                    $delivery_status= 2;
                    break;
                case 'Pick Up':
                    $delivery_status= 3;
                    break;
                case 'Shipping':
                    $delivery_status= 4;
                    break;
            }
            $order->update(['delivery_status' => $delivery_status]);
            if($order->delivery_status == 3 || $order->delivery_status == 4){
                if ($order->user_id) {
                    $user = User::where('id', $order->user_id)->first();
                    $email = $user->email;
                } else {
                    $email = $order->email;
                }
                Mail::to($email)->send(new OrderStatusEmail($order, $email));
            }
        }
    }

    public function handleHead(Request $request)
    {
        return response()->noContent(200);
    }
}
