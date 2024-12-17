<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDeclineEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $email;
    public $message;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $email, $message)
    {
        $this->order = $order;
        $this->email = $email;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = json_decode($this->order->attrs,true);

            return $this->view('emails.delineOrderMessage')
                ->subject('Your order was declined!')
                ->with(['order' => $this->order, 'details' =>$details,'messages'=>$this->message]);

    }
}
