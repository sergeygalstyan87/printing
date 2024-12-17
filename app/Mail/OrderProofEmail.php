<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class OrderProofEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $file;
    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($file_name, $order)
    {
        $this->file = public_path() . '/storage/content/proofs/'.$file_name;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Proof for Order " . $this->order->est_number;
        return $this->view('emails.order-proof')
            ->subject($subject)
            ->with(['order' => $this->order])
            ->attach(
                $this->file,
                [
                    'as' => 'order_proof.pdf',
                    'mime' => 'application/pdf',
                ]
            );
    }
}
