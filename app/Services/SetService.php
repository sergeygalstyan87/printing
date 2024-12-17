<?php
namespace App\Services;

use App\Models\Set;

class SetService
{

    public function getItem($id){
        return Set::find($id);
    }

    public function getItems(){
        return Set::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        return Set::create($data);
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
