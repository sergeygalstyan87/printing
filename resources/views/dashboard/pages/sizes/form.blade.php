@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} attribute</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.sizes.update', ['id' => $item->id]) : route('dashboard.sizes.store') }}"
                    >
                        @csrf
                        <div class="card-body">
                            @if(isset($item))
                                @php($ft = explode(' x ', $item->ft))
                            @endif
                            <h3>FT</h3>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Width</label>
                                <input
                                    type="number"
                                    class="form-control ft_width"
                                    placeholder="Enter FT Width"
                                    name="ft_width"
                                    step="0.0001"
                                    value="{{ isset($item) ? $ft[0] : old('ft_width') }}"
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Height</label>
                                <input
                                    type="number"
                                    class="form-control ft_height"
                                    placeholder="Enter FT Height"
                                    name="ft_height"
                                    step="0.0001"
                                    value="{{ isset($item) ? $ft[1] : old('ft_height') }}"
                                    required
                                >
                            </div>

                            @if(isset($item))
                                @php($in = explode(' x ', $item->in))
                            @endif
                            <h3>IN</h3>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Width</label>
                                <input
                                    type="number"
                                    class="form-control in_width"
                                    placeholder="Enter IN Width"
                                    name="in_width"
                                    step="0.0001"
                                    value="{{ isset($item) ? $in[0] : old('in_width') }}"
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Height</label>
                                <input
                                    type="number"
                                    class="form-control in_height"
                                    placeholder="Enter IN Height"
                                    name="in_height"
                                    step="0.0001"
                                    value="{{ isset($item) ? $in[1] : old('in_height') }}"
                                    required
                                >
                            </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="core_size" {{ (isset($item ) && $item->core_size == 1) ? 'checked' : '' }} value="1" id="core_size">
                                    <label class="form-check-label" for="core_size">Size for Printing List</label>
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
    <script>
        $(document).ready(function () {

            $(document).on('input', '.ft_width', function () {

                let width = Number($('.ft_width').val()) * 12

                if (!Number.isInteger(width)) {
                    width = width.toFixed(2)
                }

                $('.in_width').val(width)
            })

            $(document).on('input', '.ft_height', function () {

                let height = Number($('.ft_height').val()) * 12

                if (!Number.isInteger(height)) {
                    height = height.toFixed(2)
                }

                $('.in_height').val(height)
            })

            $(document).on('input', '.in_width', function () {
                let width = Number($('.in_width').val()) / 12

                if (!Number.isInteger(width)) {
                    width = width.toFixed(2)
                }

                $('.ft_width').val(width)
            })

            $(document).on('input', '.in_height', function () {
                let height = Number($('.in_height').val()) / 12

                if (!Number.isInteger(height)) {
                    height = height.toFixed(2)
                }

                $('.ft_height').val(height)
            })

        });
    </script>
@endpush
