<?php

namespace App\Models;

use App\Mail\SendInvoice;
use App\Mail\SendInvoiceByRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersProof extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'file',
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
