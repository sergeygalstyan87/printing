<?php
namespace App\Services;

use App\Models\Review;

class ReviewService
{

    public function getItem($id){
        return Review::find($id);
    }

    public function getItems(){
        return Review::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        $data = $this->image($data);
        Review::create($data);
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
        return $data;
    }
}
