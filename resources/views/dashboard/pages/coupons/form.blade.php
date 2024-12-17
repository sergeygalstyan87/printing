@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush


@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} coupon</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.coupons.update', ['id' => $item->id]) : route('dashboard.coupons.store') }}"
                    >
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
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
                                <label>Percent</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Enter Percent"
                                    name="percent"
                                    value="{{ (isset($item) && isset($item->percent) ) ? $item->percent : old('percent') }}"
                                >
                                @error('percent')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Fixed Price</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Enter Fixed Price"
                                    name="fixed_price"
                                    value="{{ (isset($item) && isset($item->fixed_price) ) ? $item->fixed_price : old('fixed_price') }}"
                                >
                                @error('fixed_price')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Limit</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Enter Limit"
                                    name="limit"
                                    value="{{ (isset($item) && isset($item->limit) ) ? $item->limit : 0 }}"
                                    min="0"
                                    required
                                >
                                @error('limit')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Coupon duration</label>
                                <input class="form-control" type="text" name="datefilter"
                                       value="{{ isset($item) ? \Carbon\Carbon::parse($item->start_date)->format('m/d/Y') .
                                        ' - ' . \Carbon\Carbon::parse($item->end_date)->format('m/d/Y') : '' }}"
                                />
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(function() {
            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'MM/DD/YYYY'
                }
            });

            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

        });
    </script>
@endpush


