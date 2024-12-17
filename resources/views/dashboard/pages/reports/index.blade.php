@extends('layouts.admin')

@push('styles')
    <style>
        .blockquote-footer, .text-muted{
            color: #000000 !important;
        }
    </style>
@endpush

@section('content')

    <section class="page-content container-fluid order_list">
        <div class="row">
            <div class="col-6 col-lg-3">
                <div class="card p-3">
                    <div class="d-flex">
                        <a  href="{{ route('dashboard.orders.index', ['filters[orders-active-filter]' => 'new']) }}" class="text-muted">
                            New Orders
                        </a>
                    </div>
                    <div class="py-3 text-center text-lg text-success">{{$orders['new']}}</div>
                    <div class="d-flex">
                        <span class="flex text-muted">Total({{$orders['total']}})</span>
                        <span><i class="fa fa-caret-up text-success"></i> {{round($orders['new']*100/$orders['total'])}}%</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card p-3">
                    <div class="d-flex">
                        <a  href="{{ route('dashboard.orders.index', ['filters[orders-active-filter]' => 'custom_request']) }}" class="text-muted">
                            Order Requests
                        </a>
                    </div>
                    <div class="py-3 text-center text-lg text-danger">{{$orders['requests']}}</div>
                    <div class="d-flex">
                        <span class="flex text-muted">Total({{$orders['total']}})</span>
                        <span><i class="fa fa-caret-down text-danger"></i> {{round($orders['requests']*100/$orders['total'])}}%</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card p-3">
                    <div class="d-flex">
                        <a  href="{{ route('dashboard.orders.index', ['filters[orders-active-filter]' => 'ready_to_start']) }}" class="text-muted">
                            Ready To Start
                        </a>
                    </div>
                    <div class="py-3 text-center text-lg text-primary">{{$orders['ready_to_start']}}</div>
                    <div class="d-flex">
                        <span class="flex text-muted">Total({{$orders['total']}})</span>
                        <span><i class="fa fa-caret-up text-primary"></i>  {{round($orders['ready_to_start']*100/$orders['total'])}}%</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card p-3">
                    <div class="d-flex">
                        <a  href="{{ route('dashboard.orders.index', ['filters[orders-active-filter]' => 'in_progress']) }}" class="text-muted">
                            In Progress
                        </a>
                    </div>
                    <div class="py-3 text-center text-lg">{{$orders['in_progress']}}</div>
                    <div class="d-flex">
                        <span class="flex text-muted">Total({{$orders['total']}})</span>
                        <span>
                            <i class="fa fa-caret-down text-danger"></i>  {{round($orders['in_progress']*100/$orders['total'])}}%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="form-group col-md-2 col-6">
                <label for="start-date">Start Date</label>
                <input class="form-control" type="datetime-local" id="start-date">
            </div>
            <span class="align-self-end pb-4">
                &#8212;
            </span>
            <div class="form-group col-md-2 col-6">
                <label for="end-date">End Date</label>
                <input class="form-control" type="datetime-local" id="end-date">
            </div>

            <button class="btn btn-primary col-md-1 col-6 align-self-end mb-3 mr-3" id="applyDates">
                Apply
            </button>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        Monthly Graph
                        <div class="form-group d-flex align-items-center mb-0">
                            <label for="year" class="text-nowrap mr-3 mb-0">Selected Year:</label>
                            <select class="form-control" name="year" id="year">
                                @for($year = 2024; $year <= now()->year; $year++)
                                    <option value="{{$year}}"
                                            @if($year === now()->year) selected @endif>{{$year}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="height: calc(100% - 30px)" class="card">
                    <div class="card-header">
                        Top sold categories
                    </div>
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div id="categoriesChartContainer" style="height: 362px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        Monthly Graph
                        <div class="form-group d-flex align-items-center mb-0">
                            <label for="year_tax" class="text-nowrap mr-3 mb-0">Selected Year:</label>
                            <select class="form-control" name="year_tax" id="year_tax">
                                @for($year = 2024; $year <= now()->year; $year++)
                                    <option value="{{$year}}"
                                            @if($year === now()->year) selected @endif>{{$year}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chartContainerTax" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="{{ asset('admin/assets/js/cards/top-sold-products.js') }}"></script>
    <script src="{{ asset('admin/assets/js/cards/top-sold-categories.js') }}"></script>
    <script src="{{ asset('admin/assets/js/cards/new-orders.js') }}"></script>
@endpush
