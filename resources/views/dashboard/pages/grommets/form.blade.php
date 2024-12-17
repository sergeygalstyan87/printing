@extends('layouts.admin')

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} grommet</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.grommets.update', ['id' => $item->id]) : route('dashboard.grommets.store') }}"
                    >
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter name"
                                    name="name"
                                    value="{{ (isset($item) && isset($item->name) ) ? $item->name : old('name') }}"
                                >
                                @error('name')
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
