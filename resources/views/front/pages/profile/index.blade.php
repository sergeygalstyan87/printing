@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">
    <style>
        .ec-vendor-block-bg, .ec-vendor-block-detail {
            display: none !important;
        }

        .update_form_errors {
            margin-top: 20px;
            color: red;
            font-size: 12px;
        }
    </style>
@endpush

@section('content')

    <section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
        <div class="container">
            <div class="row mb-3">
                <h1 class="welcome_text">Welcome, {{auth()->user()->first_name}}!</h1>
            </div>
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
                                        <form action="{{ route('profile.change_password') }}" method="post"
                                              class="mb-4">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 mt-3">
                                                    @if (session('status'))
                                                        <div class="alert alert-success" role="alert">
                                                            {{ session('status') }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-md-12 mt-3">
                                                    <label class="form-label">Old password</label>
                                                    <input type="password" name="old_password" class="form-control"
                                                           value="" required>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <label class="form-label">New password</label>
                                                    <input type="password" name="password" class="form-control" value=""
                                                           required>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <label class="form-label">Confirm password</label>
                                                    <input type="password" name="password_confirmation"
                                                           class="form-control" value="" required>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    @if($errors->any())
                                                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                                                    @endif
                                                    @if (session('error'))
                                                        <div class="alert alert-danger" role="alert">
                                                            {{ session('error') }}
                                                        </div>
                                                    @endif
                                                    <div class="fcb">
                                                        <button class="btn btn-primary">Save Password</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form
                                                action="{{ route('profile.update_profile') }}"
                                                method="post"
                                                id="update_profile_form">
                                        @php($item = auth()->user())
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                            @if($item)
                                                <input type="hidden" name="address_id" value="{{ $item->id }}">
                                            @endif
                                            <div class="row">
                                                <div class="col-md-6 mt-3">
                                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="first_name" class="form-control"
                                                           value="{{ isset($item) ? $item->first_name : '' }}" required>
                                                    @error('first_name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="last_name" class="form-control"
                                                           value="{{ isset($item) ? $item->last_name : '' }}" required>
                                                    @error('last_name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control"
                                                           value="{{ isset($item) ? $item->email : '' }}" required>
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                                    <input type="text" name="phone" class="form-control" id="phone"
                                                           value="{{ isset($item) ? $item->phone : '' }}" required>
                                                    <div class="invalid-feedback error-msg">
                                                        Please enter valid phone number.
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label class="form-label">Company</label>
                                                    <input type="text" name="company" class="form-control"
                                                           value="{{ isset($item) ? $item->company : '' }}">
                                                </div>
                                                <div class="col-md-8 mt-3">
                                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                                    <input type="text" name="address" class="form-control" id="address" autocomplete="false"
                                                           value="{{ isset($item) ? $item->address : '' }}" required>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="form-label">Unit/Apartment/Suite</label>
                                                    <input type="text" name="unit" class="form-control"
                                                           value="{{ isset($item) ? $item->unit : '' }}">
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                                    <input type="text" name="city" class="form-control"
                                                           value="{{ isset($item) ? $item->city : '' }}" required>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                                    <input type="text" name="state" class="form-control"
                                                           value="{{ isset($item) ? $item->state : '' }}" required>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="form-label">ZIP <span class="text-danger">*</span></label>
                                                    <input type="text" name="zip" class="form-control"
                                                           value="{{ isset($item) ? $item->zip : '' }}" required>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <div class="fcb">
                                                        <button class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('scripts')
    <script src="{{ asset('front/assets/js/demo-8.js') }}"></script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDn1gU-9ENcDEK5IsuwJNVgrtqnwRHddMc&country=US&sensor=false&libraries=places&language=en-AU"></script>
    <script>
        var options = {
            componentRestrictions: { country: ['us', 'ca'] } // Restrict to USA and Canada
        };
        var autocomplete = new google.maps.places.Autocomplete($("#address")[0], options);

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();

            const addressInfo = {
                zipCode: '',
                address: '',
                unitNumber: '',
                state: '',
                city: ''
            };

            place.address_components.forEach(item => {
                const types = item.types;
                if (types.includes('postal_code')) {
                    addressInfo.zipCode = item.long_name;
                } else if (types.includes('route')) {
                    addressInfo.address += item.long_name;
                } else if (types.includes('locality')) {
                    addressInfo.city = item.long_name;
                } else if (types.includes('administrative_area_level_1')) {
                    addressInfo.state = item.long_name;

                } else if (types.includes('street_number')) {
                    addressInfo.address += item.long_name;
                    addressInfo.address += ' ';
                }
            });
            $("input[name='zip']").val(addressInfo.zipCode);
            $("input[name='address']").val(addressInfo.address);
            $("input[name='unit']").val(addressInfo.unitNumber);
            $("input[name='state']").val(addressInfo.state);
            $("input[name='city']").val(addressInfo.city);

        });
    </script>
    <script>
        $(function () {
            $(document).ready(function () {

                $("#update_profile_form").on('submit', (function (e) {
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
                                if (err.status === 422) { // 422 Unprocessable Entity
                                    var errors = err.responseJSON.errors;
                                    var errorMessages = [];

                                    for (var field in errors) {
                                        if (errors.hasOwnProperty(field)) {
                                            errorMessages.push(errors[field].join('<br>'));
                                        }
                                    }
                                    Swal.fire({
                                        html: errorMessages.join('<br>'),
                                        icon: 'error',
                                        confirmButtonColor: '#3085d6',
                                    });
                                }
                            }
                        });
                    }
                }));

            });
        });
    </script>
@endpush
