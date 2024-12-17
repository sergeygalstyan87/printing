<?php
namespace App\Services;

use App\Models\Type;
use Illuminate\Support\Facades\DB;

class TypeService
{

    public function getItem($id){
        return Type::find($id);
    }

    public function getItems(){
        return Type::orderBy('id', 'DESC')->get();
    }

    public function getByIds($ids){
        return Type::whereIn('id', $ids)->get();
    }

    public function getItemsFirst($ids){
        if(!empty($ids)){
            $tempStr = implode(',', $ids);
            $ordered = collect(Type::whereIn('id', $ids)->orderByRaw(DB::raw("FIELD(id, $tempStr)"))->get());
        }else{
            $ordered = collect();
        }
        $not_ordered = collect(Type::whereNotIn('id', $ids)->get());
        return $ordered->merge($not_ordered);
    }

    public function getByAttribute($id){
        return Type::where('attribute_id', $id)->get();
    }

    public function create($data){
        if($data['attribute_id'] == 2){
            $data['price_keys'] = null;
            $data['full_paper'] = 0;
        }else{
            if(isset($data['full_paper']) && $data['full_paper'] == 1){
                if(!empty($data['sizes'])){
                    foreach($data['sizes'] as $key=>$val){
                        if($val['price'] == 0){
                            unset($data['sizes'][$key]);
                        }
                    }
                }
                $data['price_keys'] = json_encode($data['sizes']);
            }elseif(isset($data['full_paper']) && $data['full_paper'] == 2){
                $data['price_keys'] = null;
                $data['price'] = $data['price_sqr'];
            }else{
                $data['price_keys'] = null;
            }
            $data['size_id'] = null;
            $data['size_id'] = null;
        }
        if(isset($data['rel_attributes']) && $data['rel_attributes'] == 1){
            if(!empty($data['related_attributes'])){
                $data['related_attributes'] = json_encode($data['related_attributes']);
            }
        }else{
            $data['related_attributes'] = null;
        }

        if (isset($data['type_details']['image'])) {
            $imagePath = upload($data['type_details']['image']);
            $data['type_details']['image'] = $imagePath;
        }

        if (isset($data['img'])) {
            $imagePath = upload_type_img($data['img']);
            $data['img'] = $imagePath;
        }


        Type::create($data);
    }

    public function update($data, $id){

        $item = $this->getItem($id);
        if(!isset($data['both_sides'])){
            $data['both_sides'] = 0;
        }

        if($data['attribute_id'] == 2){
            $data['price_keys'] = null;
            $data['full_paper'] = 0;
            $data['price'] = 0;
        }else{
            if(isset($data['full_paper']) && $data['full_paper'] == 1){
                if(!empty($data['sizes'])){
                    foreach($data['sizes'] as $key=>$val){
                        if($val['price'] == 0){
                            unset($data['sizes'][$key]);
                        }
                    }
                }
                $data['price_keys'] = json_encode($data['sizes']);
            }elseif(isset($data['full_paper']) && $data['full_paper'] == 2){
                $data['price_keys'] = null;
                $data['price'] = $data['price_sqr'];
            }else{
                $data['price_keys'] = null;
            }
            $data['size_id'] = null;
        }
        if(isset($data['rel_attributes']) && $data['rel_attributes'] == 1){
            if(!empty($data['related_attributes'])){
                $data['related_attributes'] = json_encode($data['related_attributes']);
            }
        }else{
            $data['related_attributes'] = null;
        }

        if (isset($data['type_details']['image'])) {
            $imagePath = !is_string($data['type_details']['image']) ? upload($data['type_details']['image']) : $data['type_details']['image'];
            $data['type_details']['image'] = $imagePath;
        }
        if (isset($data['img'])) {
            $imagePath = !is_string($data['img']) ? upload_type_img($data['img']) : $data['img'];
            $data['img'] = $imagePath;
        }

        $item->update($data);
    }
    public function delete($id){
        $item = $this->getItem($id);


        $sql = "select id, detail_info from products where detail_info is not null";
        $products = DB::select($sql);
      foreach($products as $p){
          $details = json_decode($p->detail_info,true);
          if(isset($details[$item->attribute_id])){
              $key = array_search($id, $details[$item->attribute_id]);

// If the value is found, unset the element
              if ($key !== false) {
                  unset($details[$item->attribute_id][$key]);
              }
              if(empty($details[$item->attribute_id])){
                  unset($details[$item->attribute_id]);
              }
              $d = json_encode($details);
              $sql_update = "update products set detail_info = '{$d}' where id={$p->id}";
              DB::update($sql_update);
          }
      }
        $item->delete();
    }

}
