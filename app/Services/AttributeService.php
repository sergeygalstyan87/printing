<?php
namespace App\Services;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Support\Facades\DB;

class AttributeService
{

    public function getItem($id){
        return Attribute::find($id);
    }

    public function getItems(){
        return Attribute::orderBy('id', 'DESC')->get();
    }

    public function getItemsFirst($ids){
        if(!empty($ids)){
            $tempStr = implode(',', $ids);
            $ordered = collect(Attribute::whereIn('id', $ids)->orderByRaw(DB::raw("FIELD(id, $tempStr)"))->get());
        }else{
            $ordered = collect();
        }
        $not_ordered = collect(Attribute::whereNotIn('id', $ids)->get());
        return $ordered->merge($not_ordered);
    }

    public function getByProduct($id){
        $product = Product::with('attributes')->find($id);
        $attributes = $product->attributes;
        return $attributes;
    }

    public function create($data){
        Attribute::create($data);
    }

    public function update($data, $id){
        if(!isset($data['is_crude'])){
            $data['is_crude'] = 0;
        }
        if(!isset($data['is_apparel'])){
            $data['is_apparel'] = 0;
        }
        if(!isset($data['is_multiple'])){
            $data['is_multiple'] = 0;
        }
        if(!isset($data['is_show_on_upload'])){
            $data['is_show_on_upload'] = 0;
        }

        $item = $this->getItem($id);
        $item->update($data);
    }

    public function delete($id){
        $item = $this->getItem($id);
        $sql = "select id, detail_info from products where detail_info is not null";
        $products = DB::select($sql);
        foreach($products as $p){
            $details = json_decode($p->detail_info,true);
            if(isset($details[$item->id])){
                unset($details[$item->id]);

                if(!empty($details)){
                    $d = json_encode($details);
                    $sql_update = "update products set detail_info = '{$d}' where id={$p->id}";
                }else{
                    $sql_update = "update products set detail_info = null where id={$p->id}";
                }


                DB::update($sql_update);
            }
        }
        $item->delete();
    }
}
