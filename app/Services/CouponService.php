<?php
namespace App\Services;

use App\Models\Coupon;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CouponService
{

    public function getItem($id){
        return Coupon::find($id);
    }

    public function getItems(){
        return Coupon::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        if($data['datefilter']){
            $filterDateRange = explode(' - ', $data['datefilter']);

            if (is_array($filterDateRange) && count($filterDateRange) === 2) {
                $startDate = Carbon::createFromFormat('m/d/Y', trim($filterDateRange[0]));
                $endDate = Carbon::createFromFormat('m/d/Y', trim($filterDateRange[1]));

                $data['start_date'] = $startDate;
                $data['end_date'] = $endDate;
            }
        }

        Coupon::create($data);
    }

    public function update($data, $id){
        $item = $this->getItem($id);
        if(isset($data['datefilter']) && $data['datefilter']){
            $filterDateRange = explode(' - ', $data['datefilter']);

            if (is_array($filterDateRange) && count($filterDateRange) === 2) {
                $startDate = Carbon::createFromFormat('m/d/Y', trim($filterDateRange[0]));
                $endDate = Carbon::createFromFormat('m/d/Y', trim($filterDateRange[1]));

                $data['start_date'] = $startDate;
                $data['end_date'] = $endDate;
            }
        }
        $item->update($data);
    }

    public function delete($id){
        $item = $this->getItem($id);
        $item->delete();
    }

    public function getByName($name){
        $coupon = Coupon::where('name', $name)->first();
//        if($coupon){
//            if($coupon->limit >= 0){
//                return $coupon;
//            }else{
//                $orders_count = Order::where('coupon_id', $coupon->id)->get()->count();
//                if($coupon->limit > $orders_count){
//                    return $coupon;
//                }else{
//                    return 0;
//                }
//            }
//        }else{
//            return 0;
//        }
        return $coupon;
    }

    public function checkAvailableCoupon(Coupon $coupon){
        if($coupon->limit == 0){
            return 1;
        }
        if (($coupon->limit - $coupon->used) > 0) {
            $currentDate = Carbon::now()->startOfDay();

            if (isset($coupon->start_date) && isset($coupon->end_date)) {
                $couponStartDate = Carbon::parse($coupon->start_date)->startOfDay();
                $couponEndDate = Carbon::parse($coupon->end_date)->endOfDay();

                if ($couponStartDate >= $currentDate || $couponEndDate <= $currentDate) {
                    return 0;
                }
            }
            return 1;
        } else {
            return 0;
        }
    }
}
