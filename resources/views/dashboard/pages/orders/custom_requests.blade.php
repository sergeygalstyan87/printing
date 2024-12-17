@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid order_list">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header" style="display: flex;justify-content: space-between">
                        <span>Orders</span>
                        <form action="{{ route('dashboard.orders.delete_images') }}" method="post">
                            @csrf
                            <button style="background: red;border: none;border-radius: 4px;color: #fff;padding: 5px 10px;font-size: 14px;" class="delete_order_images">Delete images</button>
                        </form>
                    </h5>
                    <div class="card-body">
                        <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Request Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( !empty($items) )
                                @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->product->title }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td style="text-transform: capitalize">{{ $item->email }}</td>

                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('YYYY/MM/DD').' ('. \Carbon\Carbon::parse($item->created_at)->diffForHumans() .')' }}</td>
                                    <td>
                                    <a href="{{ route('dashboard.orders.edit-request', $item->id) }}" class="btn btn-sm btn-light btn-active-light-danger" style="display: inline-flex;align-items: center;">Details</a>
                                      @if( $item->amount > 0)
                                          <a href="{{ route('dashboard.orders.generate_invoice', ['id' =>  $item->id]) }}"
                                            class="btn btn-sm btn-success text-white d-inline-flex align-items-center justify-content-center">
                                              @if(isset($item->invoice_sent))
                                                Regenerate Invoice
                                              @else
                                                Generate Invoice
                                              @endif
                                          </a>
                                      @endif
                                        <form action="{{ route('dashboard.orders.delete', $item->id) }}" method="post" style="display:inline-block;">
                                            @csrf
                                            <input  type="hidden" name="is_custom" value="1">
                                            <button type="button" class="btn btn-sm btn-danger btn-active-light-danger delete-order">Delete</button>
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
            const deleteButtons = $('.delete-order');

            deleteButtons.on('click', function() {
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
            });

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
        });
    </script>
@endpush
