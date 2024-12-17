@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            @if(auth()->user()->role_id === \App\Enums\UserRoles::SUPER_ADMIN)
                <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Upload Zip Codes:</h5>

                    <div class="card-body">
                        <form action="{{ route('dashboard.services.import') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                         <input type="file" name="file"/>
                        <button type="submit">Import CSV</button>
                        </form>
                        <div style="margin-top:20px;max-height: 400px;overflow: scroll;">
                            <table width="300px">
                                <thead>
                                <tr>
                                    <th width="50px">State</th>
                                    <th width="200px" align="right">Total Zip</th>
                                </tr>

                                </thead>
                                <tbody>
                                <?php if(!empty($zips)): ?>
                                <?php foreach($zips as $val):?>
                                <tr>
                                    <td><?= $val->state;?></td>
                                    <td><?= $val->total_zips;?></td>
                                </tr>

                                 <?php endforeach;?>
                                <?php endif;?>
                                </tbody>
                            </table>
                        </div>
            </div>
                </div>
            </div>
            @endif
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Services</h5>
                    <div class="card-body">
                        <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
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
                                        <a href="{{ route('dashboard.services.edit', $item->id) }}" class="btn btn-sm btn-light btn-active-light-danger" style="display: inline-flex;align-items: center;">Edit</a>
                                        <form action="{{ route('dashboard.services.delete', $item->id) }}" method="post" style="display:inline-block;">
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
@endpush
