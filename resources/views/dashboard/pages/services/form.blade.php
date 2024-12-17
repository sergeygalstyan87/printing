@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/select2.min.css') }}">
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
@endpush

@section('content')
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} service</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.services.update', ['id' => $item->id]) : route('dashboard.services.store') }}"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Image ( 50 x 50 )</label>
                                <input type="file" name="image" class="myfrm form-control">
                                @if( isset($item) )
                                    <img src="{{ asset('storage/content/' . $item->image) }}" width="100">
                                    <input type="hidden" name="image" value="{{ $item->image }}">
                                @endif
                                @error('image')
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
                                <label for="description">Description</label>
                                <input
                                    id="description"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter description"
                                    name="description"
                                    value="{{ (isset($item) && isset($item->description) ) ? $item->description : old('description') }}"
                                >
                                @error('description')
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
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
