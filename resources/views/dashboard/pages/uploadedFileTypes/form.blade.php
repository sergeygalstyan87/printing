@extends('layouts.admin')

@section('content')
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} Uploaded file types</h5>
                    <form
                            method="post"
                            action="{{ (isset($item) ) ? route('dashboard.uploadedFileTypes.update', ['id' => $item->id]) : route('dashboard.uploadedFileTypes.store') }}"
                            enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input
                                        id="title"
                                        class="form-control"
                                        placeholder="Enter title"
                                        name="title"
                                        value="{{ (isset($item) && isset($item->title) ) ? $item->title : old('title') }}"
                                >
                                @error('title')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="card-footer bg-light">
                            <button class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary clear-form">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection