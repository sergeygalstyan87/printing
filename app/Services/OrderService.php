<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrdersProof;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;

class OrderService
{

    public function getItem($id){
        return Order::find($id);
    }

    public function getItems(){
        return Order::orderBy('id', 'DESC')->get();
    }

    public function getProof($id){
        return OrdersProof::where(['order_id' => $id])->first();
    }

    public function getProofById($id){
        return OrdersProof::find($id);
    }

    public function getItemsWithDeliveryStatus($status_number){

        if (is_array($status_number)) {
            return Order::whereIn('delivery_status', $status_number)
                ->whereIn('status', ['completed'])
                ->orderBy('id', 'DESC')->get();
        } else {
            return Order::where('delivery_status', $status_number)
                ->whereIn('status', ['completed'])
                ->orderBy('id', 'DESC')->get();
        }
    }

    public function getNewOrders($offset = 10, $limit = 10){
        $ordersQuery= Order::where('delivery_status', 0)
            ->whereIn('status', ['completed'])
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->orderBy('orders.id', 'DESC');

        $totalCount = $ordersQuery->count();

        $orders = $ordersQuery
            ->select(
                'orders.id',
                'orders.created_at',
                DB::raw('`products`.`title` as product')
            )
            ->offset($offset)
            ->limit($limit)
            ->get();

        return ['data' => $orders, 'recordsFiltered' => $totalCount];
    }
    public function getItemsWithStatus(){

        return Order::whereIn('delivery_status', [3, 4])
            ->orWhereIn('status', ['pending','canceled'])
            ->orderBy('id', 'DESC')->get();
    }
    public function create($data){
        $order = Order::create($data);
        $order->update(['est_number' => $order->generateEstNumberInfo()]);
        return $order;
    }

    public function update($data, $id){
        $item = $this->getItem($id);
        $item->update($data);
        return $item;
    }

    public function setOrderProof($data, $id){
        $proof = $this->getProof($id);

        DB::beginTransaction();
        try {
            if (isset($proof)) {
                deleteOrderProof($proof->file);
                $proof->file = '';
            } else {
                $proof = new OrdersProof();
                $proof->order_id = $id;
            }

            $file_name = uploadOrderProof($data);

            $proof->file = $file_name;
            $proof->save();

            DB::commit();
            return $proof;
        } catch(\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteOrderProof($id) {
        DB::beginTransaction();
        try {
            $proof = $this->getProofById($id);
            $proof->delete();
            deleteOrderProof($proof->file);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id){
        $item = $this->getItem($id);
        $item->delete();
    }

    public function getUserCustomOrders($user_id) {
        return Order::where('user_id', $user_id)->where('is_custom', 1)->whereNotIn('delivery_status', [3, 4])->get();
    }
}
