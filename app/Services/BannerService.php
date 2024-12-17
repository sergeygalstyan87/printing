<?php
namespace App\Services;

use App\Models\Banner;

class BannerService
{

    public function getItem($id){
        return Banner::find($id);
    }

    public function getItems(){
        return Banner::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        $data = $this->image($data);
        Banner::create($data);
    }

    public function update($data, $id){
        $item = $this->getItem($id);
        $data = $this->image($data);
        $item->update($data);
    }

    public function delete($id){
        $item = $this->getItem($id);
        $item->delete();
    }

    public function image($data){
        $data['image'] = !is_string($data['image']) ? upload($data['image']) : $data['image'];
        if(isset($data['mobile_image'])){
            $data['mobile_image'] = !is_string($data['mobile_image']) ? upload($data['mobile_image']) : $data['mobile_image'];
        }
        if(isset($data['tablet_image'])){
            $data['tablet_image'] = !is_string($data['tablet_image']) ? upload($data['tablet_image']) : $data['tablet_image'];
        }
        return $data;
    }
}
