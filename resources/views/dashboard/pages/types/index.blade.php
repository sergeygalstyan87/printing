@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Types</h5>
                    <div class="card-body">
                        <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Attribute</th>
                                <th>Details</th>

                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( !empty($items) )
                                @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->attribute->name }}
                                        @if($item->attribute->notes)
                                            ({{$item->attribute->notes}})
                                        @endif
                                    </td>
                                    <td>
                                        <?php
                                            if($item->attribute_id !=2){
                                                if ($item->full_paper == 1) {
                                                    if(empty($item->price_keys)){
                                                        echo "N/A";
                                                    }else{
                                                        $p = json_decode($item->price_keys,true);
                                                        foreach($p as $key=>$val){
                                                            if($val['price'] > 0){
                                                                echo "1 list ".$val['size']. ": <b>".$val['price'].'$</b><br>';
                                                            }
                                                        }
                                                    }
                                                }elseif($item->full_paper == 2){
                                                    echo "1 SQR Ft: <b>".$item->price."$</b>";
                                                }else{
                                                    echo "1 product price: <b>".$item->price."$</b>";
                                                }
                                            }else if($item->size_id){
                                                echo "<a href='/dashboard/sizes/edit/".$item->size_id."' target='_blank'>".$item->size_id."</a>";
                                            }else{
                                                echo "Size not set";
                                            }

                                        ?>
                                    </td>

                                    <td>
                                        <a href="{{ route('dashboard.types.edit', $item->id) }}" class="btn btn-sm btn-light btn-active-light-danger" style="display: inline-flex;align-items: center;">Edit</a>
                                        <form action="{{ route('dashboard.types.delete', $item->id) }}" method="post" style="display:inline-block;">
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
