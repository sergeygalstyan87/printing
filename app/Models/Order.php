<?php

namespace App\Models;

use App\Mail\SendInvoice;
use App\Mail\SendInvoiceByRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'job_name',
        'notes',
        'images',
        'amount',
        'help_with_file',
        'proofing_options',
        'changes',
        'user_id',
        'first_name',
        'last_name',
        'company',
        'email',
        'phone',
        'address',
        'unit',
        'city',
        'state',
        'zip',
        'address_id',
        'delivery_type',
        'product_id',
        'quantity_id',
        'delivery_id',
        'coupon_id',
        'payment_type',
        'track_number',
        'track_number_link',
        'delivery_status',
        'attrs',
        'tax',
        'original_amount',
        'price',
        'shipping_price',
        'shipping_provider',
        'qty',
        'shipping_provider_id',
        'invoice_number',
        'invoice_path',
        'invoice_sent',
        'status',
        'is_custom',
        'est_number',
        'payment_intent_id'
    ];

    protected $with = ['proof', 'delivery'];

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        return json_decode($value);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function delivery(){
        return $this->hasOne(Delivery::class, 'id', 'delivery_id');
    }

    public function coupon(){
        return $this->hasOne(Coupon::class, 'id', 'coupon_id');
    }

    public function quantity(){
        return $this->hasOne(Quantity::class, 'id', 'quantity_id');
    }

    public function proof() {
        return $this->hasOne(OrdersProof::class, 'order_id', 'id');
    }

    public function shipping_address(){
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    public function attributes(){
        return $this->belongsToMany(Type::class, 'order_attributes', 'order_id', 'type_id');
    }

    public function setInvoiceNumber(){
        $number = 'YP';
        $formattedInvoiceNumber = $number.str_pad($this->id, 6, '0', STR_PAD_LEFT);
        $this->invoice_number = $formattedInvoiceNumber;

    }

    public function generateInvoice(){
        $this->setInvoiceNumber();
        $item = $this;
        $details = json_decode($this->attrs,true);

        if(isset($details['delivery_id']) &&  ($details['delivery_id'] > 0)){
            $sql = "select title from deliveries where id={$details['delivery_id']}";
            $details['types']['Production Time'] = DB::selectOne($sql)->title;

        }
        if(!empty($details['coupon'])){
            $details['types'][$details['coupon']['name']] = $details['coupon']['percent'].'%';

        }
        $deliveries = Delivery::find($item->delivery_id);
        $newDate = null;
        if($deliveries){
            $newDate = Carbon::parse($this->created_at)->addDays($deliveries->days);
        }
        $pdf = PDF::loadView('front.pages.invoice', compact('item','details', 'newDate'));
        $pdfContent = $pdf->output();

        $fileName = 'invoice_' . uniqid() . '.pdf';
        $this->invoice_path = $fileName;
        $this->save();
        Storage::put('invoice/' . $fileName, $pdfContent);
        return $fileName;
    }

    public function sendInvoice($order, $invoice)
    {
        if ($order->user_id) {
            $email = $order->user->email;
        } else {
            $email = $order->email;
        }
        $email = $order->email;
        $invoiceFullPath = storage_path('app/public/invoice/' . $invoice);

        Mail::to($email)->send(new SendInvoice($invoiceFullPath, $order));
        $order->update(['invoice_sent'=>date('Y-m-d H:i:s')]);
    }

    public function sendInvoiceBYRequest($order, $invoice)
    {
        if ($order->user_id) {
            $email = $order->user->email;
        } else {
            $email = $order->email;
        }
        $email = $order->email;
        $invoiceFullPath = storage_path('app/public/invoice/' . $invoice);

        Mail::to($email)->send(new SendInvoiceByRequest($invoiceFullPath, $order));
        $order->update(['invoice_sent'=>date('Y-m-d H:i:s')]);
    }

    public function generateEstNumberInfo(){
        return 'E'.str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getProgress(){
        if($this->proof_approved == 0){
            return 0;
        }else{
            if($this->delivery_status == 0){
                return 25;
            }elseif($this->delivery_status == 1){
                return 50;
            }elseif($this->delivery_status == 2){
                return 75;
            }elseif($this->delivery_status == 3 || $this->delivery_status == 4){
                return 100;
            }
        }
        }

        public function getNewOrdersCount(){
            $query = self::query();
            $query->where('status', 'completed')->where('proof_approved',0);
            $result = $query->count();
            return $result;
        }

    public function getReadyToStartCount(){
        $query = self::query();
        $query->where('status', 'completed')->where('proof_approved',1)->where('delivery_status',0);
        $result = $query->count();
        return $result;
    }

    public function getInProgressCount(){
        $query = self::query();
        $query->whereIn('delivery_status',[1,2]);
        $result = $query->count();
        return $result;
    }

    public function getOrderRequestsCount(){
        $query = self::query();
        $query->where('status', 'customRequest');
        $result = $query->count();
        return $result;
    }

}
