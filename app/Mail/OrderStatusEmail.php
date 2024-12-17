<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $email;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $email)
    {
        $this->order = $order;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = json_decode($this->order->attrs,true);

        if($this->order->delivery_status == 3){
            return $this->view('emails.notifyPickUpOrderStatus')
                ->subject('Your Order is Ready for Pickup!')
                ->with(['order' => $this->order, 'details' =>$details]);
        }else if ($this->order->delivery_status == 4){
            return $this->view('emails.notifyShippedOrderStatus')
                ->subject('Your Order is On Its Way!')
                ->with(['order' => $this->order, 'details' =>$details]);
        }
    }
}
