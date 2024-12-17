<?php
namespace App\Services;

use App\Models\User;

class UserService
{

    public function getItem($id){
        return User::find($id);
    }

    public function getItems(){
        return User::orderBy('id', 'DESC')->get();
    }
    public function getItemsWithRoles($role_id){
        return User::orderBy('id', 'DESC')->whereIn('role_id', $role_id)->get();
    }

    public function create($data){
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        return $user;
    }

    public function update($data, $id){
        $item = $this->getItem($id);
        if(isset($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }
        $item->update($data);

        return $item;
    }

    public function delete($id){
        $item = $this->getItem($id);
        $item->delete();
    }
}
