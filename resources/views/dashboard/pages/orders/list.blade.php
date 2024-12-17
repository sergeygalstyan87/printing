@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid order_list">
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('dashboard.orders.create_order') }}" class="btn btn-primary">Create order +</a>
            </div>
        </div>
    </div>
</div>
        <div class="card">
            <div class="card-body">
                @livewire('orders-grid-view')
            </div>
        </div>


    </section>
@endsection
<style>
    .feather-thumbs-up {
        color:green;
    }
    .feather-thumbs-down {
        color:orange;
    }
    .feather-trash-2 {
        color:red;
    }
</style>


