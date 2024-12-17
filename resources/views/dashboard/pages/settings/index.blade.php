@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Settings</h5>
                    <div class="card-body">
                        <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
{{--                                <th>ID</th>--}}
                                <th>Key</th>
                                <th>Text</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( !empty($items) )
                                @foreach($items as $item)
                                <tr>
{{--                                    <td>{{ $item->id }}</td>--}}
                                    <td>{{ $item->key }}</td>
                                    <td style="word-break: break-word;">{{ $item->value }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.settings.edit', $item->id) }}" class="btn btn-sm btn-light btn-active-light-danger" style="display: inline-flex;align-items: center;">Edit</a>
{{--                                        <form action="{{ route('dashboard.settings.delete', $item->id) }}" method="post" style="display:inline-block;">--}}
{{--                                            @csrf--}}
{{--                                            <button class="btn btn-sm btn-danger btn-active-light-danger">Delete</button>--}}
{{--                                        </form>--}}
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
@endpush