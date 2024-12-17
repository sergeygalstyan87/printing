@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid order_list">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <h5 class="card-header">Design and Prepress</h5>
                    <div class="card-body" style="max-height: 636px;height: 636px;overflow-y: auto">
                        <div class="droppableArea" id="prepress">
                            @foreach($itemsPrepress as $item)
                                <div class="card draggable" draggable="true" id="draggable_{{$item->id}}">
                                    <div class="card-header inner_header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="{{ route('dashboard.orders.edit', $item->id) }}"
                                               style="display: inline-flex;align-items: center;font-weight: bold">
                                                {{$item->product->title }}
                                            </a>
                                            <span>${{$item->amount}}</span>
                                        </div>
                                        @php
                                            $class = 'success';
                                                $createdDate = \Carbon\Carbon::createFromDate($item->created_at);
                                            if ($item->delivery) {
                                                $estimatedDateOfDelivery = $createdDate->copy()->addDays($item->delivery->days);

                                                $diff = $item->delivery->days - $estimatedDateOfDelivery->diffInDays();

                                                if ($diff < 0) {
                                                    $class = 'danger';
                                                } else if ($diff <= 2) {
                                                    $class = 'warning';
                                                }
                                            }
                                        @endphp
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0">
                                                @if($item->user_id)
                                                    {{$item->user->name}}
                                                @else
                                                    {{$item->name}}
                                                @endif
                                            </p>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0">
                                                Ordered at:
                                            </p>
                                            <p class="mb-0">
                                                {{ $createdDate->isoFormat('YYYY/MM/DD') }}
                                                ({{$createdDate->diffInDays()}} day(-s) ago)
                                            </p>
                                        </div>
                                        @if (isset($estimatedDateOfDelivery) && isset($item->delivery))
                                            <div class="d-flex align-items-center justify-content-between text-{{$class}}">
                                                <p class="mb-0 text-{{$class}}">
                                                    Estimated delivery at:
                                                </p>
                                                <p class="mb-0 text-{{$class}}">
                                                    {{ $estimatedDateOfDelivery->isoFormat('YYYY/MM/DD') }}
                                                    ({{$estimatedDateOfDelivery->diffInDays()}} day(-s) ago)
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    <div id="collapse_{{$item->id}}" class="show">
                                        <div class="card-body inner_body">
                                            <div class="order_info_item d-flex align-items-center justify-content-between">
                                                <a href="{{ route('dashboard.orders.invoice', ['id' => isset($item) ? $item->id :'']) }}"
                                                   target="_blank"
                                                   class="">
                                                    @if( !empty($item->invoice_number))
                                                        {{$item->invoice_number}}
                                                    @else
                                                        Generate Invoice
                                                    @endif
                                                </a>
                                                @if($item->delivery_status == 5)
                                                    <button
                                                            class="btn btn-secondary"
                                                            style="pointer-events: none"
                                                    >
                                                        In Design
                                                    </button>
                                                @else
                                                    <form
                                                            method="post"
                                                            action="{{route('dashboard.orders.update', ['id' => $item->id])}}"
                                                            enctype="multipart/form-data"
                                                            data-item-id="{{$item->id}}"
                                                    >
                                                        <button
                                                                class="btn btn-primary updateStatusBtn"
                                                                data-current-status="{{$item->delivery_status}}"
                                                                data-delivery_type="{{$item->delivery_type}}"
                                                        >
                                                            Move To Production
                                                        </button>
                                                        @error('delivery_status')
                                                        <div class="invalid-feedback"
                                                             style="display: block">{{ $message }}</div>
                                                        @enderror
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <h5 class="card-header">Production</h5>
                    <div class="card-body" style="max-height: 636px;height: 636px;overflow-y: auto">
                        <div class="droppableArea" id="production">
                            @foreach($itemsProduction as $item)
                                <div class="card draggable" draggable="true" id="draggable_{{$item->id}}">
                                    <div class="card-header inner_header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="{{ route('dashboard.orders.edit', $item->id) }}"
                                               style="display: inline-flex;align-items: center;font-weight: bold">
                                                {{$item->product->title }}
                                            </a>
                                            <span>${{$item->amount}}</span>
                                        </div>
                                        @php
                                            $class = 'success';
                                                $createdDate = \Carbon\Carbon::createFromDate($item->created_at);
                                            if ($item->delivery) {
                                                $estimatedDateOfDelivery = $createdDate->copy()->addDays($item->delivery->days);

                                                $diff = $item->delivery->days - $estimatedDateOfDelivery->diffInDays();

                                                if ($diff < 0) {
                                                    $class = 'danger';
                                                } else if ($diff <= 2) {
                                                    $class = 'warning';
                                                }
                                            }
                                        @endphp
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0">
                                                @if($item->user_id)
                                                    {{$item->user->name}}
                                                @else
                                                    {{$item->name}}
                                                @endif
                                            </p>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0">
                                                Ordered at:
                                            </p>
                                            <p class="mb-0">
                                                {{ $createdDate->isoFormat('YYYY/MM/DD') }}
                                                ({{$createdDate->diffInDays()}} day(-s) ago)
                                            </p>
                                        </div>
                                        @if (isset($estimatedDateOfDelivery) && isset($item->delivery))
                                            <div class="d-flex align-items-center justify-content-between text-{{$class}}">
                                                <p class="mb-0 text-{{$class}}">
                                                    Estimated delivery at:
                                                </p>
                                                <p class="mb-0 text-{{$class}}">
                                                    {{ $estimatedDateOfDelivery->isoFormat('YYYY/MM/DD') }}
                                                    ({{$estimatedDateOfDelivery->diffInDays()}} day(-s) ago)
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    <div id="collapse_{{$item->id}}" class="show">
                                        <div class="card-body inner_body">
                                            <div class="order_info_item d-flex align-items-center justify-content-between">
                                                <a href="{{ route('dashboard.orders.invoice', ['id' => isset($item) ? $item->id :'']) }}"
                                                   target="_blank"
                                                   class="">
                                                    @if( !empty($item->invoice_number))
                                                        {{$item->invoice_number}}
                                                    @else
                                                        Generate Invoice
                                                    @endif
                                                </a>
                                                <form
                                                        method="post"
                                                        action="{{route('dashboard.orders.update', ['id' => $item->id])}}"
                                                        enctype="multipart/form-data"
                                                        data-item-id="{{$item->id}}"
                                                >
                                                    <button
                                                            class="btn btn-primary updateStatusBtn"
                                                            data-current-status="{{$item->delivery_status}}"
                                                            data-delivery_type="{{$item->delivery_type}}"
                                                    >
                                                        Move To Ready
                                                    </button>
                                                    @error('delivery_status')
                                                    <div class="invalid-feedback"
                                                         style="display: block">{{ $message }}</div>
                                                    @enderror
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <h5 class="card-header">Ready</h5>
                    <div class="card-body" style="max-height: 636px;height: 636px;overflow-y: auto">
                        <div class="droppableArea" id="ready">
                            @foreach($itemsReady as $item)
                                <div class="card draggable" draggable="true" id="draggable_{{$item->id}}">
                                    <div class="card-header inner_header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="{{ route('dashboard.orders.edit', $item->id) }}"
                                               style="display: inline-flex;align-items: center;font-weight: bold">
                                                {{$item->product->title }}
                                            </a>
                                            <span>${{$item->amount}}</span>
                                        </div>
                                        @php
                                            $class = 'success';
                                                $createdDate = \Carbon\Carbon::createFromDate($item->created_at);
                                            if ($item->delivery) {
                                                $estimatedDateOfDelivery = $createdDate->copy()->addDays($item->delivery->days);

                                                $diff = $item->delivery->days - $estimatedDateOfDelivery->diffInDays();

                                                if ($diff < 0) {
                                                    $class = 'danger';
                                                } else if ($diff <= 2) {
                                                    $class = 'warning';
                                                }
                                            }
                                        @endphp
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0">
                                                @if($item->user_id)
                                                    {{$item->user->name}}
                                                @else
                                                    {{$item->name}}
                                                @endif
                                            </p>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0">
                                                Ordered at:
                                            </p>
                                            <p class="mb-0">
                                                {{ $createdDate->isoFormat('YYYY/MM/DD') }}
                                                ({{$createdDate->diffInDays()}} day(-s) ago)
                                            </p>
                                        </div>
                                        @if (isset($estimatedDateOfDelivery) && isset($item->delivery))
                                            <div class="d-flex align-items-center justify-content-between text-{{$class}}">
                                                <p class="mb-0 text-{{$class}}">
                                                    Estimated delivery at:
                                                </p>
                                                <p class="mb-0 text-{{$class}}">
                                                    {{ $estimatedDateOfDelivery->isoFormat('YYYY/MM/DD') }}
                                                    ({{$estimatedDateOfDelivery->diffInDays()}} day(-s) ago)
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                    <div id="collapse_{{$item->id}}" class="show">
                                        <div class="card-body inner_body">
                                            <div class="order_info_item d-flex align-items-center justify-content-between">
                                                <a href="{{ route('dashboard.orders.invoice', ['id' => isset($item) ? $item->id :'']) }}"
                                                   target="_blank"
                                                   class="">
                                                    @if( !empty($item->invoice_number))
                                                        {{$item->invoice_number}}
                                                    @else
                                                        Generate Invoice
                                                    @endif
                                                </a>
                                                <form
                                                        method="post"
                                                        action="{{route('dashboard.orders.update', ['id' => $item->id])}}"
                                                        enctype="multipart/form-data"
                                                        data-item-id="{{$item->id}}"
                                                >
                                                    <button
                                                            class="btn btn-primary updateStatusBtn"
                                                            data-current-status="{{$item->delivery_status}}"
                                                            data-delivery_type="{{$item->delivery_type}}"
                                                    >
                                                        Move To @if ($item->delivery_type == 'shipping') Shipping @else Completed @endif
                                                    </button>
                                                    @error('delivery_status')
                                                    <div class="invalid-feedback"
                                                         style="display: block">{{ $message }}</div>
                                                    @enderror
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header" style="display: flex;justify-content: space-between">
                        <span>Orders</span>
                        <form action="{{ route('dashboard.orders.delete_images') }}" method="post">
                            @csrf
                            <button style="background: red;border: none;border-radius: 4px;color: #fff;padding: 5px 10px;font-size: 14px;"
                                    class="delete_order_images">Delete images
                            </button>
                        </form>
                    </h5>
                    <div class="card-body">
                        <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Payment System</th>
                                <th>Status</th>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( !empty($items) )
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->product->title }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>${{ $item->amount }}</td>
                                        <td>{{ $item->payment_type }}</td>

                                        <td style="text-transform: capitalize">{{ $item->status }}</td>
                                        <td>{{ $item->invoice_number }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('YYYY/MM/DD'); }}</td>
                                        <td>
                                            <a href="{{ route('dashboard.orders.edit', $item->id) }}"
                                               class="btn btn-sm btn-light btn-active-light-danger"
                                               style="display: inline-flex;align-items: center;">Details</a>
                                            <form action="{{ route('dashboard.orders.delete', $item->id) }}"
                                                  method="post" style="display:inline-block;">
                                                @csrf
                                                <button type="button"
                                                        class="btn btn-sm btn-danger btn-active-light-danger delete-order">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('admin/assets/js/components/datatables-init.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.updateStatusBtn', function (e) {
                e.preventDefault();
                const button = $(this);
                const form = button.closest('form');
                const id = form.data('item-id');
                const currentStatus = button.data('current-status');
                const deliveryType = button.data('delivery_type');
                let newStatus;
                let newStatusText;
                switch (currentStatus) {
                    case 0:
                        newStatus = 1;
                        newStatusText = 'Move To Ready'
                        break;
                    case 1:
                        newStatus = 2;
                        newStatusText = 'Move To Completed'
                        break;
                    case 2:
                        if(deliveryType === 'pickup'){
                            newStatus = 3;
                        }else if(deliveryType === 'shipping'){
                            newStatus = 4;
                        }
                        break;
                }

                $.ajax({
                    url: `/dashboard/orders/update/${id}`,
                    method: 'POST',
                    data: {
                        delivery_status: newStatus,
                    },
                    success: function (response) {
                        if(newStatus == 3 || newStatus == 4){
                            window.location.reload();
                        }else{
                            const card = button.closest('.card');
                            const btnTextArray = button.text().toLowerCase().trim().split(' ');
                            const btnText = btnTextArray[btnTextArray.length - 1];
                            console.log(btnText)
                            // Update button text
                            button.text(newStatusText);
                            button.attr('data-current-status', newStatus)

                            card.remove();

                            $(`#${btnText}`).append(card);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            const draggables = document.querySelectorAll('.draggable');
            const droppableAreas = document.querySelectorAll('.droppableArea');

            draggables.forEach(draggable => {
                draggable.addEventListener('dragstart', dragStart);
            });

            droppableAreas.forEach(droppableArea => {
                droppableArea.addEventListener('dragover', dragOver);
                droppableArea.addEventListener('drop', drop);
            });

            function dragStart(event) {
                event.dataTransfer.setData('text/plain', event.currentTarget.id);
            }

            function dragOver(event) {
                event.preventDefault();
            }

            function drop(event) {
                event.preventDefault();
                const draggableId = event.dataTransfer.getData('text/plain');
                const draggable = document.getElementById(draggableId);
                const button = $(draggable).find('.updateStatusBtn');
                const form = button.closest('form');
                const id = form.attr('data-item-id');
                const droppableArea = event.currentTarget;
                const status = event.currentTarget.id;

                let newStatus;
                let newStatusText;
                switch (status) {
                    case 'prepress':
                        newStatus = 0;
                        newStatusText = 'Move To Production'
                        break;
                    case 'production':
                        newStatus = 1;
                            newStatusText = 'Move To Ready'
                        break;
                    case 'ready':
                        newStatus = 2;
                        newStatusText = 'Move To Completed'
                        break;
                }

                $.ajax({
                    url: `/dashboard/orders/update/${id}`,
                    method: 'POST',
                    data: {
                        delivery_status: newStatus,
                    },
                    success: function (response) {
                        // Update button text
                        button.text(newStatusText);
                        button.attr('data-current-status', newStatus)
                        droppableArea.appendChild(draggable);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            const deleteButtons = $('.delete-order');

            deleteButtons.on('click', function() {
                const orderId = $(this).data('order');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(({isConfirmed}) => {
                    if (isConfirmed) {
                        $(this).parent().submit();
                    }
                })
            })
        });
    </script>
@endpush
