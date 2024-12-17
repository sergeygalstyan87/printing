@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/multi.min.css') }}" />

<style>
    .error_message{
        border: 1px solid red;
    }
    .draggable {
        display: flex;
        margin-top: 10px;
        padding: 10px 12px;
        border-radius: 5px;
        border: 1px solid #5c636a;
        margin-right: 5px;
        background-color: #212529;
        cursor: grab;
        color: #ffffff;
        touch-action: none
    }

    .dragging {
        cursor: grabbing;
        background: transparent;
        color: transparent;
        border: none;
    }
    .qty_discount_discounts{
        width: 50%;
    }
</style>
@endpush
<?php
$rel_types = [];
foreach($types as $tt){
    if($tt->hasRelatedAttrs()){
        $rel_types[$tt->id] = $tt->hasRelatedAttrs();
    }
}
$attr_info = [];
foreach($attributes as $a){
    if ($a->notes){
        $name = $a->name." ($a->notes)";
    }else{
        $name = $a->name;
    }
    $attr_info[$a->id] = $name;
}
?>
@section('content')
    <div id="types_list" style="display:none;">{{$types_list}}</div>
    <div id="attr_list" style="display:none;">{{json_encode($attr_info)}}</div>
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <h5 class="card-header">Product attributes</h5>
                        @csrf
                        <div class="card-body">
