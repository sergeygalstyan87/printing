<?php
namespace App\Services;

use App\Models\Setting;

class SettingService
{

    public function getItem($id){
        return Setting::find($id);
    }

    public function getItems(){
        return Setting::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        Setting::create($data);
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
