@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">
@endpush

@section('content')

    <section class="ec-page-content section-space-p auth_form">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Register</h2>
                        <h2 class="ec-title">Register</h2>
                        <p class="sub-title mb-3">Best place to buy and sell digital products</p>
                    </div>
                </div>
                <div class="ec-register-wrapper">
                    <div class="ec-register-container">
                        <div class="ec-register-form">
                            <form action="{{ route('register') }}" method="post" id="register_form">
                                @csrf
                                <span class="ec-register-wrap ec-register-wrap">
                                    <label>Full Name*</label>
                                    <input type="text" name="name" placeholder="Enter your full name" class="@error('name') is-invalid @enderror" required />
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Phone*</label>
                                    <input type="text" name="phone" class="@error('phone') is-invalid @enderror" id="phone" required />
                                     <div class="invalid-feedback error-msg">
                                        Please enter valid phone number.
                                    </div>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Email*</label>
                                    <input type="email" name="email" placeholder="Enter your email address" class="@error('email') is-invalid @enderror" required />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Password*</label>
                                    <input type="password" name="password" placeholder="Password" class="@error('password') is-invalid @enderror" required />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Password confirmation*</label>
                                    <input type="password" name="password_confirmation" placeholder="Password confirmation" required />
                                </span>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                                {{--                                <span class="ec-register-wrap ec-register-half">--}}
                                {{--                                    <label>First Name*</label>--}}
                                {{--                                    <input type="text" name="firstname" placeholder="Enter your first name" required />--}}
                                {{--                                </span>--}}
                                {{--                                <span class="ec-register-wrap ec-register-half">--}}
                                {{--                                    <label>Last Name*</label>--}}
                                {{--                                    <input type="text" name="lastname" placeholder="Enter your last name" required />--}}
                                {{--                                </span>--}}
                                {{--                                <span class="ec-register-wrap ec-register-half">--}}
                                {{--                                    <label>Email*</label>--}}
                                {{--                                    <input type="email" name="email" placeholder="Enter your email add..." required />--}}
                                {{--                                </span>--}}
                                {{--                                <span class="ec-register-wrap ec-register-half">--}}
                                {{--                                    <label>Phone Number*</label>--}}
                                {{--                                    <input type="text" name="phonenumber" placeholder="Enter your phone number"--}}
                                {{--                                           required />--}}
                                {{--                                </span>--}}
                                {{--                                <span class="ec-register-wrap">--}}
                                {{--                                    <label>Address</label>--}}
                                {{--                                    <input type="text" name="address" placeholder="Address Line 1" />--}}
                                {{--                                </span>--}}
                                {{--                                <span class="ec-register-wrap ec-register-half">--}}
                                {{--                                    <label>City *</label>--}}
                                {{--                                    <span class="ec-rg-select-inner">--}}
                                {{--                                        <select name="ec_select_city" id="ec-select-city" class="ec-register-select">--}}
                                {{--                                            <option selected disabled>City</option>--}}
                                {{--                                            <option value="1">City 1</option>--}}
                                {{--                                            <option value="2">City 2</option>--}}
                                {{--                                            <option value="3">City 3</option>--}}
                                {{--                                            <option value="4">City 4</option>--}}
                                {{--                                            <option value="5">City 5</option>--}}
                                {{--                                        </select>--}}
                                {{--                                    </span>--}}
                                {{--                                </span>--}}
                                {{--                                <span class="ec-register-wrap ec-register-half">--}}
                                {{--                                    <label>Post Code</label>--}}
                                {{--                                    <input type="text" name="postalcode" placeholder="Post Code" />--}}
                                {{--                                </span>--}}
                                {{--                                <span class="ec-register-wrap ec-register-half">--}}
                                {{--                                    <label>Country *</label>--}}
                                {{--                                    <span class="ec-rg-select-inner">--}}
                                {{--                                        <select name="ec_select_country" id="ec-select-country"--}}
                                {{--                                                class="ec-register-select">--}}
                                {{--                                            <option selected disabled>Country</option>--}}
                                {{--                                            <option value="1">Country 1</option>--}}
                                {{--                                            <option value="2">Country 2</option>--}}
                                {{--                                            <option value="3">Country 3</option>--}}
                                {{--                                            <option value="4">Country 4</option>--}}
                                {{--                                            <option value="5">Country 5</option>--}}
                                {{--                                        </select>--}}
                                {{--                                    </span>--}}
                                {{--                                </span>--}}
                                {{--                                <span class="ec-register-wrap ec-register-half">--}}
                                {{--                                    <label>Region State</label>--}}
                                {{--                                    <span class="ec-rg-select-inner">--}}
                                {{--                                        <select name="ec_select_state" id="ec-select-state" class="ec-register-select">--}}
                                {{--                                            <option selected disabled>Region/State</option>--}}
                                {{--                                            <option value="1">Region/State 1</option>--}}
                                {{--                                            <option value="2">Region/State 2</option>--}}
                                {{--                                            <option value="3">Region/State 3</option>--}}
                                {{--                                            <option value="4">Region/State 4</option>--}}
                                {{--                                            <option value="5">Region/State 5</option>--}}
                                {{--                                        </select>--}}
                                {{--                                    </span>--}}
                                {{--                                </span>--}}

                                <span class="ec-register-wrap ec-register-btn">
                                    <button class="btn btn-primary">Register</button>
                                </span>
                            </form>
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
        $(document).ready(function () {
            $("#register_form").on('submit', (function (e) {
                e.preventDefault();
                if (!iti.isValidNumberPrecise()) {
                    const errorCode = iti.getValidationError();
                    const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
                    const msg = errorMap[errorCode] || "Invalid number";
                    $('.error-msg').text(msg);
                    $('.error-msg').show();

                    $(this).addClass('error is-invalid');
                    return;
                }else {
                    this.submit();
                }
            }));
        });
    </script>
@endpush
