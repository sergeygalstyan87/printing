<?php
namespace App\Services;

use App\Models\UploadedFileType;

class UploadedFileTypesService
{

    public function getItem($id){
        return UploadedFileType::find($id);
    }

    public function getItems(){
        return UploadedFileType::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        UploadedFileType::create($data);
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
