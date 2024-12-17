@extends('layouts.admin')

@section('content')
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} subscription</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.subscriptions.update', ['id' => $item->id]) : route('dashboard.subscriptions.store') }}"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="title">Email</label>
                                <input
                                    id="email"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter email"
                                    name="email"
                                    value="{{ (isset($item) && isset($item->email) ) ? $item->email : old('email') }}"
                                >
                                @error('email')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
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

