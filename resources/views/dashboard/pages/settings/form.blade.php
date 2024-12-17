@extends('layouts.admin')

@section('content')
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} setting</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.settings.update', ['id' => $item->id]) : route('dashboard.settings.store') }}"
                    >
                        @csrf
                        <div class="card-body">
                            <div class="form-group" style="display: none">
                                <label for="exampleInputEmail1">Key</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter key"
                                    name="key"
                                    value="{{ (isset($item) && isset($item->key) ) ? $item->key : old('key') }}"
                                >
                                @error('key')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Value</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter value"
                                    name="value"
                                    value="{{ (isset($item) && isset($item->value) ) ? $item->value : old('value') }}"
                                >
                                @error('value')
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
