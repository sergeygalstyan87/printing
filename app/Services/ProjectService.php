<?php
namespace App\Services;


use App\Models\Project;

class ProjectService
{

    public function getItem($id){
        return Project::with(['basket', 'sets'])->find($id);
    }

    public function getItems(){
        return Project::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        return Project::create($data);
    }

    public function update($data, $id){
        $item = $this->getItem($id);
        return $item->update($data);
    }

    public function delete($id){
        $item = $this->getItem($id);
        $item->delete();
    }
}
