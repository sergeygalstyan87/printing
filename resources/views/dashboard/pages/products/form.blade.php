@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
{{--    <script src="https://cdn.ckeditor.com/4.25.0/standard-all/ckeditor.js"></script>--}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
@endpush
<?php
$rel_types = [];
foreach($types as $tt){
    if($tt->hasRelatedAttrs()){
        $rel_types[$tt->id] = $tt->hasRelatedAttrs();
    }
}

?>
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
                                @if(auth()->user()->role_id === \App\Enums\UserRoles::SUPER_ADMIN)
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-11-tab" data-toggle="pill" href="#inputs"
                                           role="tab" aria-controls="product_info" aria-selected="false">Inputs</a>
                                    </li>
                                @endif
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
                                                        <button class="delete_image" type="button" data-image="{{$image}}">x</button>
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

                                    <div class="form-group {{auth()->user()->role_id !== \App\Enums\UserRoles::SUPER_ADMIN ? 'hidden' : ''}}">
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

                                    <div class="subcategories {{auth()->user()->role_id !== \App\Enums\UserRoles::SUPER_ADMIN ? 'hidden' : ''}}">
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

                                    <div class="accordion" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="headingDescAccordion">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" aria-expanded="true" data-target="#desc_accordion" aria-controls="desc_accordion">
                                                        Description
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="desc_accordion" class="collapse show" aria-labelledby="headingDescAccordion" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="form-group {{auth()->user()->role_id !== \App\Enums\UserRoles::SUPER_ADMIN ? 'hidden' : ''}}">
{{--                                                        <label for="content">Description</label>--}}
                                                        <textarea class="form-control" id="content" placeholder="Enter the Description"
                                                                  name="description">{{ (isset($item) && isset($item->description) ) ? $item->description : old('description') }}</textarea>
                                                        @error('description')
                                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header" id="headingShortDescAccordion">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" aria-expanded="true" data-target="#short_desc_accordion" aria-controls="short_desc_accordion">
                                                        Short Description for upload
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="short_desc_accordion" class="collapse" aria-labelledby="headingShortDescAccordion" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="form-group {{auth()->user()->role_id !== \App\Enums\UserRoles::SUPER_ADMIN ? 'hidden' : ''}}">
{{--                                                        <label for="content">Short Description for upload</label>--}}
                                                        <textarea class="form-control" id="content_short" placeholder="Enter the short description"
                                                                  name="short_desc">{{ (isset($item) && isset($item->short_desc) ) ? $item->short_desc : old('short_desc') }}</textarea>
                                                        @error('short_desc')
                                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header" id="headingProdTurnText">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" aria-expanded="true" data-target="#prod_turn_text_accordion" aria-controls="prod_turn_text_accordion">
                                                        Production Turnaround text
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="prod_turn_text_accordion" class="collapse" aria-labelledby="headingProdTurnText" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="form-group {{auth()->user()->role_id !== \App\Enums\UserRoles::SUPER_ADMIN ? 'hidden' : ''}}">
{{--                                                        <label for="content">Production Turnaround text</label>--}}
                                                        <textarea class="form-control" id="production_turnaround" placeholder="Enter the production turnaround text"
                                                                  name="production_turnaround">{{ (isset($item) && isset($item->production_turnaround) ) ? $item->production_turnaround : old('production_turnaround') }}</textarea>
                                                        @error('production_turnaround')
                                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if(auth()->user()->role_id === \App\Enums\UserRoles::SUPER_ADMIN)

                                        <div class="form-group">
                                            <label for="stock">Stock</label>
                                            <select id="stock" class="form-control stock" name="stock">
                                                <option value="1" {{ (isset($item) && $item->stock == 1) ? 'selected' : '' }}>In Stock</option>
                                                <option value="0" {{ (isset($item) && $item->stock == 0) ? 'selected' : '' }}>Out of stock</option>
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
                                            <label for="order">Ordering</label>
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
                                            <label for="shipping_percent">Finishing Price Per Product</label>
                                            <input
                                                    id="finishing_price"
                                                    type="number"
                                                    step="0.0001"
                                                    class="form-control"
                                                    placeholder="Enter Finishing Price"
                                                    name="finishing_price"
                                                    value="{{ (isset($item) && isset($item->finishing_price) ) ? $item->finishing_price : 0 }}"
                                            >
                                            @error('finishing_price')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="min_price">Min Price for order</label>
                                            <input
                                                    id="min_price"
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control"
                                                    placeholder="Enter Minimum  Price for order"
                                                    name="min_price"
                                                    value="{{ (isset($item) && isset($item->min_price) ) ? $item->min_price : 0 }}"
                                            >
                                            @error('min_price')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="min_price">Design Price</label>
                                            <input
                                                    id="design_price"
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control"
                                                    placeholder="Enter Design Price"
                                                    name="design_price"
                                                    value="{{ (isset($item) && isset($item->design_price) ) ? $item->design_price : 0 }}"
                                            >
                                            @error('design_price')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="bleed">Bleed</label>
                                            <input
                                                    id="bleed"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Enter Bleed"
                                                    name="bleed"
                                                    value="{{ (isset($item) && isset($item->bleed) ) ? $item->bleed : 0 }}"
                                            >
                                            @error('bleed')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="bleed">Started QTY for offset calc.</label>
                                            <input
                                                    id="offset_qty"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Enter quantity.."
                                                    name="offset_qty"
                                                    value="{{ (isset($item) && isset($item->offset_qty) ) ? $item->offset_qty : null }}"
                                            >
                                            @error('offset_qty')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif
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
            echo "let related_types = ". json_encode($rel_types) . ";\n";
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
                                $('.product_images').append('<div class="product_image"><img src="' + item + '" width="100"><input type="hidden" name="images[' + rnd + ']" value="' + path + '"> <button class="delete_image" type="button" data-image="'+path +'">x</button></div>')
                            });
                        }
                    }
                });
            })

            $(document).on("click", ".delete_image", function () {
                let image = $(this).data('image');
                console.log(image);
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('dashboard.products.delete_image') }}",
                            data: {
                                image: image,
                                _token: "{{csrf_token()}}",
                            },
                            dataType: 'json',
                            success: function (data) {
                                if (data.success) {
                                    $(this).parents(".product_image").remove();
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Your file has been deleted.",
                                        icon: "success"
                                    });
                                }
                            }.bind(this),
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });

                    }
                });
            });

        });
    </script>
@endpush