<div id="s_message"></div>
                            <div class="tab-content" id="pills-tabContent-3">
                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm">Enable Sizes</label>
                                        <input class="tgl tgl-light tgl-primary" id="size_status"
                                               type="checkbox" {{ ($item->custom_sizes == 1)? 'checked' : '' }}>
                                        <label class="tgl-btn" for="size_status"></label>
                                    </div>

                                    <div class="size_types"
                                         style="display: {{ $item->custom_sizes ? 'block' : 'none' }}">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="only_custom" value="1"
                                                   id="only_custom" {{ isset($item) && $item->only_custom == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="only_custom">Only Custom</label>
                                        </div>

                                        <div class="size_block">
                                            <div class="form-group">
                                                <label for="max_width">Max Width (FT)</label>
                                                <input
                                                        id="max_width"
                                                        type="number"
                                                        class="form-control"
                                                        placeholder="Enter Max Width"
                                                        name="max_width"
                                                        value="{{ (isset($item) && isset($item->max_width) ) ? $item->max_width : 0 }}"
                                                >
                                                @error('max_width')
                                                <div class="invalid-feedback"
                                                     style="display: block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="max_height">Max Height (FT)</label>
                                                <input
                                                        id="max_height"
                                                        type="number"
                                                        class="form-control"
                                                        placeholder="Enter Max Height"
                                                        name="max_height"
                                                        value="{{ (isset($item) && isset($item->max_height) ) ? $item->max_height : 0 }}"
                                                >
                                                @error('max_height')
                                                <div class="invalid-feedback"
                                                     style="display: block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="default_width">Default Width</label>
                                                <input
                                                        id="default_width"
                                                        type="number"
                                                        class="form-control"
                                                        placeholder="Enter Default Width"
                                                        name="default_width"
                                                        value="{{ (isset($item) && isset($item->default_width) ) ? $item->default_width : 0 }}"
                                                >
                                                @error('default_width')
                                                <div class="invalid-feedback"
                                                     style="display: block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="default_height">Default Height</label>
                                                <input
                                                        id="default_height"
                                                        type="number"
                                                        class="form-control"
                                                        placeholder="Enter Default Height"
                                                        name="default_height"
                                                        value="{{ (isset($item) && isset($item->default_height) ) ? $item->default_height : 0 }}"
                                                >
                                                @error('default_height')
                                                <div class="invalid-feedback"
                                                     style="display: block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-check" id="size_radio">
                                            <input type="radio" {{ $item->size_type == 'ft' ? 'checked' : '' }} id="size_type_ft" name="size_type" value="ft">
                                            <label for="size_type_ft">FT only</label><br>
                                            <input type="radio" {{ $item->size_type == 'in' ? 'checked' : '' }} id="size_type_in" name="size_type" value="in">
                                            <label for="size_type_in">IN only</label><br>
                                            <input type="radio" {{ $item->size_type == 'both' ? 'checked' : '' }} id="size_type_both" name="size_type" value="both">
                                            <label for="size_type_both">Both</label>
                                        </div>
                                        <div class="discounts_block accordion">
                                            <div class="card">
                                                <div class="card-body d-flex flex-wrap">
                                                    @if(isset($item) && $item->square_discounts)
                                                        @php
                                                            $discount_index = 0
                                                        @endphp
                                                        @foreach($item->square_discounts as $total => $discount)
                                                            <div class="col-3 form-group discount_group">
                                                                <div>
                                                                    <label>Total Square FT</label>
                                                                    <input type="number" min="0"
                                                                           class="form-control square_discounts_values"
                                                                           placeholder="Over"
                                                                           name="square_discounts[{{ $discount_index }}][total]"
                                                                           value="{{ $total }}" required>
                                                                </div>
                                                                <div>
                                                                    <label>Percent</label>
                                                                    <input type="number"
                                                                           class="form-control square_discounts_percents"
                                                                           placeholder="Discount percent"
                                                                           name="square_discounts[{{ $discount_index }}][percent]"
                                                                           value="{{ $discount }}" required></div>
                                                                <button type="button"
                                                                        class="btn btn-danger delete_square_discount">Delete
                                                                </button>
                                                            </div>
                                                            @php
                                                                $discount_index++
                                                            @endphp
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="card-footer">
                                                    <div class="form-group d-flex align-items-center justify-content-between">
                                                        <button type="button" class="btn btn-primary add_discount mb-0">Add Discount</button>
                                                        <a href="javascript:void(0)" id="save_sizes_block" class="btn btn-success" style="color:white;">Save Sizes</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="row">
                                    <?php $discounts = (isset($item)) ?  $item->getQuantityDiscount():[];?>
                                    <div class="form-group quantities_select_block col-md-8">
                                        <label for="quantities">Quantities</label>
                                        <select id="quantities" multiple="multiple" class="form-control qty_select2"
                                                name="quantities[]">
                                            @foreach($quantities as $quantity)
                                                <option data-title="{{ $quantity->number }}"
                                                        value="{{ $quantity->id }}" {{ ( isset($item) && isset($discounts[$quantity->id])  ) || old('attributes') == $quantity->id ? 'selected' : '' }}>
                                                    {{ $quantity->number }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                        <div class="form-group col-md-4">
                                            <a href="javascript:void(0)" style="margin-top: 40px;" id="set_dicsount_button" class="btn btn-danger" data-toggle="modal" data-target="#discount_modal">Set Discount</a>
                                            <a href="javascript:void(0)" style="margin-top: 40px;" id="save_without_discount" class="btn btn-warning">Save  Quantity</a>

                                        </div>
                                </div>


    <div class="accordion" id="accordionExample" >
        @if(!empty($selected_types))
            @foreach($selected_types as $attr_key => $attr_array)
                <div class="card" id="accordion_card_{{$attr_key}}">
                    <div class="card-header-big">
                        <div class="card-header" id="heading_{{$attr_key}}">
                            <div class="row">
                                <div class="col-md-1 list-group-item-drag" style="cursor: pointer;margin-top: 10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrows-move" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708l2-2zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10M.146 8.354a.5.5 0 0 1 0-.708l2-2a.5.5 0 1 1 .708.708L1.707 7.5H5.5a.5.5 0 0 1 0 1H1.707l1.147 1.146a.5.5 0 0 1-.708.708l-2-2zM10 8a.5.5 0 0 1 .5-.5h3.793l-1.147-1.146a.5.5 0 0 1 .708-.708l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L14.293 8.5H10.5A.5.5 0 0 1 10 8"/>
                                    </svg>
                                </div>
                            <h2 class="mb-0 col-md-7">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_{{$attr_key}}" aria-expanded="false" aria-controls="collapse_{{$attr_key}}">
                                    @foreach($attributes as $attr)
                                        @if($attr_key == $attr->id)
                                            {{$attr->name}}
                                            <span style="font-size: 14px">{{$attr->notes ? "($attr->notes)" : ''}}</span>
                                            @break
                                        @endif
                                    @endforeach
                                </button>
                            </h2>
                            <div class="col-md-1">

                            </div>
                                <div class="col-md-3">
                                    <a href="javascript:void(0)" data-id="{{$attr_key}}" class="delete_attribute btn btn-danger">Delete</a>
                                    <a href="javascript:void(0)" data-id="{{$attr_key}}" class="add_new_type btn btn-warning">Types</a>
                                    @if($item && $item->attr_id_open_list && in_array($attr_key, $item->attr_id_open_list))
                                        <a href="javascript:void(0)" data-id="{{$attr_key}}" class="mark_opened btn btn-secondary">Unset as open list</a>
                                    @else
                                        <a href="javascript:void(0)" data-id="{{$attr_key}}" class="mark_opened btn btn-secondary">Set as open list</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="collapse_{{$attr_key}}" class="collapse" aria-labelledby="heading_{{$attr_key}}" data-parent="#accordionExample">
                        <div class="card-body">
                            <ul id="sortable_type_{{$attr_key}}" class="list-group">
                                @foreach($attr_array as $type_arr)
                                    @foreach($types as $type_info)
                                        @if($type_info->id == $type_arr)
                                            <li class="list-group-item" data-id="{{$type_info->id}}">{{$type_info->name}}</li>
                                            @break
                                        @endif
                                    @endforeach

                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            @endforeach
        @endif
    </div>
     <div class="form-group attributes_select_block">
          <a href="javascript:void(0)" style="margin-top: 10px;float:right" id="add_new_attribute" class="btn btn-warning">+Add Attribute</a>
     </div>
     <div class="form-group attributes_select_block">
         <a href="javascript:void(0)" style="margin-top: 10px " id="shipping_info" class="btn btn-primary mb-5">Shipping Info</a>
         @include('dashboard.pages.products.partials.shipping-info', ['items' => $item->shipping_info])
     </div>
</div>
</div>
                        <div class="card-footer bg-light">
                            <button class="btn btn-primary right" id="save_form" style="float:right">Save</button>
                        </div>
            </div>
        </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script>
        @php
            $js_array = json_encode($types->toArray());
            echo "let types = ". $js_array . ";\n";
            echo "let related_types = ". json_encode($rel_types) . ";\n";
            $quantities_array = json_encode($quantities->toArray());
            echo "let quantities_object = ". $quantities_array . ";\n";
            $categories_array = json_encode($all_categories->toArray());
            echo "let categories_array = ". $categories_array . ";\n";
        @endphp
    </script>
    <script src="{{ asset('admin/assets/js/product.js') }}"></script>
    <script src="{{ asset('admin/assets/css/multi.min.js') }}"></script>
<script>
  $(document).ready(function(){

      $("#accordionExample").sortable({

        handle: '.list-group-item-drag',
          stop: function(event, ui) {
              // Custom animation on drop
              ui.item.addClass('visible'); // Use any animation method you prefer
          },
          start: function(event, ui) {
              // Custom animation on drop
              ui.item.addClass('visible'); // Use any animation method you prefer
          },
          containment: "#accordionExample",
      });

    $("#accordionExample").accordion({
          collapsible: true,
          header: "> div > .card-header",
          heightStyle: "content"
      });
  })
    @if(!empty($selected_types))
    @foreach($selected_types as $attr_key1 => $attr_array1)
         $("#sortable_type_{{$attr_key1}}").sortable();
            @endforeach
         @endif
    $('.qty_select2').select2({
        placeholder: 'Please select a quantities'
    });
    $("#save_form").on('click',function () {
        $(this).html('Loading...');
        $(".card-header-big").removeClass('error_message')
            var selectedAttrs = [];
            var listItems = $(".add_new_type");
            listItems.each(function(){
            var dataIdValue = $(this).data("id");
            var listTypes = $("#sortable_type_"+dataIdValue+" .list-group-item");
            var selectedTypes = [];
            // Do something with the data-id value
            listTypes.each(function(){
                var dataTypeValue = $(this).data("id");
                selectedTypes.push(dataTypeValue);
                // Do something with the data-id value
            })
            selectedAttrs.push({id:dataIdValue,types:selectedTypes})
        });

        var has_error = false;
        if(selectedAttrs.length == 0){
            has_error = true;
            var a = '<div class="alert alert-warning alert-dismissible fade show" role="alert">\n' +
                '  <strong>Please select attributes</strong>\n' +
                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '    <span aria-hidden="true">&times;</span>\n' +
                '  </button>\n' +
                '</div>';
            $("#s_message").html(a);
            $(this).html('Save');
            $('html, body').animate({
                scrollTop: $("#s_message").offset().top
            }, 500);
        }else{
            $.each( selectedAttrs, function( index, value ){
                if(value.types.length == 0){
                    has_error = true;
                    $("#accordion_card_"+value.id+" .card-header-big").addClass('error_message');
                }
            });
        }

        if(has_error){
            $(this).html('Save');
            return false;
        }else{
            $.ajax({
                type: "POST",
                url: "{{route('dashboard.products.editAttrs', $item->id)}}",
                data: { "attrs":selectedAttrs},
                dataType: 'json',
                success: (data) => {
                    var a = '<div class="alert alert-success alert-dismissible fade show" role="alert">\n' +
                        '  <strong>Succesfully saved</strong>\n' +
                        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                        '    <span aria-hidden="true">&times;</span>\n' +
                        '  </button>\n' +
                        '</div>';
                    $("#s_message").html(a);
                    $(this).html('Save');
                    $('html, body').animate({
                        scrollTop: $("#s_message").offset().top
                    }, 500);
                }
            });
        }
    })
  $(document).on('change', '#size_status', function () {
      if ($(this).is(":checked")) {
          var custom_sizes = 1;
          $('.custom_sizes').show()
          $('.size_types').show()
      } else {
          $('.custom_sizes').hide()
          $('.size_types').hide()
          custom_sizes = 2;
      }
      $.ajax({
          type: "POST",
          url: "{{route('dashboard.products.editAttrs', $item->id)}}",
          data: { "custom_sizes":custom_sizes},
          dataType: 'json',
      });

  })
    $("#add_new_attribute").on('click',function(){
        var selectedAttrs = [];
        var listItems = $(".add_new_type");

        // Loop through each <li> element and retrieve the data-id attribute
        listItems.each(function(){
            var dataIdValue = $(this).data("id");
            selectedAttrs.push(dataIdValue);
            // Do something with the data-id value
        });

        var attr_list = $("#attr_list").html();
        var attr_list_obj = $.parseJSON(attr_list);

        var selectBox = $('<select multiple="multiple" name="favorite_attrs" id="favorite_attrs">');
        $.each( attr_list_obj, function( index, value ){

            selected_item = '';
            selectedAttrs = selectedAttrs.map(Number);

            if (selectedAttrs.includes(parseInt(index))){
                selected_item = 'selected';
            }

            selectBox.append('<option value="'+index+'" '+selected_item+'>'+value+'</option>');
        });
        // Append the select box to the container
        $("#attrsModal").modal('show');
        $('#attrsModal .modal-body').html(selectBox);

        var select = document.getElementById("favorite_attrs");
        multi(select, {
            enable_search: true,
        });
        var notTouch = [];
        var addValues = [];
        var deleteValues=[];
        selectBox.on('change', function() {

            var selectedValue = $(this).val();
            var seletdec_items = [];
            var listItems = $(".add_new_type");

            // Loop through each <li> element and retrieve the data-id attribute
            listItems.each(function(){
                var dataIdValue = $(this).data("id");
                seletdec_items.push(dataIdValue);
                // Do something with the data-id value
            });

            array1 = selectedValue;
            array1 = array1.map(Number);
            array2 = seletdec_items;

            var needAdd = array1.filter(value => !array2.includes(value));

            // Find elements that exist in array2 but not in array1
            var needDelete = array2.filter(value => !array1.includes(value));

            for(var i=0; i<needDelete.length;i++){
               $('#accordion_card_'+needDelete[i]).remove();
            }

            for(var i=0; i<needAdd.length;i++){
                var item_name = 'n/a';
                $.each( attr_list_obj, function( index, value ){
                    if(index == needAdd[i]){
                        item_name = value;
                    }
                });
                var attr_content = createAttrContent(needAdd[i],item_name);
                // Append the new <li> to the <ul>
                $('#accordionExample').append(attr_content);
                $("#sortable_type_"+needAdd[i]).sortable();
            }

        });

    });
    function createAttrContent(attr_id,attr_name){
        var html = '<div class="card" id="accordion_card_'+attr_id+'">';
            html+='<div class="card-header-big" style="padding-top:10px;">';
            html +='<div class="card-header" id="heading_'+attr_id+'">';
            html +='<div class="row">';
            html +='  <div class="col-md-1 list-group-item-drag" style="cursor: pointer;margin-top: 10px;">\n' +
                '                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrows-move" viewBox="0 0 16 16">\n' +
                '                                        <path fill-rule="evenodd" d="M7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708l2-2zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10M.146 8.354a.5.5 0 0 1 0-.708l2-2a.5.5 0 1 1 .708.708L1.707 7.5H5.5a.5.5 0 0 1 0 1H1.707l1.147 1.146a.5.5 0 0 1-.708.708l-2-2zM10 8a.5.5 0 0 1 .5-.5h3.793l-1.147-1.146a.5.5 0 0 1 .708-.708l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L14.293 8.5H10.5A.5.5 0 0 1 10 8"/>\n' +
                '                                    </svg>\n' +
                '                                </div>';
            html +='<h2 class="mb-0 col-md-7">';
            html += '<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_'+attr_id+'" aria-expanded="false" aria-controls="collapse_'+attr_id+'">';
        html += attr_name+'</button> </h2> <div class="col-md-2"></div>';
        html += '<div class="col-md-2"><a href="javascript:void(0)" class="delete_attribute btn btn-danger" data-id="'+attr_id+'">Delete</a> ';
        html +='<a href="javascript:void(0)" data-id="'+attr_id+'" class="add_new_type btn btn-warning">Types</a></div></div> </div></div>'
        html +='<div id="collapse_'+attr_id+'" class="collapse" aria-labelledby="heading_'+attr_id+'" data-parent="#accordionExample">'
        html += '<div class="card-body">';
        html += '<ul id="sortable_type_'+attr_id+'" class="list-group">';
        html += '</ul></div></div></div>';
        return html;




    }
    $("#save_sizes_block").on('click',function(){
        $("div,input").removeClass('error_message');
        var only_custom = $("#only_custom").is(":checked"); //only_custom
        var max_width = $("#max_width").val();
        var max_height = $("#max_height").val();
        var default_width = $("#default_width").val();
        var default_height = $("#default_height").val();
        var sqr_price = $("#sqr_price").val();
        var discoutns = [];
        $(".square_discounts_values").each(function(index, value){
            var p = $(this).closest('.discount_group').find('.square_discounts_percents').val();
            var it = {over:$(this).val(),percent:p}
            discoutns.push(it);
        });
        var size_type = $('input[name = "size_type"]:checked').val();
        var has_errors = false;
        if(max_width == 0){
            has_errors = true;
            $("#max_width").addClass('error_message');
        }
        if(max_height == 0){
            has_errors = true;
            $("#max_height").addClass('error_message');
        }
        if(parseFloat(default_width)  > parseFloat(max_width)){
            has_errors = true;
            $("#max_width").addClass('error_message');
            $("#default_width").addClass('error_message');
        }
        if(parseFloat(default_height)  > parseFloat(max_height)){
            has_errors = true;
            $("#max_height").addClass('error_message');
            $("#default_height").addClass('error_message');
        }

        if(sqr_price == 0){
            has_errors = true;
            $("#sqr_price").addClass('error_message');
        }

        if(size_type == undefined){
            has_errors = true;
            $("#size_radio").addClass('error_message');
        }
        if(has_errors){
            return false;
        }

        var obj1 = {
            only_custom:only_custom,
            max_width:max_width,
            max_height:max_height,
            default_width:default_width,
            default_height:default_height,
            sqr_price:sqr_price,
            size_type:size_type,
            discounts:discoutns
        };

        $.ajax({
            type: "POST",
            url: "{{route('dashboard.products.editAttrs', $item->id)}}",
            data: { "custom_info":obj1},
            dataType: 'json',
            success: (data) => {
                var a = '<div class="alert alert-success alert-dismissible fade show" role="alert">\n' +
                    '  <strong>Sizes info saved.</strong>\n' +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>';
                $("#s_message").html(a);
            }
        });
    })
    $("#save_discount, #save_without_discount").on('click',function(e){
        e.preventDefault();
        $("#s_message").html('')
        var obj1 = [];

        $('.qty_discount_discounts').each(function(){

            var d_id = $(this).attr('data-id');

            if(d_id > 0){
                var qty_count = $("input[name='quantity_discount["+d_id+"][value]']").val();
                var a = {'discount':$(this).val(), 'value':qty_count};
                obj1[d_id] = a;
            }

        });
        if(obj1.length > 0){
            $.ajax({
                type: "POST",
                url: "{{route('dashboard.products.editAttrs', $item->id)}}",
                data: { "fields":obj1},
                dataType: 'json',
                success: (data) => {
                    var a = '<div class="alert alert-success alert-dismissible fade show" role="alert">\n' +
                        '  <strong>Quantity saved</strong>\n' +
                        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                        '    <span aria-hidden="true">&times;</span>\n' +
                        '  </button>\n' +
                        '</div>';
                    $("#s_message").html(a);
                }
            });
            return true;
        }else{
            var a = '<div class="alert alert-danger alert-dismissible fade show" role="alert">\n' +
                '  <strong>Quantity can not be empty.</strong>\n' +
                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '    <span aria-hidden="true">&times;</span>\n' +
                '  </button>\n' +
                '</div>';
            $("#s_message").html(a);
            return;
        }

    });

    $('.qty_select2').on('select2:unselect', function (e) {
        e.preventDefault();
        let elem = e.params.data
        $(".quantity_"+elem.id).remove();

    });
    $('.qty_select2').on('select2:select', function (e) {
        e.preventDefault();
        let elem = e.params.data;
        var ht = '';
        ht+='<div class="form-group col-md-3 quantity_'+elem.id+'" data-quantity="'+elem.id+'">';
        ht+='<label for="">QTY: '+$.trim(elem.text)+'</label><div>';
        ht+='<input type="number" data-id="'+elem.id+'" name="quantity_discount['+elem.id+'][discount]" value="0" class="qty_discount_discounts"/>';
        ht+='<input type="hidden" data-id="'+elem.id+'" class="qty_discount_values" name="quantity_discount['+elem.id+'][value]" value="'+$.trim(elem.text)+'"/></div></div>'
        $("#discount_modal .modal-body .row").prepend(ht);
    });
    $(document).on('click','.add_new_type',function(){
        var attr_id = $(this).attr('data-id');
        var types_list = $("#types_list").html();
        var objs = $.parseJSON(types_list);
        var html = generateTypeSelectBox(objs[attr_id], attr_id);
        $("#attrsModal").modal('show');
    })
  $(document).on('click','.delete_attribute',function(){
      var attr_id = $(this).attr('data-id');
$("#accordion_card_"+attr_id).remove();

  })

    function generateTypeSelectBox(objs,attr_id){
        var seletdec_items = [];
        var listItems = $("#sortable_type_"+attr_id+" li");

        // Loop through each <li> element and retrieve the data-id attribute
        listItems.each(function(){
            var dataIdValue = $(this).data("id");
            seletdec_items.push(dataIdValue);
            // Do something with the data-id value
        });

        var selectBox = $('<select multiple="multiple" name="favorite_fruits" id="fruit_select">');
        $.each( objs, function( index, value ){
            selected_item = '';
            if ($.inArray(value.id, seletdec_items) !== -1) {
                selected_item = 'selected';
            }
            selectBox.append('<option value="'+value.id+'" '+selected_item+'>'+value.name+'</option>');
        });
        // Append the select box to the container
        $('#attrsModal .modal-body').html(selectBox);

        var select = document.getElementById("fruit_select");
        multi(select, {
            enable_search: true,
        });
        var notTouch = [];
        var addValues = [];
        var deleteValues=[];
        selectBox.on('change', function() {
            var selectedValue = $(this).val();
            var seletdec_items = [];
            var listItems = $("#sortable_type_"+attr_id+" li");

            // Loop through each <li> element and retrieve the data-id attribute
            listItems.each(function(){
                var dataIdValue = $(this).data("id");
                seletdec_items.push(dataIdValue);
                // Do something with the data-id value
            });

            array1 = selectedValue;
            array1 = array1.map(Number);
            array2 = seletdec_items;

            var needAdd = array1.filter(value => !array2.includes(value));

            // Find elements that exist in array2 but not in array1
            var needDelete = array2.filter(value => !array1.includes(value));

            for(var i=0; i<needDelete.length;i++){
                $('#sortable_type_'+attr_id+' li[data-id="' + needDelete[i] + '"]').remove();
            }
            var types_listJSON = $("#types_list").html();
            var type_list = $.parseJSON(types_listJSON);

            for(var i=0; i<needAdd.length;i++){
                var rel_attrs = [];
                $.each( type_list[attr_id], function( index, value ){
                    if(value.id == needAdd[i]){
                        rel_attrs = value.related_attrs;
                    }
                });
               if(rel_attrs.length > 0){
                   for(var k=0;k<rel_attrs.length; k++){
                       addAttrbiutesHtml(rel_attrs[k]);
                   }
               }
                var item_name = 'n/a';
                $.each( objs, function( index, value ){
                    if(value.id == needAdd[i]){
                         item_name = value.name;
                    }
                });
                var newLi = $('<li>').text(item_name).attr('data-id', needAdd[i]).addClass('list-group-item');
                // Append the new <li> to the <ul>
                $('#sortable_type_'+attr_id).append(newLi);
                //check related attributes
            }

        });
    }

    function addAttrbiutesHtml(attr_id){
        if($("#accordion_card_"+attr_id).length > 0){
            return;
        }
        var attr_list = $("#attr_list").html();
        var attr_list_obj = $.parseJSON(attr_list);
        var item_name = 'n/a';
        $.each( attr_list_obj, function( index, value ){
            if(index == attr_id){
                item_name = value;
            }
        });
        var attr_content = createAttrContent(attr_id,item_name);
        // Append the new <li> to the <ul>
        $('#accordionExample').append(attr_content);
        $("#sortable_type_"+needAdd[i]).sortable();
    }

  const shippingInfoBtn = document.getElementById('shipping_info');
  const shippingTypesDiv = document.querySelector('.shipping_types');
  const shippingTypesButtons = document.querySelector('.shipping_types_buttons');

  shippingInfoBtn.addEventListener('click', function() {
      if (shippingTypesDiv.style.display === 'none') {
          shippingTypesDiv.style.display = 'block';
          shippingTypesButtons.style.display = 'block';
      } else {
          shippingTypesDiv.style.display = 'none';
          shippingTypesButtons.style.display = 'none';
      }
  });

  $(document).on('click', '.mark_opened', function(e) {
      e.preventDefault();
      const $button = $(this);
      const dataId = $button.data('id');

      $.ajax({
          url: "{{route('dashboard.products.setAttributeAsOpened', $item->id)}}",
          method: 'POST',
          data: {
              _token: '{{ csrf_token() }}',
              attr_id: dataId
          },
          success: function(response) {
              if(response.is_removed){
                  $button.text('Set as open list');
              }else{
                  $button.text('Unset as open list');
              }
          },
          error: function(xhr) {
              console.error('Something went wrong!', xhr);
          }
      });
  });


</script>
@endpush
<div class="modal fade bd-example-modal-lg" id="discount_modal" tabindex="-1" role="dialog" >
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set discounts by %</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="quantity_form">
            <div class="modal-body">
                <div class="row">
                    @if(isset($item))
                        @if(!empty($discounts))
                            @foreach($discounts as $key=>$quantity)
                                <div class="form-group col-md-3 quantity_{{ $key }}" data-quantity="{{ $key }}">
                                    <label for="">QTY: {{ $quantity['value'] }}</label>
                                    <div>
                                        <input type="number" data-id="{{ $key }}" class="qty_discount_discounts" name="quantity_discount[{{$key}}][discount]" value="{{$quantity['discount']}}"/>
                                        <input type="hidden" data-id="{{ $key }}" class="qty_discount_values"    name="quantity_discount[{{$key}}][value]" value="{{$quantity['value']}}"/>

                                    </div>

                                </div>


                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
            </form>
            <div class="modal-footer">
                <button type="button" id="save_discount" class="btn btn-secondary" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="attrsModal" tabindex="-1" role="dialog" aria-labelledby="attrsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attrsModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>