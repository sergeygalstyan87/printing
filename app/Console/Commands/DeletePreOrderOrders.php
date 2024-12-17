<?php

namespace App\Console\Commands;

use App\Http\Controllers\Front\GoogleDriveController;
use App\Models\Coupon;
use App\Models\Order;
use App\Services\CouponService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeletePreOrderOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:delete-pre-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete pre-order status orders older than one hour';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::warning("Starting to delete all junk orders");
        $timeThreshold = Carbon::now()->subHour();

        $deletedOrderIds = Order::where('status', 'preOrder')
            ->where('created_at', '<', $timeThreshold)
            ->pluck('id');

        foreach ($deletedOrderIds as $id) {
            $order = Order::find($id);
            Log::warning("Deleting order with ID: " . $id);

            if ($order) {
                if ($order->coupon_id) {
                    $coupon = Coupon::find($order->coupon_id);
                    if ($coupon) {
                        $coupon->used = $coupon->used - 1;
                        $coupon->save();
                    }
                }
                $order->forceDelete();
                Log::info("Deleted order with ID: " . $id);
            }
        }

        foreach ($deletedOrderIds as $orderId) {
            Log::warning("Deleting order folder from Google Drive with ID: " . $id);
            GoogleDriveController::deleteFolder($orderId);
            Log::info("Deleted order folder from Google Drive with ID: " . $id);
        }

        Log::info("Successfully deleted all junk orders");

        return 0;
    }
}
