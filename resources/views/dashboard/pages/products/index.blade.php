@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Products</h5>
                    <div class="card-body">
                        <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                @if(Route::currentRouteName() == 'dashboard.products.single')
                                    <th>Order</th>
                                @endif
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( !empty($items) )
                                @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.products.single', $item->category->id) }}" class="text-danger">
                                            {{ $item->category->name }}
                                        </a>
                                    </td>
                                    @if(Route::currentRouteName() == 'dashboard.products.single')
                                        <td>
                                            <form action="{{ route('dashboard.products.change_order', ['id' => $item->id]) }}" method="post" style="display: flex">
                                                @csrf
                                                <input type="number" class="form-control" name="order" value="{{ $item->order }}" style="width: 100px;margin-right: 15px;" required>
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button class="btn btn-success">Save</button>
                                            </form>
                                        </td>
                                    @endif
                                    <td>
                                        <a href="{{ route('dashboard.products.edit', $item->id) }}" class="btn btn-sm btn-light btn-active-light-danger" style="display: inline-flex;align-items: center;">Edit</a>
                                        @if(auth()->user()->role_id === \App\Enums\UserRoles::SUPER_ADMIN)
                                            <form action="{{ route('dashboard.products.delete', $item->id) }}" method="post" style="display:inline-block;">
                                                @csrf
                                                <button class="btn btn-sm btn-danger btn-active-light-danger">Delete</button>
                                            </form>

                                            <a href="{{ route('dashboard.products.attrs', $item->id) }}" class="btn btn-sm btn-primary btn-active-light-danger" style="display: inline-flex;align-items: center;">Attrs</a>
                                            @if(!empty($item->detail_info))
                                               <a href="{{ route('dashboard.products.rel_attrs', $item->id) }}" class="btn btn-sm btn-warning btn-active-light-danger" style="display: inline-flex;align-items: center;">Related Attrs</a>
                                            @endif
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
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('admin/assets/js/components/datatables-init.js') }}"></script>
@endpush
