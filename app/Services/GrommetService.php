<?php
namespace App\Services;

use App\Models\Grommet;

class GrommetService
{

    public function getItem($id){
        return Grommet::find($id);
    }

    public function getItems(){
        return Grommet::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        Grommet::create($data);
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
