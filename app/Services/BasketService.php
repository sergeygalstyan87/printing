<?php
namespace App\Services;

use App\Models\Basket;

class BasketService
{
    public function getItem($id){
        return Basket::find($id);
    }

    public function getItems(){
        return Basket::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        return Basket::create($data);
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
