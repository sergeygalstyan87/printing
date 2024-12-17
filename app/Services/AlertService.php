<?php
namespace App\Services;

use App\Models\Alert;

class AlertService
{

    public function getItem($id){
        return Alert::find($id);
    }

    public function getItems(){
        return Alert::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        if(isset($data['is_bold']) && $data['is_bold']==='on'){
            $data['is_bold'] =  1;
        }else{
            $data['is_bold'] = 0;
        }

        if(!empty($data['title'])){
            $data['title'] = str_replace('<p>','',$data['title']);
            $data['title'] = str_replace('</p>','',$data['title']);
        }
        if(!empty($data['secondary_text'])){
            $data['secondary_text'] = str_replace('<p>','',$data['secondary_text']);
            $data['secondary_text'] = str_replace('</p>','',$data['secondary_text']);
        }
        Alert::create($data);
    }

    public function update($data, $id){
        $item = $this->getItem($id);
        if(isset($data['is_bold']) && $data['is_bold']==='on'){
            $data['is_bold'] =  1;
        }else{
            $data['is_bold'] = 0;
        }
        if(!empty($data['title'])){
            $data['title'] = str_replace('<p>','',$data['title']);
            $data['title'] = str_replace('</p>','',$data['title']);
        }
        if(!empty($data['secondary_text'])){
            $data['secondary_text'] = str_replace('<p>','',$data['secondary_text']);
            $data['secondary_text'] = str_replace('</p>','',$data['secondary_text']);
        }
        $item->update($data);
    }

    public function delete($id){
        $item = $this->getItem($id);
        $item->delete();
    }
}
