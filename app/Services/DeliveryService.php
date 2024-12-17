<?php
namespace App\Services;

use App\Models\Delivery;

class DeliveryService
{

    public function getItem($id){
        return Delivery::find($id);
    }

    public function getItems(){
        return Delivery::orderBy('id', 'DESC')->get();
    }

    public function getByPrice($price){
        return Delivery::where('price', $price)->first();
    }
    public function getByPriceAndProduct($price, $product_id){
        return Delivery::where('price', $price)->where('product_id', $product_id)->first();
    }

    public function create($data){
        Delivery::create($data);
    }

    public function update($data, $id){
        $item = $this->getItem($id);
        $item->update($data);
    }

    public function delete($id){
        $item = $this->getItem($id);
        $item->delete();
    }
}
