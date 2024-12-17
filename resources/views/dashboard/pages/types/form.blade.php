@extends('layouts.admin')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

@endpush
@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} type</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.types.update', ['id' => $item->id]) : route('dashboard.types.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="exampleInputEmail1">Attribute</label>
                                    <select class="form-control edit_select2" name="attribute_id" id="attribute_id">
                                        <option value="">Please select a attribute</option>
                                        @foreach($attributes as $attribute)
                                            <option data-title="{{ $attribute->name }}" value="{{ $attribute->id }}" {{ (isset($item) && $item->attribute_id == $attribute->id) || old('attribute_id') == $attribute->id ? 'selected' : '' }}>
                                                {{ $attribute->name }}
                                                @if($attribute->notes)
                                                    ({{$attribute->notes}})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('attribute_id')
                                     <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter name"
                                        name="name"
                                        value="{{ (isset($item) && isset($item->name) ) ? $item->name : old('name') }}"
                                    >
                                    @error('name')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6 img">
                                    <label>Image</label>
                                    <div class="custom-file input-group">
                                        <input type="file" class="custom-file-input" id="typeIcon" name="img"
                                               value="{{ (isset($item) && isset($item->img) ) ? $item->img : old('img') }}">
                                        <input type="hidden" class="custom-file-input" id="typeIcon" name="img"
                                               value="{{ (isset($item) && isset($item->img) ) ? $item->img : old('img') }}">
                                        <label class="custom-file-label" for="typeIcon"> {{ isset($item->img) ? basename($item->img) : 'Choose file' }}</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 imagePreview_block" style="display: {{isset($item->img) ? 'block' : 'none'}}">
                                    <img class="imagePreview" style="max-width: 100px; max-height: 100px;" alt="Image preview"
                                         src="{{isset($item->img)  ? asset('/storage/content/types/'.$item->img) : ''}}"/>
                                    <button class="btn btn-danger remove-img-btn" type="button">-</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="uploadedFileType">Uploaded file type</label>
                                    <select class="form-control edit_select2" name="uploadedFileTypeIds[]" id="uploadedFileType" multiple>
                                        <option value="" disabled>Please select a uploaded file type</option>
                                        @foreach($uploadedFileTypes as $uploadedFileType)
                                            <option value="{{ $uploadedFileType->id }}"
                                                    {{ ((isset($item) && isset($item->uploadedFileTypeIds) && in_array($uploadedFileType->id,  $item->uploadedFileTypeIds))) || (!isset($item) && $uploadedFileType->id==1) || (old('uploadedFileTypeId') == $uploadedFileType->id) ? 'selected' : '' }}>
                                                {{ $uploadedFileType->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('uploadedFileType')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="exampleInputEmail1">HEX for Color</label>
                                    <input
                                            id="color_hex"
                                            type="text"
                                            class="form-control"
                                            placeholder="#EEF5FF"
                                            name="color_hex"
                                            value="{{ (isset($item) && isset($item->color_hex) ) ? $item->color_hex : old('color_hex') }}"
                                    >
                                    @error('color_hex')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-2">
                                    <label></label>
                                    <div id="color_show" class="hidden"></div>
                                </div>
                            </div>

                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingPrice">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" aria-expanded="true" data-target="#price" aria-controls="price">
                                               Price
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="price" class="collapse" aria-labelledby="headingPrice" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <select  name="full_paper" id="form_full_paper" style="margin-bottom: 20px;display: {{ ((isset($item) && ($item->attribute_id == 2)) || old('attribute_id') == 2 ) ? 'none' : 'block' }}">
                                                <option value="0" {{ ((isset($item) && $item->full_paper == 0) || old('full_paper') === 0) ? 'selected' :'' }}>Calculate per PRODUCT item</option>
                                                <option value="1" {{ ((isset($item) && $item->full_paper == 1) || old('full_paper') === 1) ? 'selected' :'' }}>Calculate per printing list</option>
                                                <option value="2" {{ ((isset($item) && $item->full_paper == 2) || old('full_paper') === 2) ? 'selected' :'' }}>Calculate by sqr.</option>
                                            </select>
                                            <div class="per_list"  id="form_per_list" style="display: {{ (isset($item) && ($item->full_paper == 1)) || old('full_paper') == 1 ? 'block' : 'none' }}">
                                                <div class="quantities_blocks">
                                                    <ul class="nav nav-tabs" id="printTypeTabs" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="simple-print-tab" data-toggle="tab" href="#simple-print" role="tab" aria-controls="simple-print" aria-selected="true">Simple Print</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="machine-print-tab" data-toggle="tab" href="#machine-print" role="tab" aria-controls="machine-print" aria-selected="false">Machine Print</a>
                                                        </li>
                                                    </ul>

                                                    <div class="tab-content" id="printTypeContent">
                                                        <?php
                                                            $price_info = [];
                                                            if(isset($item)){
                                                                $price_info = $item->getFullPaperInfo();
                                                            }
                                                        ?>
                                                        <!-- Simple Print Tab Pane -->
                                                        <div class="tab-pane fade show active" id="simple-print" role="tabpanel" aria-labelledby="simple-print-tab">
                                                            <div class="quantity_block quantity_12" data-quantity="12">
                                                                <div class="quantity_top_block">
                                                                    <h4>Price Per Item (Simple Print)</h4>
                                                                </div>
                                                            </div>

                                                            <!-- Price Inputs for Simple Print -->
                                                            <div class="quantity_attributes">
                                                                @foreach($sizes as $size)
                                                                    <div class="attr_group type_1 group_3">
                                                                        <input type="hidden" name="sizes[{{$size->id}}][size_id]" value="{{$size->id}}"/>
                                                                        <input readonly="" name="sizes[{{$size->id}}][size]" type="text" value="{{ $size->in }}" class="form-control">
                                                                        <span>$</span>
                                                                        <input type="number" step="0.01" name="sizes[{{$size->id}}][price]" value="{{old('sizes.' . $size->id . '.price', isset($price_info[$size->id]) ? $price_info[$size->id]['price'] : 0)}}" class="form-control qnt_item_price">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <!-- Machine Print Tab Pane -->
                                                        <div class="tab-pane fade" id="machine-print" role="tabpanel" aria-labelledby="machine-print-tab">
                                                            <div class="quantity_block quantity_12" data-quantity="12">
                                                                <div class="quantity_top_block">
                                                                    <h4>Price Per Item (Machine Print)</h4>
                                                                </div>
                                                            </div>

                                                            <!-- Price Inputs for Machine Print -->
                                                            <div class="quantity_attributes">
                                                                @foreach($sizes as $size)
                                                                    <div class="attr_group type_1 group_3">
                                                                        <input type="hidden" name="sizes[{{$size->id}}][size_id]" value="{{$size->id}}"/>
                                                                        <input readonly="" name="sizes[{{$size->id}}][size]" type="text" value="{{ $size->in }}" class="form-control">
                                                                        <span>$</span>
                                                                        <input type="number" step="0.01" name="sizes[{{$size->id}}][machine_price]" value="{{old('sizes.' . $size->id . '.machine_price', (isset($price_info[$size->id]) && isset($price_info[$size->id]['machine_price'])) ? $price_info[$size->id]['machine_price'] : 0)}}" class="form-control qnt_item_price">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>




{{--                                                    <div class="quantity_block quantity_12" data-quantity="12">--}}
{{--                                                        <div class="quantity_top_block">--}}
{{--                                                            <h4>Price Per Item</h4>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                        <?php--}}
{{--                                                        $price_info = [];--}}
{{--                                                        if(isset($item)){--}}
{{--                                                            $price_info = $item->getFullPaperInfo();--}}
{{--                                                        }--}}
{{--                                                        ?>--}}
{{--                                                    <div class="quantity_attributes">--}}
{{--                                                        @foreach($sizes as $size)--}}
{{--                                                            <div class="attr_group type_1 group_3">--}}
{{--                                                                <input type="hidden" name="sizes[{{$size->id}}][size_id]" value="{{$size->id}}"/>--}}
{{--                                                                <input readonly="" name="sizes[{{$size->id}}][size]" type="text" value="{{ $size->in }}" class="form-control">--}}
{{--                                                                <span>$</span>--}}
{{--                                                                <input type="number" step="0.01" name="sizes[{{$size->id}}][price]" value="{{old('sizes.' . $size->id . '.price', isset($price_info[$size->id]) ? $price_info[$size->id]['price'] : 0)}}" class="form-control qnt_item_price">--}}
{{--                                                            </div>--}}
{{--                                                        @endforeach--}}
{{--                                                    </div>--}}
                                                </div>
                                            </div>
                                            <div class="form_per_item"  id="form_per_item" style="display: {{ ((isset($item) && (($item->full_paper == 0 ) && $item->attribute_id !=2) ) ||  (old('full_paper') === 0 && old('attribute_id') !== 2)) ? 'block' : 'none' }}">
                                                <div class="form-group col-sm-6 px-0" id="price_block_id">
                                                    <label for="exampleInputEmail1">Price</label>
                                                    <input
                                                            type="number"
                                                            step="0.01"
                                                            class="form-control"
                                                            placeholder="Price"
                                                            name="price"
                                                            value="{{ (isset($item) && isset($item->price) ) ? $item->price : old('price') }}"
                                                    >
                                                    @error('price')
                                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form_per_sqr"  id="form_per_sqr" style="display: {{ ((isset($item) && (($item->full_paper == 2 ) && $item->attribute_id !=2) ) ||  (old('full_paper') == 2 && old('attribute_id') != 2)) ? 'block' : 'none' }}">
                                                <div class="form-group col-sm-6 px-0" id="price_block_id">
                                                    <label for="exampleInputEmail1">Price for 1 SQR FT</label>
                                                    <input
                                                            type="number"
                                                            step="0.01"
                                                            class="form-control"
                                                            placeholder="Price"
                                                            name="price_sqr"
                                                            value="{{ (isset($item) && isset($item->price) ) ? $item->price : old('price') }}"
                                                    >
                                                    @error('price')
                                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTypeDetails">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" aria-expanded="true" data-target="#typeDetails" aria-controls="typeDetails">
                                                Type Details
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="typeDetails" class="collapse clear_body" aria-labelledby="headingTypeDetails" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control"
                                                           placeholder="Type title"
                                                           name="type_details[title]"
                                                           value="{{ (isset($item) && isset($item->type_details['title']) ) ? $item->type_details['title'] : old('type_details[title]') }}">
                                                </div>
                                                <div class="col-4">
                                                    <label>Text on image</label>
                                                    <input type="text" class="form-control"
                                                           placeholder="Text on Image"
                                                           name="type_details[image_text]"
                                                           value="{{ (isset($item) && isset($item->type_details['image_text']) ) ? $item->type_details['image_text'] : old('type_details[image_text]') }}">
                                                </div>
                                                <div class="col-3 img">
                                                    <label>Image</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile" name="type_details[image]"
                                                               value="{{ (isset($item) && isset($item->type_details['image']) ) ? $item->type_details['image'] : old('type_details[image]') }}">
                                                        <input type="hidden" class="custom-file-input" id="customFile" name="type_details[image]"
                                                               value="{{ (isset($item) && isset($item->type_details['image']) ) ? $item->type_details['image'] : old('type_details[image]') }}">
                                                        <label class="custom-file-label" for="customFile"> {{ isset($item->type_details['image']) ? basename($item->type_details['image']) : 'Choose file' }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-1 imagePreview_block" style="display: {{isset($item->type_details['image']) ? 'block' : 'none'}}">
                                                    <img id="imagePreview" class="imagePreview" style="max-width: 100px; max-height: 100px;" alt="Image preview"
                                                         src="{{isset($item->type_details['image'])  ? asset('/storage/content/'.$item->type_details['image']) : ''}}"/>
                                                </div>
                                            </div>
                                            <div class="row mt-5 input-container" id="input-container">
                                                @forelse($item->type_details['description_lines'] ?? [] as $key => $line)
                                                    <div class="col-4 input_block" id="input_block">
                                                        <div class="input-group mb-3 clone_block">
                                                            <input type="text" class="form-control" placeholder="Description Line" name="type_details[description_lines][]"
                                                            value="{{$line}}">
                                                            <div class="input-group-append">
                                                                @if($key)
                                                                    <button class="btn btn-danger remove-btn" type="button">-</button>
                                                                @else
                                                                    <button class="btn btn-success btn-outline-success add-btn" type="button">+</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="col-4 input_block" id="input_block">
                                                        <div class="input-group mb-3 clone_block">
                                                            <input type="text" class="form-control" placeholder="Description Line" name="type_details[description_lines][]">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-success btn-outline-success add-btn" type="button">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-secondary clear-extra-form">Clear Type Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="form-group" id="size_block_id" style="display: {{ (isset($item) && ($item->attribute_id == 2)) ? 'block' : 'none' }}">
                            <label for="size_id">Size</label>
                            <select id="size_id" class="form-control edit_select2" name="size_id">
                                <option value="">Please select a Size</option>
                                @foreach($all_sizes as $size)
                                    <option data-title="{{ $size->in }}"
                                            value="{{ $size->id }}" {{ (isset($item) && $item->size_id == $size->id) || old('size_id') == $size->id ? 'selected' : '' }}>{{ $size->in }}</option>
                                @endforeach
                            </select>
                            @error('size_id')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>
                            <?php
                            if(isset($item)){
                                $attrs = $item->hasRelatedAttrs();

                            }else{
                                $attrs = [];
                            }
                            ?>

                            <?php $relatedAttributesErrors = $errors->getBag('default')->get('related_attributes') ?>




                        <div class="card-footer bg-light">
                            <button class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary clear-form">Clear</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if(isset($item))
            <div class="row">
            <div class="col-12">
                <p class="h2">
                    <a class="btn btn-warning" data-toggle="collapse" href="#product_type_images" role="button" aria-expanded="false" aria-controls="product_type_images">
                        <span class="h6"> Upload product images for this type here <strong>(only for colors)</strong></span>
                    </a>
                </p>

                <div class="collapse" id="product_type_images">
                    <div class="card card-body">
                        <form
                                method="post"
                                action="{{ route('dashboard.types.storeProductImagesByType', $item->id) }}"
                                enctype="multipart/form-data"
                                id="product_type_images_form">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="exampleInputEmail1">Products</label>
                                    <select class="form-control edit_select2" name="product_id" id="product_id">
                                        <option value="">Please select a product</option>
                                        @foreach($products as $product)
                                            <option data-title="{{ $product->title }}" value="{{ $product->id }}">
                                                {{ $product->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6 align-items-end d-flex">
                                    <button class="btn btn-success add_product_type_images">Add</button>
                                </div>
                            </div>
                            <div class="input-container">
                                <div class="row align-items-end d-flex clone_block ">
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Uploaded file type (side)</label>
                                        <select class="form-control uploaded_file_type_id" name="uploaded_file_type_id">
                                            <option value="">Please select a side</option>
                                            @foreach($uploadedFileTypes as $item)
                                                <option data-title="{{ $item->title }}" value="{{ $item->id }}">
                                                    {{ $item->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('uploaded_file_type_id')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3 img">
                                        <label>Image</label>
                                        <div class="custom-file input-group">
                                            <input type="file" class="custom-file-input" name="img"
                                                   value="{{ (isset($item) && isset($item->img) ) ? $item->img : old('img') }}">
                                            <label class="custom-file-label"> {{ isset($item->img) ? basename($item->img) : 'Choose file' }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-2 imagePreview_block" style="display: {{isset($item->img) ? 'block' : 'none'}}">
                                        <img class="imagePreview" style="max-width: 100px; max-height: 100px;" alt="Image preview"
                                             src="{{isset($item->img)  ? asset('/storage/content/types/'.$item->img) : ''}}"/>
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <button class="btn btn-danger remove-btn" type="button">-</button>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="exampleInputEmail1">Width</label>
                                        <input
                                                type="number"
                                                class="form-control"
                                                placeholder="Enter Width"
                                                name="width"
                                                value=""
                                        >
                                        @error('width')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="exampleInputEmail1">Height</label>
                                        <input
                                                type="number"
                                                class="form-control"
                                                placeholder="Enter Height"
                                                name="height"
                                                value=""
                                        >
                                        @error('height')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="exampleInputEmail1">Top</label>
                                        <input
                                                type="number"
                                                class="form-control"
                                                placeholder="Enter Top"
                                                name="top"
                                                value=""
                                        >
                                        @error('top')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="exampleInputEmail1">Left</label>
                                        <input
                                                type="number"
                                                class="form-control"
                                                placeholder="Enter Left"
                                                name="left"
                                                value=""
                                        >
                                        @error('left')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer bg-light">
                                <button class="btn btn-primary submit_product_type_images_form">Submit</button>
                                <button type="button" class="btn btn-secondary clear_product_type_images_form">Clear</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </section>

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
        var productImagesByType = @json($product_images_by_type ?? []);

        $('.edit_select2').select2({width: '100%' });
        $('.edit_select3').select2({width: '100%', multiple:true });

        $(document).on('change', '#customFile, #typeIcon, .custom-file-input', function () {
            const file = this.files[0];
            const block = $(this).closest('.img').next('.imagePreview_block');

            imagePreview(file, block);
        });
        $(document).on('click', '.remove-img-btn', function () {
            const previewBlock = $(this).closest('.imagePreview_block');
            const fileInput = previewBlock.prev('.img').find('.custom-file-input');
            const fileInputLabel = previewBlock.prev('.img').find('.custom-file-label');

            fileInput.val('');
            fileInputLabel.text('Choose file');
            previewBlock.hide();
        });
        $(document).on('click', '.clear_product_type_images_form', function () {
            $(this)
                .closest("form")
                .find(".clone_block:not(:first)")
                .remove();
        });

        $(document).on('change','#attribute_id',function(){
            if($(this).val() == 2){
                $("#form_per_sqr").hide();
                $("#form_full_paper").hide();
                $("#size_block_id").show();
                $("#form_per_item").hide();
                $("#form_per_list").hide();
            }else{
                var sel_form = $("#form_full_paper").val();
                if( sel_form == 1){
                    $("#form_per_item").hide();
                    $("#form_per_sqr").hide();
                    $("#form_full_list").show();
                }else if(sel_form == 2){
                    $("#form_full_list").hide();
                    $("#form_per_item").hide();
                    $("#form_per_sqr").show();
                }else{
                    $("#form_per_item").show();
                    $("#form_per_sqr").hide();
                    $("#form_full_list").hide();
                }
                $("#form_full_paper").show();
                $("#size_block_id").hide();
            }

        });

        $(".submit_product_type_images_form").on("click", function(e) {
            e.preventDefault();

            let ajaxFormData = new FormData();

            $('.clone_block').each(function() {
                let fileTypeId = $(this).find('.uploaded_file_type_id').val() ?? null;
                let fileInput = $(this).find('input[name="img"]')[0];

                let width = $(this).find('input[name="width"]').val();
                let height = $(this).find('input[name="height"]').val();
                let left = $(this).find('input[name="left"]').val();
                let top = $(this).find('input[name="top"]').val();

                if (fileTypeId) {
                    ajaxFormData.append(`${fileTypeId}[width]`, width ?? "");
                    ajaxFormData.append(`${fileTypeId}[height]`, height ?? "");
                    ajaxFormData.append(`${fileTypeId}[left]`, left ?? "");
                    ajaxFormData.append(`${fileTypeId}[top]`, top ?? "");

                    ajaxFormData.append(`${fileTypeId}[image]`, fileInput?.files[0] ?? 0);
                }
            });

            let selectedProductId = $('#product_id').val();
            ajaxFormData.append('product_id', selectedProductId);

            ajaxFormData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: $("#product_type_images_form").attr('action'),
                type: 'POST',
                data: ajaxFormData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        position: "top-center",
                        icon: "success",
                        title: "Images has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Error submitting form');
                }
            });
        });

        $('#product_id').on('change', function () {
            const productId = $(this).val();

            $('#product_type_images  .clone_block').not(':first').remove();

            if (productId && productImagesByType[productId]) {
                const images = productImagesByType[productId];

                $.each(images, function (index, imageData) {
                    const $newBlock = $('#product_type_images .clone_block:first').clone();

                    $newBlock.find('.uploaded_file_type_id').val(imageData.uploaded_file_types_id);
                    $newBlock.find('input[name="width"]').val(imageData.width);
                    $newBlock.find('input[name="height"]').val(imageData.height);
                    $newBlock.find('input[name="top"]').val(imageData.top);
                    $newBlock.find('input[name="left"]').val(imageData.left);
                    $newBlock.find('.custom-file-label').text(imageData.image);

                    const $imagePreview = $newBlock.find('.imagePreview');
                    const imageSrc = "{{asset('storage/content/product_images_by_type/')}}/" + imageData.image;
                    $imagePreview.attr('src', imageSrc);
                    $newBlock.find('.imagePreview_block').show();

                    $('#product_type_images .input-container').append($newBlock);
                });
            }
        });

        const $colorInput = $('#color_hex');

        function updateBackgroundColor() {
            const colorValue = $colorInput.val();
            const colorShow = $('#color_show');

            if (/^#[0-9A-F]{6}$/i.test(colorValue)) {
                colorShow.css('background-color', colorValue);
                colorShow.show();
            } else {
                colorShow.css('background-color', '');
                colorShow.hide();
            }
        }

        updateBackgroundColor();

        $colorInput.on('input', updateBackgroundColor);

    });


</script>
@endpush
