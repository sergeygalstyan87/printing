@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Customers</h5>
                    <div class="card-body">
                        <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( !empty($items) )
                                @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->first_name }}</td>
                                    <td>{{ $item->last_name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td> {{\Carbon\Carbon::parse($item->created_at)->format('j M Y')}}</td>
                                    <td>
                                        <a href="{{ route('dashboard.users.edit', $item->id) }}" class="btn btn-sm btn-light btn-active-light-danger" style="display: inline-flex;align-items: center;">Edit</a>
                                        <form action="{{ route('dashboard.users.delete', $item->id) }}" method="post" style="display:inline-block;">
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

        @if(auth()->user()->role_id == \App\Enums\UserRoles::SUPER_ADMIN)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Employees</h5>
                        <div class="card-body">
                            <table id="bs4-table_employees" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if( !empty($employees) )
                                    @foreach($employees as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->first_name }}</td>
                                            <td>{{ $item->last_name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ \App\Enums\UserRoles::getRoleName($item->role_id) }}</td>
                                            <td> {{\Carbon\Carbon::parse($item->created_at)->format('j M Y')}}</td>
                                            <td>
                                                <a href="{{ route('dashboard.users.edit', $item->id) }}" class="btn btn-sm btn-light btn-active-light-danger" style="display: inline-flex;align-items: center;">Edit</a>
                                                @if($item->role_id != \App\Enums\UserRoles::SUPER_ADMIN)
                                                <form action="{{ route('dashboard.users.delete', $item->id) }}" method="post" style="display:inline-block;">
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger btn-active-light-danger">Delete</button>
                                                </form>
                                                @endif
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
        @endif
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('admin/assets/js/components/datatables-init.js') }}"></script>
@endpush
