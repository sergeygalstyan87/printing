<?php
namespace App\Services;

use App\Models\Question;

class QuestionService
{

    public function getItem($id){
        return Question::with('product')->find($id);
    }

    public function getItems(){
        return Question::orderBy('id', 'DESC')->with('product')->get();
    }

    public function create($data){
        Question::create($data);
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
