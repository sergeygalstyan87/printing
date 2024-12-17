@extends('layouts.admin')



@section('content')
    <section class="page-content container-fluid">
        <form method="post" action="{{route('dashboard.orders.decline-order', ['id' => $item->id])  }}">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Decline Order {{  $item->est_number}}</h5>
                        <div class="card-body">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#refundModal">Add Refund</button>

                            <div class="form-group col-sm-12">
                                <label>Reason</label>
                                <input type="hidden" name="id" value="{{$item->id}}"/>
                                <textarea rows="6" id="description" class="form-control" placeholder="" name="decline_reason">
                                    {{ old('decline_reason', $item->decline_reason) }}
                                </textarea>
                            </div>
<div class="form-group col-sm-12">
    <button type="submit" class="btn btn-success text-white float-right">Send</button>
</div>

                        </div>
                    </div>
                </div>

            </div>
        </form>


    </section>
    <!-- Refund Modal -->
    <div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="refundModalLabel">Refund Amount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="refundForm" method="POST" action="{{ route('dashboard.orders.decline-refund-order', ['id' => $item->id]) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="refundAmount">Refund Amount</label>
                            <input type="number" step="0.01" class="form-control" id="refundAmount" name="refund_amount" required value="{{$item->amount}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Confirm Refund</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#refundForm').on('submit', function(e) {
                e.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);

                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + xhr.responseJSON.message);
                    },
                    complete: function() {
                        $('#refundModal').modal('hide');
                    }
                });
            });
        });

    </script>
@endpush

