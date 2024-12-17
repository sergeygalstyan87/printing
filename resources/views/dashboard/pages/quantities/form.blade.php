@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} Quantity</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.quantities.update', ['id' => $item->id]) : route('dashboard.quantities.store') }}"
                    >
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Quantity</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Enter Quantity"
                                    name="number"
                                    value="{{ (isset($item) && isset($item->number) ) ? $item->number : old('number') }}"
                                >
                                @error('number')
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
