@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/select2.min.css') }}">
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <style>
        .banner_img_block {
            position: relative;
            margin: 20px 0;
            width: 120px;
        }
        .delete_image{
            position:absolute;
            top:-10px;
            right:-10px;
            width:20px;
            height:20px;
            background-color:red;
            border-radius:50%;
            border:none;
            cursor:pointer
        }
        .delete_image:focus{
            outline:none
        }
        .delete_image span{
            display:block;
            width:10px;
            height:2px;
            background-color:#fff
        }
        .delete_image span:first-child{
            -webkit-transform:translate(-1px,1px) rotate(45deg);
            -ms-transform:translate(-1px,1px) rotate(45deg);
            transform:translate(-1px,1px) rotate(45deg)
        }
        .delete_image span:last-child{
            -webkit-transform:translate(-1px,-1px) rotate(-45deg);
            -ms-transform:translate(-1px,-1px) rotate(-45deg);
            transform:translate(-1px,-1px) rotate(-45deg)
        }
    </style>
@endpush

@section('content')
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} banner</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.banners.update', ['id' => $item->id]) : route('dashboard.banners.store') }}"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="card-body">

                            <div class="device">
                                <ul class="nav nav-pills nav-pills-rose" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#fields_web" role="tablist">
                                            Web
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#fields_tablet" role="tablist">
                                            Tablet
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#fields_mobile" role="tablist">
                                            Mobile
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content tab-space">
                                <div class="form-group tab-pane active show" id="fields_web">
                                    <label>Image ( 1903 x 336 )</label>
                                    <input type="file" name="image" class="myfrm form-control">
                                    @php
                                        $fileExtension = pathinfo($item->image, PATHINFO_EXTENSION);
                                    @endphp
                                    @if( isset($item) && $item->image)
                                        <div class="banner_img_block">
                                            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                <img src="{{ asset('storage/content/' . $item->image) }}" width="100%">
                                            @elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                                <iframe src="{{ asset('storage/content/' . $item->image) }}" autoplay='false' width="100%" frameborder="0" scrolling="no" ></iframe>
                                            @endif

                                            <input type="hidden" name="image" value="{{ $item->image }}">
                                        </div>
                                    @endif
                                    @error('image')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group tab-pane" id="fields_tablet">
                                    <label>Tablet Image ( 1024 x 336 )</label>
                                    <input type="file" name="tablet_image" class="myfrm form-control">
                                    @if( isset($item) && $item->tablet_image)
                                        <div class="banner_img_block">
                                            <img src="{{ asset('storage/content/' . $item->tablet_image) }}" width="100%">
                                            <button class="delete_image" type="button" data-image="{{$item->tablet_image}}">
                                                <span></span>
                                                <span></span>
                                            </button>
                                            <input type="hidden" name="tablet_image" value="{{ $item->tablet_image }}">
                                        </div>
                                    @endif
                                    @error('tablet_image')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group tab-pane" id="fields_mobile">
                                    <label for="exampleInputEmail1">Mobile Image ( 430 x 326 )</label>
                                    <input type="file" name="mobile_image" class="myfrm form-control">
                                    @if( isset($item) && $item->mobile_image)
                                        <div class="banner_img_block">
                                            <img src="{{ asset('storage/content/' . $item->mobile_image) }}" width="100%">
                                            <button class="delete_image" type="button" data-image="{{$item->mobile_image}}">
                                                <span></span>
                                                <span></span>
                                            </button>
                                            <input type="hidden" name="mobile_image" value="{{ $item->mobile_image }}">
                                        </div>
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
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" placeholder="Enter the Description"
                                          name="description">{{ (isset($item) && isset($item->description) ) ? $item->description : old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description_color">Description Color</label>
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
                                <label for="button_text_color">Button text Color</label>
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

        $(document).ready(function () {

            $(document).on("click", ".delete_image", function () {
                let image = $(this).data('image');
                let imageInput = $(this).siblings('input[type="hidden"]');
                let imagePreview = $(this).siblings('img');

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
                            url: "{{ route('dashboard.banners.image_delete') }}",
                            data: {
                                image: image,
                                _token: "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function (data) {
                                if (data.success) {
                                    imageInput.val('');
                                    imagePreview.remove();
                                    $(this).remove();
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
