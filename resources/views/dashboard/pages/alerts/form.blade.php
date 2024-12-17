@extends('layouts.admin')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/select2.min.css') }}">
        <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>

    @endpush
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} alert</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.alerts.update', ['id' => $item->id]) : route('dashboard.alerts.store') }}"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="title">Title</label>

                                <textarea
                                    id="title"
                                    class="form-control"
                                    placeholder="Enter title"
                                    name="title"
                                    value=""
                                >
{{ (isset($item) && isset($item->title) ) ? $item->title : old('title') }}
                                </textarea>
                                @error('title')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="title">Secondary Text</label>
                                <textarea
                                        id="secondary_text"
                                        class="form-control"
                                        placeholder="Enter secondary text"
                                        name="secondary_text"
                                        value=""
                                >
{{ (isset($item) && isset($item->secondary_text) ) ? $item->secondary_text : old('secondary_text') }}
                                </textarea>

                                @error('secondary_text')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="title">Link for secondary text</label>
                                <input
                                    id="secondary_text_link"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter link"
                                    name="secondary_text_link"
                                    value="{{ (isset($item) && isset($item->secondary_text_link) ) ? $item->secondary_text_link : old('secondary_text_link') }}"
                                >
                                @error('secondary_text_link')
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
                                <label for="background_color">Background Color Start</label>
                                <input
                                    id="background_color"
                                    type="color"
                                    name="background_color"
                                    value="{{ (isset($item) && isset($item->background_color) ) ? $item->background_color : old('background_color') }}"
                                >
                                @error('background_color')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="background_color_end">Background Color End</label>
                                <input
                                    id="background_color_end"
                                    type="color"
                                    name="background_color_end"
                                    value="{{ (isset($item) && isset($item->background_color_end) ) ? $item->background_color_end : old('background_color_end') }}"
                                >
                                @error('background_color_end')
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
            .create(document.querySelector('#title'),{
                toolbar: {
                    items: ['bold', 'italic'],
                    shouldNotGroupWhenFull: true
                },
                    language: 'en',


            },
            )
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#secondary_text'),{
                    toolbar: {
                        items: ['bold', 'italic', 'fontSize'],
                        shouldNotGroupWhenFull: true
                    },
                    language: 'en',


                },
            )
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush