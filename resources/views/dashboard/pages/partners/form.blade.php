@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
@endpush

@section('content')
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Add partners logo</h5>
                    <form enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Images ( 180 x 110 )</label>
                                <div class="input-group hdtuto control-group lst increment">
                                    <input type="file" name="ajax_images[]"
                                           class="form-control ajax_image_upload" multiple>
                                </div>

                                <div class="partners_logos">
                                    @foreach($imageFileNames as $i => $image)
                                        <div class="partners_logo">
                                            <img src="{{ asset('front/assets/images/partners-logo/'. $image) }}">
                                            <input type="hidden" name="images[{{ $i + 9999 }}]"
                                                   value="{{ $image }}">
                                            <button class="delete_image" type="button" data-image="{{$image}}">x</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $(document).on('change', '.ajax_image_upload', function () {
                let data = new FormData();
                $.each($(this).prop('files'), function (key, val) {
                    data.append('images[]', val);
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.partners.upload') }}",
                    data: data,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.success && data.images) {
                            jQuery.each(JSON.parse(data.images), (index, item) => {
                                let rnd = Math.floor(Math.random() * (9999999999 - 1111111111 + 1) + 1111111111),
                                    path = item.substr(item.indexOf("storage/content/") + 16)
                                $('.partners_logos').append('<div class="partners_logo"><img src="' + item + '" width="100"><input type="hidden" name="images[' + rnd + ']" value="' + path + '"> <button class="delete_image" type="button">x</button></div>')
                            });
                        }
                    }
                });
            })

            $(document).on("click", ".delete_image", function () {
                let image = $(this).data('image');

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
                            url: "{{ route('dashboard.partners.delete') }}",
                            data: {
                                image: image,
                                _token: "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function (data) {
                                if (data.success) {
                                    $(this).parents(".partners_logo").remove();
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
