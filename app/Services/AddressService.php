<?php
namespace App\Services;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressService
{

    public function getItem($id){
        return Address::find($id);
    }

    public function getItems(){
        return Address::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        if(!isset($data['default'])){
            $data['default'] = !count(auth()->user()->addresses);
        }

        $address = Address::create($data);
        if(isset($data['default']) && $data['default'] == 'on'){
            $this->default($address->id);
        }

        return $address;
    }

    public function update($data, $id){
        $item = $this->getItem($id);
        $item->update($data);

        if(isset($data['default']) && $data['default'] == 'on'){
            $this->default($item->id);
        }

        return $item;
    }

    public function delete($id){
        $item = $this->getItem($id);
        if($item->default){
            $address = Address::where('id', '!=', $id)->where('user_id', auth()->user()->id)->first();
            if($address){
                $address->update(['default' => 1]);
            }
        }
        $item->delete();
    }

    public function default($id){
        $user = Auth::user();
        Address::where('default', 1)->where('user_id', $user->id)->update(['default' => 0]);
        $this->getItem($id)->update(['default' => 1]);
    }
}
