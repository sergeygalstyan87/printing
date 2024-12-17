@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://cdn.ckeditor.com/4.11.4/standard-all/ckeditor.js"></script>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
@endpush

@section('content')
    @if(auth()->user()->role_id === \App\Enums\UserRoles::SUPER_ADMIN)
        <section class="page-content container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Add Templates</h5>
                        <form
                                method="post"
                                action="{{route('dashboard.products.templates_store')}}"
                                enctype="multipart/form-data"
                        >
                            @csrf
                            <div class="card-body">
                                <div class="" id="product_deliveries">
                                    <label for="product_id">Product</label>
                                    <select id="product_id" name="product_id">
                                        <option value="" disabled selected>Please select a product</option>
                                        @foreach($products as $product)
                                            <option data-title="{{ $product->title }}"
                                                    value="{{ $product->id }}" {{old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                    <div id="delivery_groups" class="mt-5"></div>
                                    <div class="d-flex align-items-center justify-content-start gap-5 mt-5">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="{{ asset('admin/assets/js/product.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#product_id').select2();

            $('#product_id').on('change', function () {
                const productId = $(this).val();
                if (productId) {
                    $.ajax({
                        url: "{{route('dashboard.products.get_templates')}}",
                        data: {
                            product_id: productId,
                        },
                        success: function (response) {
                            $('#delivery_groups').html(response.html);
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#result').html('');
                }
            });
        });
    </script>
@endpush