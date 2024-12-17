<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvoiceByRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $invoiceFullPath;
    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoiceFullPath, $order)
    {
        $this->invoiceFullPath = $invoiceFullPath;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = json_decode($this->order->attrs,true);

        return $this->view('emails.sendInvoiceByRequest')
            ->subject('Your Order with YansPrint')
            ->with(['order' => $this->order, 'details' => $details])
            ->attach(
                $this->invoiceFullPath,
                [
                    'as' => 'invoice.pdf',
                    'mime' => 'application/pdf',
                ]
            );
    }
}
