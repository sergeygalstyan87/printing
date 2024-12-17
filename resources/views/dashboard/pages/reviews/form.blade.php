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
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} review</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.reviews.update', ['id' => $item->id]) : route('dashboard.reviews.store') }}"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Image ( 94 x 94 )</label>
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
                                <label for="name">Name</label>
                                <input
                                    id="name"
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
                                <label for="position">Position</label>
                                <input
                                    id="position"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter position"
                                    name="position"
                                    value="{{ (isset($item) && isset($item->position) ) ? $item->position : old('position') }}"
                                >
                                @error('position')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="review">Review</label>
                                <textarea class="form-control" id="review" placeholder="Enter the Description"
                                          name="review">{{ (isset($item) && isset($item->review) ) ? $item->review : old('review') }}</textarea>
                                @error('review')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="stars">Stars</label>
                                <select name="stars" id="stars" class="form-control">
                                    <option value="1" {{ isset($item) && $item->stars == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ isset($item) && $item->stars == '2' ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ isset($item) && $item->stars == '3' ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ isset($item) && $item->stars == '4' ? 'selected' : '' }}>4</option>
                                    <option value="5" {{ isset($item) && $item->stars == '5' ? 'selected' : '' }} {{ !isset($item) ? 'selected' : '' }}>5</option>
                                </select>
                                @error('stars')
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
