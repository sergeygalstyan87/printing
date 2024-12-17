<?php
namespace App\Services;

use App\Models\Detail;

class DetailService
{

    public function getItem($id){
        return Detail::find($id);
    }

    public function getItems(){
        return Detail::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        $data['default'] = !count(auth()->user()->addresses);
        Detail::create($data);
    }

    public function update($data, $id){
        $item = $this->getItem($id);
        $item->update($data);
    }

    public function delete($id){
        $item = $this->getItem($id);
        if($item->default){
            $address = Detail::where('id', '!=', $id)->where('user_id', auth()->user()->id)->first();
            if($address){
                $address->update(['default' => 1]);
            }
        }
        $item->delete();
    }

    public function default($id){
        Detail::where('default', 1)->update(['default' => 0]);
        $this->getItem($id)->update(['default' => 1]);
    }
}
