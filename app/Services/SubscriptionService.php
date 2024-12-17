<?php

namespace App\Services;

use App\Models\Subscription;

class SubscriptionService
{
    public function getItem($id){
        return Subscription::find($id);
    }
    public function getItemByEmail($email){
        return Subscription::where('email', $email)->first();
    }

    public function getItems(){
        return Subscription::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        Subscription::create($data);
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