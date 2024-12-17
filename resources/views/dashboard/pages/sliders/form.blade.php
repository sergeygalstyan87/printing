@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/select2.min.css') }}">
@endpush

@section('content')
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} slider</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.sliders.update', ['id' => $item->id]) : route('dashboard.sliders.store') }}"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="card-body">

                            <div class="device">
                                <ul class="nav nav-pills nav-pills-rose" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab"  href="#fields_web" role="tablist">
                                            Web
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab"  href="#fields_tablet" role="tablist">
                                            Tablet
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab"  href="#fields_mobile" role="tablist">
                                            Mobile
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content tab-space">
                                <div class="form-group tab-pane active show" id="fields_web">
                                    <label>Image ( 1903 x 336 )</label>
                                    <input type="file" name="image" class="myfrm form-control">
                                    @if( isset($item) )
                                        <img src="{{ asset('storage/content/' . $item->image) }}" width="100">
                                        <input type="hidden" name="image" value="{{ $item->image }}">
                                    @endif
                                    @error('image')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group tab-pane" id="fields_tablet">
                                    <label>Tablet Image ( 916 x 373 )</label>
                                    <input type="file" name="tablet_image" class="myfrm form-control">
                                    @if( isset($item) && $item->tablet_image)
                                        <img src="{{ asset('storage/content/' . $item->tablet_image) }}" width="100">
                                        <input type="hidden" name="tablet_image" value="{{ $item->tablet_image }}">
                                    @endif
                                    @error('tablet_image')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group tab-pane" id="fields_mobile">
                                    <label for="exampleInputEmail1">Mobile Image ( 686 x 700 )</label>
                                    <input type="file" name="mobile_image" class="myfrm form-control">
                                    @if( isset($item) && $item->mobile_image)
                                        <img src="{{ asset('storage/content/' . $item->mobile_image) }}" width="100">
                                        <input type="hidden" name="mobile_image" value="{{ $item->mobile_image }}">
                                    @endif
                                    @error('mobile_image')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
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
                                <label for="title_color">Title Color</label>
                                <input
                                    id="title_color"
                                    type="color"
                                    name="title_color"
                                    value="{{ (isset($item) && isset($item->title_color) ) ? $item->title_color : old('title_color') }}"
                                >
                                @error('title_color')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="big_title">Big Title</label>
                                <input
                                    id="big_title"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter title"
                                    name="big_title"
                                    value="{{ (isset($item) && isset($item->big_title) ) ? $item->big_title : old('big_title') }}"
                                >
                                @error('big_title')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="big_title_color">Big Title Color</label>
                                <input
                                    id="big_title_color"
                                    type="color"
                                    name="big_title_color"
                                    value="{{ (isset($item) && isset($item->big_title_color) ) ? $item->big_title_color : old('big_title_color') }}"
                                >
                                @error('big_title_color')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
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
                                <label for="description_color">Description text color</label>
                                <input
                                    id="description_color"
                                    type="color"
                                    name="description_color"
                                    value="{{ (isset($item) && isset($item->description_color) ) ? $item->description_color : old('description_color') }}"
                                >
                                @error('description_color')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="button_color">Button Color</label>
                                <input
                                    id="button_color"
                                    type="color"
                                    name="button_color"
                                    value="{{ (isset($item) && isset($item->button_color) ) ? $item->button_color : old('button_color') }}"
                                >
                                @error('button_color')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="button_text">Button text</label>
                                <input
                                    id="button_text"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter button text"
                                    name="button_text"
                                    value="{{ (isset($item) && isset($item->button_text) ) ? $item->button_text : old('button_text') }}"
                                >
                                @error('button_text')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="button_text_color">Button text color</label>
                                <input
                                    id="button_text_color"
                                    type="color"
                                    name="button_text_color"
                                    value="{{ (isset($item) && isset($item->button_text_color) ) ? $item->button_text_color : old('button_text_color') }}"
                                >
                                @error('button_text_color')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="button_url">Button link</label>
                                <input
                                    id="button_url"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter button url"
                                    name="button_url"
                                    value="{{ (isset($item) && isset($item->button_url) ) ? $item->button_url : old('button_url') }}"
                                >
                                @error('button_url')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="page_category_id">Category</label>
                                <select id="page_category_id" class="form-control" name="page_category_id">
                                    <option value="">Please select a category</option>
                                    @foreach($categories as $category)
                                        <option data-title="{{ $category->name }}"
                                                value="{{ $category->id }}" {{ (isset($item) && $item->page_category_id == $category->id) || old('page_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('page_category_id')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
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
    <script src="{{ asset('admin/assets/js/components/select2-init.js') }}"></script>
@endpush
