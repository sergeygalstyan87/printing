<?php
namespace App\Services;

use App\Models\Slider;

class SliderService
{

    public function getItem($id){
        return Slider::find($id);
    }

    public function getItems(){
        return Slider::orderBy('id', 'DESC')->with('category')->get();
    }

    public function getItemsWithCategory($categoryId=null){
        return Slider::orderBy('id', 'DESC')
            ->with('category')
            ->where('page_category_id', $categoryId)
            ->get();
    }

    public function getItemsWithCategoryMobile($categoryId=null){
        return Slider::orderBy('id', 'DESC')
            ->with('category')
            ->where('page_category_id', $categoryId)
            ->whereNotNull('mobile_image')
            ->get();
    }
    public function getItemsWithCategoryTablet($categoryId=null){
        return Slider::orderBy('id', 'DESC')
            ->with('category')
            ->where('page_category_id', $categoryId)
            ->whereNotNull('tablet_image')
            ->get();
    }

    public function create($data){
        $data = $this->image($data);
        Slider::create($data);
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
