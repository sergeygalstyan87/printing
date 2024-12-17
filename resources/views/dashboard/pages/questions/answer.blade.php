@extends('layouts.admin')

@push('styles')
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
@endpush

@section('content')
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Question</h5>
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
                                readonly
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
                                readonly
                            >
                            @error('email')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input
                                id="phone"
                                type="tel"
                                class="form-control"
                                placeholder="Enter phone"
                                name="email"
                                value="{{ (isset($item) && isset($item->phone) ) ? $item->phone : old('phone') }}"
                                readonly
                            >
                            @error('phone')
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
                                readonly
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
                                       readonly
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
                        <div class="form-group">
                            <a href="{{route('product', $item->product->slug)}}" target="_blank" title="Show product">
                                <img src="{{ asset('storage/content/' . $item->product->images[0]) }}" alt="product" style="width: 200px;">
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Answer Question</h5>
                    <form
                            method="post"
                            action="{{ route('dashboard.questions.sendAnswer', ['id' => $item->id]) }}"
                            enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input
                                        id="subject"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter subject"
                                        name="subject"
                                        value="{{ (isset($item) && isset($item->subject) ) ? $item->subject : old('subject') }}"
                                        required
                                >
                                @error('subject')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group" >
                                <label for="content">Message</label>
                                <textarea class="form-control" id="content" placeholder="Enter the answer message"
                                          name="answer">{{ (isset($item) && isset($item->answer) ) ? $item->answer : old('answer') }}</textarea>
                                @error('answer')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="card-footer bg-light">
                                <button class="btn btn-primary">Send answer</button>
                                <button type="button" class="btn btn-secondary clear-form">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush

