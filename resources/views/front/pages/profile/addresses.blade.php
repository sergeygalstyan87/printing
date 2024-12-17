@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">
    <style>
        .profile_address {
            position: relative;
            border: 2px solid;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .profile_address.default {
            border: 2px solid #00aeef;
        }
        .profile_address.add {
            padding: 0;
        }
        .profile_address.add a {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            min-height: 264px;
        }
        .profile_address.add i {
            font-size: 50px !important;
        }
        .profile_address p {
            margin-bottom: 5px;
        }
        .edit_address {
            position: absolute;
            right: 100px;
            bottom: 20px;
        }
        .delete_address {
            position: absolute;
            right: 30px;
            bottom: 20px;
            color: red;
        }
        .default_address{
            position: absolute;
            right: 30px;
            top: 20px;
            color: #00aeef;
            font-weight: bold;
        }
        .set_default_address{
            position: absolute;
            right: 30px;
            top: 20px;
            color: #00aeef;
            font-weight: bold;
            display: none;
        }
        .profile_address:hover .set_default_address{
            display: block;
        }
    </style>
@endpush

@section('content')

    <section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
        <div class="container">
            <div class="row">
                <!-- Sidebar Area Start -->
                <div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Category Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-vendor-block">
                                @include('front.partials.profile.navigation')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ec-shop-rightside col-lg-9 col-md-12">
                    <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
                        <div class="ec-vendor-card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ec-vendor-block-profile">
                                        <h5>Addresses</h5>
                                        <div class="row">
                                            @if(count(auth()->user()->addresses))
                                                @foreach(auth()->user()->addresses as $address)
                                                    <div class="col-md-6">
                                                        <div
                                                            class="profile_address {{ $address->default ? 'default' : '' }}">
                                                            @if($address->default)
                                                                <span class="default_address">Default</span>
                                                            @else
                                                                <a href="{{ route('profile.set_default_address', ['id' => $address->id]) }}"
                                                                   class="set_default_address">Set default</a>
                                                            @endif
                                                            <a href="{{ route('profile.edit_address', ['id' => $address->id]) }}"
                                                               class="edit_address">Edit</a>
                                                            <a href="{{ route('profile.delete_address', ['id' => $address->id]) }}"
                                                               class="delete_address">Delete</a>
                                                            <p><b>First Name:</b> {{ $address->first_name }}</p>
                                                            <p><b>Last Name:</b> {{ $address->last_name }}</p>
                                                            @if($address->company)
                                                                <p><b>Company:</b> {{ $address->company }}</p>
                                                            @endif
                                                            <p><b>Email:</b> {{ $address->email }}</p>
                                                            <p><b>Phone:</b> {{ $address->phone }}</p>
                                                            <p><b>Address:</b> {{ $address->address }}</p>
                                                            <p><b>Unit/Apartment/Suite:</b> {{ $address->unit }}</p>
                                                            <p><b>City:</b> {{ $address->city }}</p>
                                                            <p><b>State:</b> {{ $address->state }}</p>
                                                            <p><b>ZIP:</b> {{ $address->zip }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="col-md-6">
                                                <div class="profile_address add">
                                                    <a href="{{ route('profile.add_address') }}">
                                                        <i class="ecicon eci-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('front/assets/js/demo-8.js') }}"></script>
    <script>
        $(function () {
            $(document).ready(function () {

                $("#update_profile_form").on('submit', (function (e) {
                    e.preventDefault();
                    $('.update_form_errors').html('')
                    let formData = new FormData(this);
                    $.ajax({
                        url: '{{ route('profile.update_profile') }}',
                        type: "POST",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            data.status === "Success" ? location.reload() : ''
                        },
                        error: function (err) {
                            Object.entries(err.responseJSON?.errors).forEach(([key, val]) => {
                                $('.update_form_errors').append('<li>' + val[0] + '</li>')
                            });
                        }
                    });
                }));

            });
        });
    </script>
@endpush
