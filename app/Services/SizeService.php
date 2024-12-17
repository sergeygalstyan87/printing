<?php
namespace App\Services;

use App\Models\ProductSize;
use App\Models\Size;

class SizeService
{

    public function getItem($id){
        return Size::find($id);
    }

    public function getItems(){
        return Size::orderBy('id', 'DESC')->get();
    }
    public function getCoreItems(){
        return Size::orderBy('id', 'DESC')->get()->where('core_size',1);
    }

    public function getByIds($ids){
        return ProductSize::whereIn('size_id', $ids)->get();
    }

    public function create($data){
        $data = $this->generateSizes($data);
        Size::create($data);
    }
    public function update($data, $id){
        $item = $this->getItem($id);
        $data = $this->generateSizes($data);
        $item->update($data);
    }
    public function delete($id){
        $item = $this->getItem($id);
        $item->delete();
    }
    public function generateSizes($data){
        $data['ft'] = $data['ft_width'] . ' x ' . $data['ft_height'];
        $data['in'] = $data['in_width'] . ' x ' . $data['in_height'];
        if(isset($data['core_size']) && $data['core_size'] == 1){
            $data['core_size'] = 1;
        }else{
            $data['core_size'] = 0;
        }
        return $data;
    }
}
