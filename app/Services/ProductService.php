<?php
namespace App\Services;

use App\Models\Delivery;
use App\Models\Detail;
use App\Models\Input;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{

    public function getItem($id){
        return Product::find($id);
    }

    public function getItemsWithoutStock(){
        return Product::orderBy('id', 'DESC')->get();
    }
    public function getItems(){
        return Product::where('stock', 1)->orderBy('id', 'DESC')->get();
    }

    public function getByCount($count){
        return Product::where('stock', 1)->limit($count)->orderBy('id', 'DESC')->get();
    }

    public function getByCategory($id){
        return Product::where('stock', 1)->where('category_id', $id)->orderBy('order', 'ASC')->paginate(8);
    }

    public function getByCategoryAll($id){
        return Product::where('category_id', $id)->orWhere('subcategory_id',$id)->orderBy('order','asc')->get();
    }

    public function getCategoryCount($id){
        return Product::where('stock', 1)->where('category_id', $id)->orWhere('subcategory_id',$id)->orderBy('order','asc')->get()->count();
    }

    public function getBySlug($slug){
        return Product::where('slug', $slug)->first();
    }

    public function getRelated($product, $count =  4){
        $products = Product::where('stock', 1)->where('category_id', $product->category_id)->whereNotIn('id', [$product->id])->limit($count)->get();
        if(count($products) < $count){
            $qnt = $count - count($products);
            $ids = [$product->id];
            foreach ($products as $product){
                $ids[] = $product->id;
            }
            $randoms = Product::where('stock', 1)->inRandomOrder()->limit($qnt)->whereNotIn('id', $ids)->get();
            $products = $products->merge($randoms);
        }
        return $products;
    }

    public function create($data){
        $data = $this->images($data);
        if(isset($data['quantity_discount']) && !empty($data['quantity_discount'])){
            $data['quantity_discount'] = json_encode($data['quantity_discount']);
        }else{
            $data['quantity_discount'] = null;
        }
        if(!isset($data['size_type'])){
            $data['size_type'] = null;
        }

        if(!isset($data['only_custom'])){
            $data['only_custom'] = 0;
        }
        $data = $this->getData($data);
//echo"<pre>";print_r($data);die;
       // echo"<pre>";print_r($data_new);die;
        $product = Product::create($data);

        if(isset($data['attributes'])){
            $product->attributes()->sync($data['attributes']);
        }
            if(isset($data['types']) && !empty($data['types'])){
                $data['detail_info'] = json_encode($data['types']);
            }else{
                $data['detail_info'] = null;
            }
            if(isset($data['grommets'])){
                $product->grommets()->sync($data['grommets']);
            }
            if(isset($data['shippings'])){
                $product->quantity_shipping()->sync($data['shippings']);
            }

        if(isset($data['inputs'])){
            foreach ($data['inputs'] as $input){
                $input['product_id'] = $product->id;
                Input::create($input);
            }
        }
    }

    public function update($data, $id){

        $item = $this->getItem($id);
        $data = $this->images($data);



        $data = $this->getData($data);


        $item->update($data);

        if(isset($data['attributes'])){
            $item->attributes()->sync($data['attributes']);
        }

        if(isset($data['grommets'])){
            $item->grommets()->sync($data['grommets']);
        }
        if(isset($data['shippings'])){
            $item->quantity_shipping()->sync($data['shippings']);
        }

        Input::where('product_id', $id)->delete();
        if(isset($data['inputs'])){
            foreach ($data['inputs'] as $input){
                $input['product_id'] = $id;
                Input::create($input);
            }
        }
    }

    public function delete($id){
        $item = $this->getItem($id);
        $item->delete();
    }

    public function images($data){
        $images = [];
        if( !empty($data['images']) )
        {
            foreach($data['images'] as $image)
            {
                if( is_string($image) ) {
                    $images[] = $image;
                }else if( !is_null($image) ){
                    $images[] = upload($image, true);
                }
            }
        }
        $data['images'] = $images;

        return $data;
    }

    public function getRandom($count){
        return Product::where('stock', 1)->inRandomOrder()->limit($count)->get();
    }

    public function search($text){
        return Product::where('stock', 1)->where('title', 'like', "%$text%")->orWhere('description', 'like', "%$text%")->get();
    }
    public function searchWithOrder($text){
        return DB::table('products')
            ->select('*')
            ->where('stock', 1)
            ->where('title', 'like', "$text%")
            ->union(DB::table('products')
                ->select('*')
                ->where('stock', 1)
                ->where('title', 'like', "%$text%"))
            ->union(DB::table('products')
                ->select('*')
                ->where('stock', 1)
                ->where('description', 'like', "%$text%"))
            ->take(10)
            ->get();
    }

    public function setOrder($data){
        $product = $this->getItem($data['id']);
        $product->order = $data['order'];
        $product->save();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function getData($data)
    {
      /*  if (isset($data['square_discounts']) && count($data['square_discounts'])) {
            $discount_arr = [];
            foreach ($data['square_discounts'] as $discount) {
                $discount_arr[$discount['total']] = $discount['percent'];
            }
            $data['square_discounts'] = json_encode($discount_arr);
        } else {
            $data['square_discounts'] = null;
        }*/
        return $data;
    }






}
