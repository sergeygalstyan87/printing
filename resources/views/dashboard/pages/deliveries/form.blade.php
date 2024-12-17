@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} attribute</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.deliveries.update', ['id' => $item->id]) : route('dashboard.deliveries.store') }}"
                    >
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter title"
                                    name="title"
                                    value="{{ (isset($item) && isset($item->title) ) ? $item->title : old('title') }}"
                                >
                                @error('title')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Amount</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Enter amount"
                                    name="price"
                                    value="{{ (isset($item) && isset($item->price) ) ? $item->price : old('price') }}"
                                >
                                @error('price')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <button class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary clear-form">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
