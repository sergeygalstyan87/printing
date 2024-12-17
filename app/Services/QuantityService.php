<?php
namespace App\Services;

use App\Models\Quantity;
use Illuminate\Support\Facades\DB;

class QuantityService
{

    public function getItem($id){
        return Quantity::find($id);
    }

    public function getItems(){
        return Quantity::orderBy('number', 'asc')->get();
    }

    public function getItemsFirst($ids){

        if(!empty($ids)){
            $tempStr = implode(',', $ids);
            $ordered = collect(Quantity::whereIn('id', $ids)->orderByRaw(DB::raw("FIELD(id, $tempStr)"))->get());
        }else{
            $ordered = collect();
        }
        $not_ordered = collect(Quantity::whereNotIn('id', $ids)->get());

        return $ordered->merge($not_ordered);
    }

    public function create($data){
        Quantity::create($data);
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
