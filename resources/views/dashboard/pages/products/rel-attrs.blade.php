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
    $attr_info[$a->id] = $a->name;
}
$quantity = json_decode($item->quantity_discount,true);

?>
@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <h5 class="card-header">Product attributes</h5>
                        @csrf
                        <div class="card-body">
                        <div id="s_message"></div>
                            <div class="tab-content" id="pills-tabContent-3">



    <div class="accordion" id="accordionExample" >
        <div id="hidden_values">
            @if(!empty($hidden_types))
                @foreach($hidden_types as $key=>$hid)
                    @foreach($hid as $vid)
                         <input type="hidden" name="hiddenTypes[{{$key}}][]" data-id = "{{$key}}" class="hidden_input_values" value="{{$vid}}"/>
                    @endforeach
                @endforeach
                @endif
        </div>
        @if(!empty($selected_types))
            @foreach($selected_types as $attr_key => $attr_array)
                <div class="card" id="accordion_card_{{$attr_key}}">
                    <div class="card-header-big">
                        <div class="card-header" id="heading_{{$attr_key}}">
                            <div class="row">
                            <h2 class="mb-0 col-md-7">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_{{$attr_key}}" aria-expanded="false" aria-controls="collapse_{{$attr_key}}">
                                    @foreach($attributes as $attr)
                                        @if($attr_key == $attr->id)
                                            {{$attr->name}}
                                            @break
                                        @endif
                                    @endforeach
                                </button>
                            </h2>
                            </div>
                        </div>
                    </div>
                    <div id="collapse_{{$attr_key}}" class="collapse" aria-labelledby="heading_{{$attr_key}}" data-parent="#accordionExample">
                        <div class="card-body">
                            <ul id="sortable_type_{{$attr_key}}" class="list-group">
                                @foreach($attr_array as $type_arr)
                                    @foreach($types as $type_info)
                                        @if($type_info->id == $type_arr)
                                            <li class="row" data-id="{{$type_info->id}}" style="padding: 10px; border-bottom:1px solid black">
                                            <div class="col-md-8">
                                                {{$type_info->name}}
                                            </div>
                                            <div class="col-md-2">
                                                <a href="javascript:void(0)" data-id="{{$type_info->id}}" data-attr="{{$attr_key}}" data-name="{{$type_info->name}}" class="delete_attribute btn btn-warning">Hide types</a>
                                            </div>
                                            </li>
                                            @break
                                        @endif
                                    @endforeach

                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            @endforeach
                <div class="card" id="accordion_card_qty">
                    <div class="card-header-big">
                        <div class="card-header" id="heading_qty">
                            <div class="row">
                                <h2 class="mb-0 col-md-7">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_qty" aria-expanded="false" aria-controls="collapse_qty">
                                         Quantity
                                    </button>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div id="collapse_qty" class="collapse" aria-labelledby="heading_qty" data-parent="#accordionExample">
                        <div class="card-body">
                            <ul id="sortable_type_qty" class="list-group">
                                @foreach($quantity as $key=>$qty_arr)
                                            <li class="row" data-id="qty-{{$key}}" style="padding: 10px; border-bottom:1px solid black">
                                                <div class="col-md-8">
                                                   QTY - {{$qty_arr['value']}}
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="javascript:void(0)" data-id="qty-{{$key}}" data-attr="qty" data-name="QTY-{{$key}}" class="delete_attribute btn btn-warning">Hide types</a>
                                                </div>
                                            </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
        @endif
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
<div id="types_info" style="display:none;">{{$type_lists}}</div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="{{ asset('admin/assets/css/multi.min.js') }}"></script>
<script>
  $(document).ready(function(){

    $("#accordionExample").accordion({
          collapsible: true,
          header: "> div > .card-header",
          heightStyle: "content"
      });
  })
  function generateTypeSelectBox(objs,attr_id){
      var seletdec_items = [];
      var hiddenInputs = $('input[type="hidden"][data-id="' + attr_id + '"]');
      if(hiddenInputs.length > 0){
          hiddenInputs.each(function(){
              var dataIdValue = $(this).val();

              if (dataIdValue.includes("qty")) {
                  // The value contains 'qty'
                  dataIdValue = dataIdValue;
              } else {
                  // The value does not contain 'qty'
                  dataIdValue = parseInt(dataIdValue);
              }
              seletdec_items.push(dataIdValue);
          });
      }
      var selectBox = $('<select multiple="multiple" name="favorite_fruits" id="fruit_select">');
      $.each( objs, function( index, value ){
          selected_item = '';
          if ($.inArray(value.id, seletdec_items) !== -1) {
              selected_item = 'selected';
          }
          if(value.id !=attr_id){
              selectBox.append('<option value="'+value.id+'" '+selected_item+'>'+value.name+'</option>');
          }
      });
      // Append the select box to the container
      $('#attrsModal .modal-body').html(selectBox);
      var select = document.getElementById("fruit_select");
      multi(select, {
          enable_search: true,
      });
      selectBox.on('change', function() {
         var input_text = '';
         var hiddenInputs = $('input[type="hidden"][data-id="' + attr_id + '"]');
         hiddenInputs.remove();
         var selected = $(this).val();
         if(selected.length > 0){
             for(var i=0;i<selected.length;i++){
                input_text+='<input type="hidden" name="hiddenTypes['+attr_id+'][]" data-id = "'+attr_id+'" class="hidden_input_values" value="'+selected[i]+'"/>';
             }
         }
         $("#hidden_values").append(input_text);
      });
  }
    $("#save_form").on('click',function () {
        $(this).html('Loading...');
        $(".card-header-big").removeClass('error_message')
            var selectedAttrs = [];
            var listItems = $(".hidden_input_values");

                listItems.each(function(){
                    var dataIdValue = $(this).val();
                    var data_type = $(this).data("id");
                    selectedAttrs.push({id:data_type, hidden_id:dataIdValue})
                });
                var empty_data = 2;
                if(selectedAttrs.length == 0){
                    empty_data == 1;
                }

                $.ajax({
                    type: "POST",
                    url: "{{route('dashboard.products.editAttrs', $item->id)}}",
                    data: { "related_types":selectedAttrs, "empty_data":empty_data},
                    dataType: 'json',
                    success: (data) => {
                        var newActionURL = "{{route('dashboard.products.index')}}";

                        // Redirect to the new action
                        window.location.href = newActionURL;
                    }
                });




    })


  $(document).on('click','.delete_attribute',function(){

      var type_id = $(this).attr('data-id');

      var attr_id = $(this).attr('data-attr');
      var name = $(this).attr('data-name');
      var types_listJSON = $("#types_info").html();

      var objs = $.parseJSON(types_listJSON);
      generateTypeSelectBox(objs,type_id);
      $("#attrsModalLabel").html('Hide types for '+name);
      $("#attrsModal").modal('show');

  })


</script>
@endpush



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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>