@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="https://cdn.ckeditor.com/4.11.4/standard-all/ckeditor.js"></script>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
@endpush

@section('content')
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} product</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.products.update', ['id' => $item->id]) : route('dashboard.products.store') }}"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="card-body">

                            <ul class="nav nav-pills nav-pills-info mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="pills-10-tab" data-toggle="pill"
                                       href="#product_info" role="tab" aria-controls="product_info"
                                       aria-selected="true">Product Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-11-tab" data-toggle="pill" href="#product_attributes"
                                       role="tab" aria-controls="product_info" aria-selected="false">Attributes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-11-tab" data-toggle="pill" href="#product_deliveries"
                                       role="tab" aria-controls="product_info" aria-selected="false">Production time</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-11-tab" data-toggle="pill" href="#inputs"
                                       role="tab" aria-controls="product_info" aria-selected="false">Inputs</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent-3">
                                <div class="tab-pane fade show active" id="product_info" role="tabpanel"
                                     aria-labelledby="product_info">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Images ( 603 x 503 )</label>
                                        <div class="input-group hdtuto control-group lst increment">
                                            <input type="file" name="ajax_images[]"
                                                   class="form-control ajax_image_upload" multiple>
                                        </div>

                                        <div class="product_images">
                                            @if( isset($item) )
                                                @foreach($item->images as $i => $image)
                                                    <div class="product_image">
                                                        <img src="{{ asset('storage/content/' . $image) }}" width="100">
                                                        <input type="hidden" name="images[{{ $i + 9999 }}]"
                                                               value="{{ $image }}">
                                                        <button class="delete_image" type="button">
                                                            <span></span>
                                                            <span></span>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                        @error('images')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="video">Video</label>
                                        <input
                                            id="video"
                                            type="text"
                                            class="form-control"
                                            placeholder="Youtube video"
                                            name="video"
                                            value="{{ (isset($item) && isset($item->video) ) ? $item->video : old('video') }}"
                                        >
                                        @error('video')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input
                                            id="title"
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter title"
                                            name="title"
                                            value="{{ (isset($item) && isset($item->title) ) ? $item->title : old('title') }}"
                                        >
                                        @error('title')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="category_id">Category</label>
                                        <select id="category_id" class="form-control" name="category_id">
                                            <option value="">Please select a category</option>
                                            @foreach($categories as $category)
                                                <option data-title="{{ $category->name }}"
                                                        value="{{ $category->id }}" {{ (isset($item) && $item->category_id == $category->id) || old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror

                                        @error('subcategory_id')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="subcategories">
                                        @if(isset($item))
                                            <div class="form-group">
                                                <label for="subcategory_id">Sub Category</label>
                                                <select id="subcategory_id" class="form-control" name="subcategory_id">
                                                    @foreach($item->category->childs as $sub)
                                                        <option
                                                            value="{{ $sub->id }}" {{ $item->subcategory_id == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="content">Description</label>
                                        <textarea class="form-control" id="content" placeholder="Enter the Description"
                                                  name="description">{{ (isset($item) && isset($item->description) ) ? $item->description : old('description') }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="stock">Stock</label>
                                        <select id="stock" class="form-control stock" name="stock">
                                            <option value="1">In Stock</option>
                                            <option value="0">Out of stock</option>
                                        </select>
                                        @error('stock')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="text">Text</label>
                                        <input
                                            id="text"
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter text"
                                            name="text"
                                            value="{{ (isset($item) && isset($item->text) ) ? $item->text : old('text') }}"
                                        >
                                        @error('text')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="order">Order</label>
                                        <input
                                            id="order"
                                            type="number"
                                            class="form-control"
                                            placeholder="Enter Order"
                                            name="order"
                                            value="{{ (isset($item) && isset($item->order) ) ? $item->order : 0 }}"
                                        >
                                        @error('order')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="shipping_price">Shipping Price</label>
                                        <input
                                            id="shipping_price"
                                            type="number"
                                            class="form-control"
                                            placeholder="Enter Shipping Price"
                                            name="shipping_price"
                                            value="{{ (isset($item) && isset($item->shipping_price) ) ? $item->shipping_price : 0 }}"
                                        >
                                        @error('shipping_price')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="shipping_percent">Shipping Percent</label>
                                        <input
                                            id="shipping_percent"
                                            type="number"
                                            class="form-control"
                                            placeholder="Enter Shipping Percent"
                                            name="shipping_percent"
                                            value="{{ (isset($item) && isset($item->shipping_percent) ) ? $item->shipping_percent : 0 }}"
                                        >
                                        @error('shipping_percent')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="product_attributes" role="tabpanel"
                                     aria-labelledby="product_info">

                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm">Enable Sizes</label>
                                        <input class="tgl tgl-light tgl-primary" id="size_status"
                                               type="checkbox" {{ isset($item) && $item->sizes->count() ? 'checked' : '' }}>
                                        <label class="tgl-btn" for="size_status"></label>
                                    </div>

                                    <div class="size_types"
                                         style="display: {{ isset($item) && $item->sizes->count() ? 'block' : 'none' }}">

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

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="size_type" value="ft"
                                                   id="ft_only" {{ isset($item) && $item->size_type == 'ft' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ft_only">FT Only</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="size_type" value="in"
                                                   id="in_only" {{ isset($item) && $item->size_type == 'in' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="in_only">IN Only</label>
                                        </div>

                                        <div class="discounts_block">
                                            <button type="button" class="btn btn-success add_discount">Add Discount
                                            </button>
                                            @if(isset($item) && $item->square_discounts)
                                                @php
                                                    $discount_index = 0
                                                @endphp
                                                @foreach($item->square_discounts as $total => $discount)
                                                    <div class="form-group discount_group">
                                                        <div>
                                                            <label>Total Square FT</label>
                                                            <input type="number" min="0"
                                                                   class="form-control"
                                                                   placeholder="Over"
                                                                   name="square_discounts[{{ $discount_index }}][total]"
                                                                   value="{{ $total }}" required>
                                                        </div>
                                                        <div>
                                                            <label>Percent</label>
                                                            <input type="number"
                                                                   class="form-control"
                                                                   placeholder="Delivery percent"
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
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm">Enable Grommets</label>
                                        <input class="tgl tgl-light tgl-primary" id="grommet_status"
                                               type="checkbox" {{ isset($item) && $item->grommets->count() ? 'checked' : '' }}>
                                        <label class="tgl-btn" for="grommet_status"></label>
                                    </div>

                                    <div class="form-group quantities_select_block">
                                        <label for="quantities">Quantities</label>
                                        <select id="quantities" multiple="multiple" class="form-control"
                                                name="quantities[]">
                                            <option value="">Please select a quantities</option>
                                            @foreach($quantities as $quantity)
                                                <option data-title="{{ $quantity->number }}"
                                                        value="{{ $quantity->id }}" {{ ( isset($item) && count( $item->details->where('quantity_id', $quantity->id) ) ) || old('attributes') == $quantity->id ? 'selected' : '' }}>{{ $quantity->number }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group attributes_select_block">
                                        <label for="attributes">Attributes</label>
                                        <select id="attributes" multiple="multiple" class="form-control">
                                            <option value="">Please select a attributes</option>
                                            @foreach($attributes as $attribute)
                                                <option data-title="{{ $attribute->name }}"
                                                        value="{{ $attribute->id }}" {{ ( isset($item) && $item->attributes->contains($attribute->id) ) || old('attributes') == $attribute->id ? 'selected' : '' }}>{{ $attribute->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group custom_sizes"
                                         style="display: {{ isset($item) && $item->sizes->count() ? 'block' : 'none' }}">
                                        <label for="sizes">Sizes</label>
                                        <select id="sizes" multiple="multiple" class="form-control"
                                                name="custom_sizes[]">
                                            <option value="">Please select a sizes</option>
                                            @foreach($sizes as $size)
                                                <option data-title="{{ $size->ft }}"
                                                        value="{{ $size->id }}" {{ ( isset($item) && count($item->sizes->where('size_id', $size->id)) ) || old('attributes') == $size->id ? 'selected' : '' }}>
                                                    '{{ $size->ft }}' - "{{ $size->in }}"
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="attribute_types">
                                        @if(isset($item))
                                            @foreach($item->attributes as $attribute)
                                                <div class="form-group row type_group type_{{ $attribute->id }}">
                                                    <div class="col-md-12">
                                                        <label
                                                            for="attribute_{{ $attribute->id }}">{{ $attribute->name }}</label>
                                                        <select id="attribute_{{ $attribute->id }}" multiple="multiple"
                                                                class="form-control edit_select2">
                                                            @foreach($types as $type)
                                                                @if($attribute->id == $type->attribute_id)
                                                                    <option data-title="{{ $type->name }}"
                                                                            value="{{ $type->id }}" {{ count($item->details->where('type_id', $type->id)) ? 'selected' : '' }}>{{ $type->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" min="0"
                                                               name="attributes[{{ $attribute->id }}][order]"
                                                               value="{{ $attribute->pivot->order }}"
                                                               class="form-control attribute_order_input"
                                                               data-id="{{ $attribute->id }}"
                                                        >
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="quantities_blocks">
                                        @if(isset($item))
                                            @foreach($item->details->unique('quantity_id') as $quantity)
                                                <div class="quantity_block quantity_{{ $quantity->quantity->id }}"
                                                     data-quantity="{{ $quantity->quantity->id }}">
                                                    <div class="quantity_top_block">
                                                        <h4>Prices for quantity {{ $quantity->quantity->number }}</h4>
                                                        <div>Total: <b>$<span
                                                                    class="quantity_total">{{ $item->details->where('quantity_id', $quantity->quantity->id)->sum('price') }}</span></b>
                                                        </div>
                                                    </div>
                                                    <div class="quantity_attributes">
                                                        @foreach($item->details as $detail)
                                                            @if($detail->quantity_id == $quantity->quantity->id)
                                                                <div
                                                                    class="attr_group type_{{ $detail->type->attribute_id }} group_{{ $detail->type_id }}">
                                                                    <input type='hidden'
                                                                           name="types[quantity_{{ $detail->quantity_id }}_type_{{ $detail->type_id }}][product_id]"
                                                                           value="{{ $detail->product_id }}">
                                                                    <input type='hidden'
                                                                           name="types[quantity_{{ $detail->quantity_id }}_type_{{ $detail->type_id }}][quantity_id]"
                                                                           value="{{ $detail->quantity_id }}">
                                                                    <input type='hidden'
                                                                           name="types[quantity_{{ $detail->quantity_id }}_type_{{ $detail->type_id }}][type_id]"
                                                                           value="{{ $detail->type_id }}"
                                                                           class="type_id_for_order">
                                                                    <input readonly type='text'
                                                                           value="{{ $detail->type->name }}"
                                                                           class='form-control'>
                                                                    <span>$</span>
                                                                    <input type="number" step="0.0001"
                                                                           name="types[quantity_{{ $detail->quantity_id }}_type_{{ $detail->type_id }}][price]"
                                                                           value="{{ $detail->price }}"
                                                                           class="form-control qnt_item_price">
                                                                    <input type="hidden"
                                                                           name="types[quantity_{{ $detail->quantity_id }}_type_{{ $detail->type_id }}][order]"
                                                                           value="{{ $detail->order }}"
                                                                           class="qnt_item_order">
                                                                    <input type="hidden"
                                                                           name="types[quantity_{{ $detail->quantity_id }}_type_{{ $detail->type_id }}][quantity_order]"
                                                                           value="{{ $detail->quantity_order }}"
                                                                           class="quantity_order"
                                                                           data-id="{{ $detail->quantity_id }}">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="quantity_sizes">
                                                        @if($item->sizes->count())
                                                            <h6>Sizes</h6>
                                                            @foreach($item->sizes as $size)
                                                                @if($size->quantity_id == $quantity->quantity->id)
                                                                    <div
                                                                        class="attr_group {{ $size->size_id ? 'size_' . $size->size_id : 'square_size' }}"
                                                                        style="display: {{ $size->size_id ? 'none' : '' }}">
                                                                        @if($size->size_id)
                                                                            <input readonly type='text'
                                                                                   value='{{ $size->size->ft }}'
                                                                                   class='form-control'>
                                                                            <span>$</span>
                                                                            <input type="text" step="0.0001"
                                                                                   name="sizes[quantity_{{$size->quantity_id}}_size_{{$size->size_id}}][price]"
                                                                                   value="{{$size->price}}"
                                                                                   class="form-control square_ft_price">
                                                                            <input type="hidden"
                                                                                   name="sizes[quantity_{{$size->quantity_id}}_size_{{$size->size_id}}][quantity_id]"
                                                                                   value="{{$size->quantity_id}}">
                                                                            <input type="hidden"
                                                                                   name="sizes[quantity_{{$size->quantity_id}}_size_{{$size->size_id}}][size_id]"
                                                                                   value="{{$size->size_id}}">
                                                                            <input type="hidden"
                                                                                   name="sizes[quantity_{{$size->quantity_id}}_size_{{$size->size_id}}][product_id]"
                                                                                   value="{{$item->id}}">
                                                                        @else
                                                                            <input type="text" readonly
                                                                                   value="Square FT"
                                                                                   class="form-control">
                                                                            <span>$</span><input type="text"
                                                                                                 step="0.0001"
                                                                                                 name="sizes[quantity_{{$size->quantity_id}}][price]"
                                                                                                 value="{{$size->price}}"
                                                                                                 class="form-control square_ft_price">
                                                                            <input type="hidden"
                                                                                   name="sizes[quantity_{{$size->quantity_id}}][quantity_id]"
                                                                                   value="{{$size->quantity_id}}">
                                                                            <input type="hidden"
                                                                                   name="sizes[quantity_{{$size->quantity_id}}][product_id]"
                                                                                   value="{{$item->id}}">
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="quantity_grommets">
                                                        @if($item->grommets->count())
                                                            <h6>Grommets</h6>
                                                            @foreach($item->grommets as $grommet)
                                                                @if($grommet->pivot->quantity_id == $quantity->quantity_id)
                                                                    <div class="attr_group">
                                                                        <input type="text" readonly
                                                                               value="Grommet price"
                                                                               class="form-control">
                                                                        <span>$</span><input type="text" step="0.0001"
                                                                                             name="grommets[{{ $grommet->pivot->quantity_id }}][price]"
                                                                                             value="{{ $grommet->pivot->price }}"
                                                                                             class="form-control">
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="product_deliveries" role="tabpanel"
                                     aria-labelledby="product_info">

                                    <div class="delivery_groups">
                                        @if(isset($item))
                                            @foreach($item->deliveries as $d => $delivery)
                                                <div class="form-group delivery_group">
                                                    <div>
                                                        <label>Delivery title</label>
                                                        <input type="text" class="form-control"
                                                               placeholder="Delivery title"
                                                               name="delivery[{{$d}}][title]"
                                                               value="{{ $delivery->title }}" required>
                                                    </div>
                                                    <div>
                                                        <label>Delivery percent</label>
                                                        <input type="text" class="form-control"
                                                               placeholder="Delivery price"
                                                               name="delivery[{{$d}}][price]"
                                                               value="{{ $delivery->price }}" required>
                                                    </div>
                                                    <button type="button" class="btn btn-danger delete_delivery_type">
                                                        Delete
                                                    </button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <button type="button" class="btn btn-success add_delivery_type">Add</button>

                                </div>

                                <div class="tab-pane fade" id="inputs" role="tabpanel"
                                     aria-labelledby="product_info">

                                    <div class="custom_inputs">
                                        @if(isset($item))
                                            @foreach($item->inputs as $i => $input)
                                                <div class="form-group custom_input_group">
                                                    <div>
                                                        <label>Title</label>
                                                        <input type="text" class="form-control"
                                                               placeholder="Delivery title"
                                                               name="inputs[{{$i}}][title]"
                                                               value="{{ $input->title }}" required>
                                                    </div>
                                                    <button type="button" class="btn btn-danger delete_custom_input">
                                                        Delete
                                                    </button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <button type="button" class="btn btn-success add_custom_input">Add</button>

                                </div>
                            </div>

                        </div>
                        <div class="card-footer bg-light">
                            <button class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary clear-form">Clear</button>
                        </div>
                    </form>
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
            $quantities_array = json_encode($quantities->toArray());
            echo "let quantities_object = ". $quantities_array . ";\n";
            $categories_array = json_encode($all_categories->toArray());
            echo "let categories_array = ". $categories_array . ";\n";
        @endphp
    </script>
    <script src="{{ asset('admin/assets/js/product.js') }}"></script>
    <script>
        $(document).ready(function () {

            $(document).on('change', '.ajax_image_upload', function () {
                let _token = $(this).parents('form').find('[name=_token]').val(),
                    formData = new FormData

                $.each($(this).prop('files'), function (key, val) {
                    formData.append('images[]', val);
                });
                formData.append('_token', _token);

                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.products.upload') }}",
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.success && data.images) {
                            jQuery.each(JSON.parse(data.images), (index, item) => {
                                let rnd = Math.floor(Math.random() * (9999999999 - 1111111111 + 1) + 1111111111),
                                    path = item.substr(item.indexOf("storage/content/") + 16)
                                $('.product_images').append('<div class="product_image"><img src="' + item + '" width="100"><input type="hidden" name="images[' + rnd + ']" value="' + path + '"> <button class="delete_image" type="button"><span></span><span></span></button></div>')
                            });
                        }
                    }
                });
            })

        });
    </script>
@endpush
