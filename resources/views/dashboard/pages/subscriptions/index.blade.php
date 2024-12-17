@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="display: flex;justify-content: space-between;align-items: center">
                        <h5>Subscriptions</h5>
                        <button class="send_email btn-primary">Send Email</button>
                    </div>
                    <div class="card-body">
                        <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Subscribed at</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( !empty($items) )
                                @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.subscriptions.edit', $item->id) }}" class="btn btn-sm btn-light btn-active-light-danger" style="display: inline-flex;align-items: center;">Edit</a>
                                        <form action="{{ route('dashboard.subscriptions.delete', $item->id) }}" method="post" style="display:inline-block;">
                                            @csrf
                                            <button class="btn btn-sm btn-danger btn-active-light-danger">Delete</button>
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
        $(document).ready(function(){
            $('.send_email').click(function(){
                Swal.fire({
                    title: 'Send Email',
                    html:
                        '<input id="email_subject" class="swal2-input" placeholder="Email Subject">' +
                        '<textarea id="email_text" class="swal2-textarea" placeholder="Email Text"></textarea>',
                    focusConfirm: false,
                    confirmButtonText: 'Send emails',
                    preConfirm: () => {
                        const emailSubject = $('#email_subject').val();
                        const emailText = $('#email_text').val();

                        if (!emailSubject || !emailText) {
                            Swal.showValidationMessage('Please fill in both fields');
                            return false;
                        }

                        return {
                            email_subject: emailSubject,
                            email_text: emailText
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '/dashboard/send-email',
                            data: {
                                email_subject: result.value.email_subject,
                                email_text: result.value.email_text
                            },
                            success: function(response){
                                Swal.fire(
                                    'Email Sent!',
                                    'Email has been queued for sending.',
                                    'success'
                                );
                            },
                            error: function(xhr, status, error){
                                Swal.fire(
                                    'Error!',
                                    'Failed to send email.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

@endpush
