@extends('layouts.admin')

@section('content')
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} question</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.questions.update', ['id' => $item->id]) : route('dashboard.questions.store') }}"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="title">Name</label>
                                <input
                                    id="name"
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
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control"
                                    placeholder="Enter email"
                                    name="email"
                                    value="{{ (isset($item) && isset($item->email) ) ? $item->email : old('email') }}"
                                >
                                @error('email')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input
                                    id="subject"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter subject"
                                    name="subject"
                                    value="{{ (isset($item) && isset($item->subject) ) ? $item->subject : old('subject') }}"
                                >
                                @error('subject')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea  id="message"
                                           type="text"
                                           class="form-control"
                                           placeholder="Enter message"
                                           name="message"
                                >{{ (isset($item) && isset($item->message) ) ? $item->message : old('message') }}</textarea>
                                @error('message')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="product_title">Product Title</label>
                                <input
                                        id="product_title"
                                        type="text"
                                        class="form-control"
                                        name="product_title"
                                        value="{{ (isset($item) && isset($item->product->title) ) ? $item->product->title : '' }}"
                                        readonly
                                >
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

