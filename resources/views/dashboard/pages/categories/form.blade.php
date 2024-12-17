@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/select2.min.css') }}">
@endpush

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} category</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.categories.update', ['id' => $item->id]) : route('dashboard.categories.store') }}"
                    >
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Parent</label>
                                <select class="form-control" name="parent">
                                    <option value="0">Select parent category</option>
                                    @foreach($categories as $category)
                                        <option
                                            value="{{ $category->id }}" {{ (isset($item) && $item->parent == $category->id) || old('attribute_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('parent')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
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

                            <div class="form-group">
                                <label for="exampleInputEmail1">Order</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Order"
                                    name="order"
                                    value="{{ (isset($item) && isset($item->order) ) ? $item->order : 0 }}"
                                >
                                @error('order')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Design Price</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Price"
                                    name="design_price"
                                    value="{{ (isset($item) && isset($item->design_price) ) ? $item->design_price : 0 }}"
                                >
                                @error('design_price')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            @if(isset($item) && $item->parent == 0)
                                <div class="form-group">
                                    <label for="products">Menu Products</label>
                                    <select id="products" multiple="multiple" class="form-control" name="products[]">
                                        <option value="">Please select a menu products</option>
                                        @foreach($products as $product)
                                            <option
                                                value="{{ $product->id }}" {{ $item->menu_products->contains($product->id) ? 'selected' : '' }}>{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
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
    <script src="{{ asset('admin/assets/js/components/select2-init.js') }}"></script>
    <script>
        $('#products').select2({
            placeholder: 'Please select a menu products',
            maximumSelectionLength: 3
        });
    </script>
@endpush
