<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\DB;


class Product extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'images',
        'video',
        'title',
        'slug',
        'description',
        'short_desc',
        'category_id',
        'subcategory_id',
        'shipping_price',
        'shipping_percent',
        'text',
        'size_type',
        'size_type',
        'max_width',
        'max_height',
        'only_custom',
        'default_width',
        'default_height',
        'square_discounts',
        'order',
        'quantity_discount',
        'detail_info',
        'finishing_price',
        'cutting_width',
        'cutting_height',
        'min_price',
        'shipping_info',
        'stock',
        'bleed',
        'template_details',
        'attr_id_open_list',
        'design_price',
        'offset_qty',
        'production_turnaround'
    ];

    protected $casts = [
        'template_details' => 'array',
        'attr_id_open_list' => 'array',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        return json_decode($value);
    }

    public function getSquareDiscountsAttribute($value)
    {
        if(is_null($value)){
            return null;
        }else{
            $discounts = json_decode($value, true);
            ksort($discounts);
            return $discounts;
        }
    }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function subcategory(){
        return $this->hasOne(Category::class, 'id', 'subcategory_id');
    }

    public function attributes(){
        return $this->belongsToMany(Attribute::class, 'product_attributes', 'product_id', 'attribute_id')->withPivot('order')->orderBy('product_attributes.order');
    }

    public function types(){
        return $this->belongsToMany(Type::class, 'product_types', 'product_id', 'type_id')->withPivot('price');
    }

    public function details(){
        return $this->hasMany(Detail::class, 'product_id', 'id')->orderBy('order', 'ASC');
    }

    public function quantites(){
        return $this->hasMany(Detail::class, 'product_id', 'id')->orderBy('quantity_order', 'ASC');
    }

    public function sizes(){
        return $this->hasMany(ProductSize::class, 'product_id', 'id')->orderBy('size_id', 'DESC');
    }

    public function deliveries(){
        return $this->hasMany(Delivery::class, 'product_id', 'id')->where('isActive', 1);
    }

    public function inputs(){
        return $this->hasMany(Input::class, 'product_id', 'id');
    }

    public function quantity_shipping(){
        return $this->belongsToMany(Quantity::class, 'product_quantity_shipping', 'product_id', 'quantity_id')->withPivot('price');
    }

    public function grommets(){
        return $this->belongsToMany(Quantity::class, 'product_grommets', 'product_id', 'quantity_id')->withPivot('price');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function imagesByType()
    {
        return $this->hasMany(ProductImagesByType::class);
    }

    public function getRelatedTypes(){

        $sql = "select * from types as t ";
        if(!empty($attrs)){
            foreach($attrs as $key=>$val){
                echo"<pre>";print_r($val);die;
            }
        }


    }

    public function getQuantityDiscount(){
        if(!empty($this->quantity_discount)){
            return json_decode($this->quantity_discount,true);
        }else{
            return [];
        }
    }

    public function getInformation(){
       $result = [];
        if(!empty($this->quantity_discount)){
            $result['quantity'] = json_decode($this->quantity_discount,true);
        }else{
            $result['quantity'] = [];
        }

       foreach( $result['quantity'] as $k=>$p){
           $result['quantity'][$k]['id'] = $k;
       }
        usort($result['quantity'], fn($a, $b) => $a['value'] <=> $b['value']);

       $type_info = json_decode($this->detail_info,true);

       $type_ids = [];
       foreach($type_info as $attr_id => $type){
           $type_ids = array_merge($type_ids,$type);
           foreach($type as $t){
               $result['types'][$attr_id][$t] = [
                   'name'=>'',
                   'id'=>$t,
                   'full_paper'=>0,
                   'price'=>0,
                   'price_keys'=>'',
                   'size_id'=>'',
                   'attr_id'=>$attr_id,
                   'both_sides'=>1
               ];
           }
       }

       $typeArr = Type::all()->whereIn('id',$type_ids);
       foreach($typeArr as $typeObj){
           $result['types'][$typeObj->attribute_id][$typeObj->id]['name'] = $typeObj->name;
           $result['types'][$typeObj->attribute_id][$typeObj->id]['full_paper']=$typeObj->full_paper;
           $result['types'][$typeObj->attribute_id][$typeObj->id]['price']=$typeObj->price;
           $result['types'][$typeObj->attribute_id][$typeObj->id]['type_details']=$typeObj->type_details;
           $result['types'][$typeObj->attribute_id][$typeObj->id]['img']=$typeObj->img;
           $result['types'][$typeObj->attribute_id][$typeObj->id]['uploadedFileTypeIds']=$typeObj->uploadedFileTypeIds;
           $result['types'][$typeObj->attribute_id][$typeObj->id]['color_hex']=$typeObj->color_hex;
           if(!empty($typeObj->price_keys)){
               $result['types'][$typeObj->attribute_id][$typeObj->id]['price_keys']=json_decode($typeObj->price_keys,true);

           }
           $result['types'][$typeObj->attribute_id][$typeObj->id]['both_sides']=$typeObj->both_sides;
           if(!empty($typeObj->size_id)){
               $result['types'][$typeObj->attribute_id][$typeObj->id]['size_id']=$typeObj->size_id;
           }
       }

        return $result;
    }

    public function calculatePrice($params){

        $typesList = [];
        $overset = isset($params['offset_qty']) ? $params['offset_qty'] : 0;

        unset($params['product_id']);
        $custom_inputs = [];
        $sql = "select id, title from inputs where product_id={$this->id}";
        $custom_inputs_ob = DB::select($sql);
        if(!empty($custom_inputs_ob)){
            foreach($custom_inputs_ob as $c){
                if(isset($params['input_'.$c->id])){
                    $custom_inputs[$c->title] = $params['input_'.$c->id];
                    unset($params['input_'.$c->id]);
                }
            }
        }
        //quantity calculation
        if(isset($params['quantity'])){
            $quantity = $params['quantity'];
            $quantityObj = json_decode($this->quantity_discount,true);

            $qty = $quantityObj[$quantity]['value'];

            $qty_discount = $quantityObj[$quantity]['discount'];

            unset($params['quantity']);
        }

        //delivery options
        $delivery = (isset($params['delivery']))?$params['delivery']:0;
        unset($params['delivery']);
        //coupon calculation
        $coupon_percent = 0;
        $coupon = null;
        if(!empty($params['coupon'])){
            $coupon = Coupon::getCouponInfo($params['coupon']);
            if(!empty($coupon)){
                $coupon_percent = $coupon->percent;
            }
        }

        unset($params['coupon']);
        unset($params['coupon_percent']);
        unset($params['finising_price']);
        $finishing_price = $this->finishing_price;

    //getting types
    $typeIds = [];

    if(isset($params['sizes']) && $params['sizes'] > 0){
            $types   = Type::where('id', $params['sizes'])->first();
            $typeIds[] = $params['sizes'];
            $size = Size::where('id',$types->size_id)->first();
            $sizes = explode('x',$size->in);
            $elementWidth  = trim($sizes[0]);
            $elementHeight = trim($sizes[1]);
    }else if(isset($params['sizes']) && $params['sizes'] == 0){
        $sizes_dev = ($params['size_type'] == 'ft') ? 12 :1;
        $elementWidth  = $params['custom_width']  * $sizes_dev;
        $elementHeight = $params['custom_height'] * $sizes_dev;
        if($params['size_type'] == 'in'){
            $a = '"';
        }else{
            $a = "'";
        }
        $typesList['Custom Size'] = $params['custom_width'].$a.'x'.$params['custom_height'].$a.' '.strtoupper($params['size_type']);
    }else{
        $elementWidth  = 0;
        $elementHeight = 0;
    }
        if(isset($params['qty'])){
            $qty = array_sum($params['qty']);
            $ids =  array_keys($params['qty']);
            $typeIds = array_merge($typeIds, $ids);
        }

        foreach ($params as $p_key => $p_val) {
            $ex = explode('_', $p_key);
            if ($ex[0] === 'attribute') {
                if (is_array($p_val)) {
                    $typeIds = array_merge($typeIds, $p_val);
                } else {
                    $typeIds[] = $p_val;
                }
            }
        }

        $types   = Type::whereIn('id', $typeIds)->orderBy('attribute_id', 'asc')->get();
        $cover_pages_count = 0;
        $inside_pages_count = 0;
        $is_apparel = 0;
        $paper_info = $inside_paper_info = $cover_paper_info = [];
        foreach($types as $t){

            if($t->attribute_id==32){
                preg_match_all('/\d+/', $t->name, $array);

                $cover_pages_count = $array[0][1]/2;
                $inside_pages_count = $array[0][2]/2;

            }

            if($t->attribute->is_apparel){
                $is_apparel = 1;
            }

            if($t->attribute->is_multiple && !$t->attribute->is_apparel){
                $typesList[$t->attribute->name][] = $t->name;
            }else if($t->attribute->is_apparel){
                if(isset($params['qty']) && $params['qty'][$t->id]){
                    $typesList[$t->attribute->name][] = $t->name;
                }
            } else{
                $typesList[$t->attribute->name] = $t->name;
            }

            $attribute = Attribute::find($t->attribute_id);
            $is_paper_type = false;
            if(!empty($attribute)){
                $is_paper_type = $attribute->is_crude;
            }
            if($is_paper_type){
                if($t->full_paper == 1) {
                    $paper_info = json_decode($t->price_keys, true);

                    if ($overset && $qty >= $overset) {
                        foreach ($paper_info as $key => $info) {
                            $paper_info[$key]['price'] = $info['machine_price'];
                        }
                    }
                }
            }elseif($t->attribute_id == 41){

                $inside_paper_info = json_decode($t->price_keys, true);
                if ($overset && $qty >= $overset) {
                    foreach ($inside_paper_info as $key => $info) {
                        $inside_paper_info[$key]['price'] = $info['machine_price'];
                    }
                }
            }elseif($t->attribute_id == 42){
                if($t->id == 295){
                    $cover_paper_info = $inside_paper_info;
                }else{
                    $cover_paper_info = json_decode($t->price_keys, true);
                    if ($overset && $qty >= $overset) {
                        foreach ($cover_paper_info as $key => $info) {
                            $cover_paper_info[$key]['price'] = $info['machine_price'];
                        }
                    }
                }
            }
        }

        $price = 0;
        $prices = [];
        $mode = 'sqr';
        $core_size = '';

        if(!empty($paper_info)){
            $mininum = 0;

            foreach($paper_info as $paper){

                $sizeObj = Size::where('id',$paper['size_id'])->first();
                $paperSizes = explode('x',$sizeObj->in);

                $paperWidth = trim($paperSizes[0]);
                $paperHeight = trim($paperSizes[1]);

                $elements_count_1 = self::calculateElementsPerPage($paperWidth, $paperHeight, $elementWidth, $elementHeight);
                $elements_count_2 = self::calculateElementsPerPage($paperHeight, $paperWidth, $elementWidth, $elementHeight);

                $elements_count  = ($elements_count_1 > $elements_count_2 )?$elements_count_1: $elements_count_2;

                if($elements_count == 0){
                    continue;
                }
                $paper_count = ceil($qty / $elements_count);

//                if($paper_count > $overset){
//                    $prices[$paper['size_id']]['machine_price'] =  $paper_count * $paper['machine_price'];
//                }else{
//                    $prices[$paper['size_id']]['price'] =  $paper_count * $paper['price'];
//                }
                $prices[$paper['size_id']]['price'] =  $paper_count * $paper['price'];
                $prices[$paper['size_id']]['mode'] = ($elements_count_1 > $elements_count_2 ) ? 'portrait':'landscape';
                $prices[$paper['size_id']]['paper_count'] = $paper_count;
                if(($elementWidth+0.25 == $paperWidth) && ($paperHeight==$elementHeight+0.25)){
                    $mininum = $paper['size_id'];
                }
            }

            $k = 0;
            $min_price = 0;
            if($mininum > 0){
//                $min_price = isset($prices[$mininum]['machine_price']) ? $prices[$mininum]['machine_price'] : $prices[$mininum]['price'];
                $min_price = $prices[$mininum]['price'];
                $core_size = $mininum;
                $mode = 'portrait';
                $paper_count = $prices[$mininum]['paper_count'];
            }else{

                foreach($prices as $key=>$val){
                    if($k == 0){
                        $min_price = $val['price'];
                        $core_size = $key;
                        $mode = $val['mode'];
                    }else{
                        if($val['price'] < $min_price){
                            $min_price = $val['price'];
                            $core_size = $key;
                            $mode = $val['mode'];
                        }
                    }
                    $k++;
                }
            }
            $paper_count = $prices[$core_size]['paper_count'];

            $price = $min_price;
        }elseif(!empty($inside_paper_info)){

            foreach($inside_paper_info as $paper){
                $sizeObj = Size::where('id',$paper['size_id'])->first();
                $paperSizes = explode('x',$sizeObj->in);

                $paperWidth = trim($paperSizes[0]);
                $paperHeight = trim($paperSizes[1]);

                $elements_count_1 = self::calculateElementsPerPage($paperWidth, $paperHeight, $elementWidth, $elementHeight);
                $elements_count_2 = self::calculateElementsPerPage($paperHeight, $paperWidth, $elementWidth, $elementHeight);

                $elements_count  = ($elements_count_1 > $elements_count_2 )?$elements_count_1: $elements_count_2;

                if($elements_count == 0){
                    continue;
                }

                $inside_paper_count = ceil($qty * $inside_pages_count / $elements_count);
                $cover_paper_count = ceil($qty  * $cover_pages_count / $elements_count);

//                if($inside_paper_count > $overset){
//                    $prices[$paper['size_id']]['machine_price']  =  $inside_paper_count * $paper['machine_price'];
//                }else{
//                    $prices[$paper['size_id']]['price']  =  $inside_paper_count * $paper['price'];
//                }
//
//                if($cover_paper_count > $overset){
//                    $prices[$paper['size_id']]['machine_price'] +=  $cover_paper_count * $cover_paper_info[$paper['size_id']]['machine_price'];
//                }else{
//                    $prices[$paper['size_id']]['price'] +=  $cover_paper_count * $cover_paper_info[$paper['size_id']]['price'];
//                }
                $prices[$paper['size_id']]['price']  =  $inside_paper_count * $paper['price'];
                $prices[$paper['size_id']]['price'] +=  $cover_paper_count * $cover_paper_info[$paper['size_id']]['price'];

                $prices[$paper['size_id']]['mode'] = ($elements_count_1 > $elements_count_2 ) ? 'portrait':'landscape';
            }
            $k = 0;
            $min_price = 0;

            foreach($prices as $key=>$val){
                if($k == 0){
                    $min_price = $val['price'];
                    $core_size = $key;
                    $mode = $val['mode'];
                }else{
                    if($val['price'] < $min_price){
                        $min_price = $val['price'];
                        $core_size = $key;
                        $mode = $val['mode'];
                    }
                }
                $k++;

            }
            $price = $min_price;
        }


        $total_sqr = 0;
        $apparel_info = [];
        $apparel_price = 0;
        $apparel_per_price_source = 0;

        foreach($types as $t){

            if($t->attribute_id < 3 || $t->attribute_id == 73 || $t->attribute_id == 74 || $t->attribute_id == 83 || $t->attribute_id == 41 || $t->attribute_id == 42){
               continue;
            }

            if($t->full_paper == 1){
                if(isset($paper_info) && !empty($paper_info)){
                    $paper_info  = json_decode($t->price_keys,true);
                    if(isset($paper_info[$core_size])){
//                        if($paper_count > $overset){
//                            $price += $paper_info[$core_size]['machine_price'] * $paper_count;
//                        }else{
//                            $price += $paper_info[$core_size]['price'] * $paper_count;
//                        }
                        if ($overset && $qty >= $overset) {
                            foreach ($paper_info as $key => $info) {
                                $paper_info[$key]['price'] = $info['machine_price'];
                            }
                        }
                        $price += $paper_info[$core_size]['price'] * $paper_count;
                    }

                }elseif($inside_pages_count > 0){
                    $paper_info  = json_decode($t->price_keys,true);
                    if(strpos($t->attribute->name, "Cover") !== false) {
                        $paper_count = $cover_paper_count;
                    }elseif(strpos($t->attribute->name, "Inside") !== false){
                        $paper_count = $inside_paper_count;
                    }else{
                        $paper_count = $inside_paper_count + $cover_paper_count;
                    }
                    if(isset($paper_info[$core_size])){
//                        if($paper_count > $overset){
//                            $price += $paper_info[$core_size]['machine_price'] * $paper_count;
//                        }else{
//                            $price += $paper_info[$core_size]['price'] * $paper_count;
//                        }
                        if ($overset && $qty >= $overset) {
                            foreach ($paper_info as $key => $info) {
                                $paper_info[$key]['price'] = $info['machine_price'];
                            }
                        }

                        $price += $paper_info[$core_size]['price'] * $paper_count;
                    }

                }

            }elseif($t->full_paper == 2){

                $product_sqr = ($elementWidth / 12) * ($elementHeight / 12);
                $total_sqr = $product_sqr * $qty;
                $s_price = $total_sqr * $t->price;

                $price += $s_price;

            }else{
                if($t->id == 51){
                    $typesList['Grommets Count'] = $params['custom_grommet'];
                    $price += $qty * $t->price*$params['custom_grommet'];
                }else if(!$t->attribute->is_apparel){
                    $price += $qty * $t->price;
                    $apparel_per_price_source += $t->price;
                }

            }
        }

        // get price for apparel and get item price for all types beside apparel
        foreach($types as $t){
            if($t->attribute->is_apparel) {
                if (array_key_exists($t->id, $params['qty'])) {
                    $apparel_price += $t->price * $params['qty'][$t->id];
                    $apparel_per_price = $apparel_per_price_source + $t->price;
                    $apparel_info[$t->name] = [
                        'qty' => $params['qty'][$t->id],
                        'per_item_price' => $apparel_per_price,
                    ];
                }
            }
        }

        $price += $apparel_price;
        $price = $price + $qty * $finishing_price;
        //sqr discounts
        $d_percent = 0;
        if(!empty($this->square_discounts)){
            $discounts = $this->square_discounts;

            foreach($discounts as $d_key=>$d_val){
                if($total_sqr > $d_key && $d_percent < $d_val){
                    $d_percent = $d_val;
                }
            }
        }
        $price = $price - $price * $d_percent / 100;

        if($is_apparel){
            $qty_discount_data = json_decode($this->quantity_discount, true);
            $closestValue = null;
            $qty_discount = 0;

            if(!empty($qty_discount_data)){
                foreach ($qty_discount_data as $key => $value){
                    if ($key <= $qty) {
                        if (!$closestValue || $key > $closestValue['value']) {
                            $closestValue = $value;
                        }
                    }
                }
            }

            if ($closestValue && $closestValue['discount']) {
                $qty_discount = $closestValue['discount'];
            }
        }


        $price = $price - $price * $qty_discount / 100;

if($this->min_price > 0 && $this->min_price > $price){
    $price = $this->min_price;
}
        $price = $price + $price * $delivery / 100;
        $price = $price - $price * $coupon_percent / 100;

        $price = (float) sprintf('%.2f', $price);
        $typesList = array_merge($typesList,$custom_inputs);

        $per_set_price = $price;
        $total_price = $per_set_price * count($params['set_title']);

        if(isset($params['type']) && $params['type'] == 'Design Offer'){
            $total_price += $this->design_price;
        }

        if($is_apparel){
            foreach ($typesList as $key => $value){
                if(is_array($value)){
                    $typesList[$key] = implode(',', $value);
                }
            }

            $result = [
                'price'=>(float) sprintf('%.2f', $total_price),
                'per_set_price'=>$per_set_price,
                'design_price' => $this->design_price,
                'quantity'=>$qty,
                'calculation_size'=>$core_size,
                'types'=>$typesList,
                'delivery'=>$delivery,
                'coupon'=>[],
                'selected_values' => $typeIds,
                'apparel_info' => $apparel_info,
            ];
        }else{
            $result = [
                'price'=>(float) sprintf('%.2f', $total_price),
                'per_set_price'=>$per_set_price,
                'design_price' => $this->design_price,
                'quantity'=>$qty,
                'mode'=>$mode,
                'calculation_size'=>$core_size,
                'types'=>$typesList,
                'delivery'=>$delivery,
                'coupon'=>[],
                'selected_values' => $typeIds
            ];
        }


        if(isset($coupon) && !empty($coupon)){
            $result['coupon'] = [
                'id'=>$coupon->id,
                'name'=>$coupon->name,
                'percent'=>$coupon->percent,
            ];
        }

        return $result;
    }

    public static function calculateElementsPerPage($paperWidth, $paperHeight, $elementWidth, $elementHeight) {
        $elementWidth = $elementWidth + 0.25;

        $elementHeight =  $elementHeight + 0.25;

        if ($paperWidth <= 0 || $paperHeight <= 0 || $elementWidth <= 0 || $elementHeight <= 0) {
            return 0;
        }

        $horizontalElements = floor($paperWidth / $elementWidth);
        $verticalElements = floor($paperHeight / $elementHeight);

        return $horizontalElements * $verticalElements;
    }

    public function avatar()
    {
        return asset('storage/content/' . $this->images[0]) ;

    }

}
