<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class CategoryService
{

    public function getItem($id){
        return Category::find($id);
    }

    public function getItems(){
        return Category::orderBy('id', 'DESC')->get();
    }

    public function create($data){
        Category::create($data);
    }

    public function update($data, $id){
        $item = $this->getItem($id);
        $item->update($data);
        if(isset($data['design_price'])) {
           Product::where('subcategory_id', $id)
               ->where('design_price', 0)
               ->update(['design_price' => $data['design_price']]);
        }

        $products = $data['products'] ?? [];
        $item->menu_products()->sync($products);
    }

    public function delete($id){
        $item = $this->getItem($id);
        $item->childs()->delete();
        $item->delete();
    }

    public function getParents(){
        return Category::where('parent', 0)->get();
    }

    public function getSubcategories(){
        return Category::where('parent', '!=' , 0)->get();
    }
}
