@extends('layouts.admin')

@push('styles')
    <style>
        .profile_address {
            position: relative;
            border: 2px solid;
            border-radius: 20px;
            padding: 20px;
            margin: 20px 0;
        }
        .profile_address p{
            color: #000000;
        }
    </style>
@endpush

@section('content')

    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">{{ (isset($item)) ? 'Edit' : 'Create' }} user</h5>
                    <form
                        method="post"
                        action="{{ (isset($item) ) ? route('dashboard.users.update', ['id' => $item->id]) : route('dashboard.users.store') }}"
                        id="user_form"
                    >
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">First Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter first name"
                                    name="first_name"
                                    value="{{ (isset($item) && isset($item->first_name) ) ? $item->first_name : old('first_name') }}"
                                >
                                <div class="invalid-feedback error-msg"></div>
                                @error('first_name')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Last Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter last name"
                                    name="last_name"
                                    value="{{ (isset($item) && isset($item->last_name) ) ? $item->last_name : old('last_name') }}"
                                >
                                <div class="invalid-feedback error-msg"></div>
                                @error('last_name')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    placeholder="Enter email"
                                    name="email"
                                    value="{{ (isset($item) && isset($item->email) ) ? $item->email : old('email') }}"
                                >
                                <div class="invalid-feedback error-msg"></div>
                                @error('email')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group" style="display: flex;flex-direction: column">
                                <label>Phone</label>
                                <input
                                        type="tel"
                                        id="user_checkout_form_phone"
                                        class="form-control phoneInputs phone"
                                        placeholder="Enter phone"
                                        name="phone"
                                        value="{{ (isset($item) && isset($item->phone) ) ? $item->phone : old('phone') }}"
                                >
                                <div class="invalid-feedback error-msg">
                                    Please enter valid phone number.
                                </div>
                                @error('phone')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Company</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter company"
                                    name="company"
                                    value="{{ (isset($item) && isset($item->company) ) ? $item->company : old('company') }}"
                                >
                                @error('company')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Address</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter address"
                                    name="address"
                                    id="address"
                                    value="{{ (isset($item) && isset($item->address) ) ? $item->address : old('address') }}"
                                >
                                @error('address')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="address_info">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label class="form-label">Unit/Apartment/Suite</label>
                                            <input type="text" name="unit" class="form-control"
                                                    value="{{ (isset($item)) ? $item->unit : old('unit') }}">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="form-label">ZIP</label>
                                            <input type="text" name="zip" class="form-control"
                                                    value="{{ (isset($item)) ? $item->zip : old('zip') }}">
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label class="form-label">City</label>
                                            <input type="text" name="city" class="form-control"
                                                    value="{{ (isset($item)) ? $item->city : old('city') }}">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="form-label">State</label>
                                            <input type="text" name="state" class="form-control"
                                                    value="{{ (isset($item)) ? $item->state : old('state') }}">
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    placeholder="Enter password"
                                    name="password"
                                    value="{{ old('password') }}"
                                >
                                @error('password')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                @enderror
                            </div>

                            @if(isset($item) && count($item->addresses))
                                <hr>
                                <h5 class="mt-6">Addresses</h5>
                                <div class="row">
                                    @foreach($item->addresses as $address)
                                        <div class="col-md-4">
                                            <div class="profile_address">
                                                <p><b>Name:</b> {{ $address->name }}</p>
                                                @if($address->company)
                                                    <p><b>Company:</b> {{ $address->company }}</p>
                                                @endif
                                                <p><b>Email:</b> {{ $address->email }}</p>
                                                <p><b>Phone:</b> {{ $address->phone }}</p>
                                                <p><b>Address:</b> {{ $address->address }}</p>
                                                <p><b>Unit:</b> {{ $address->unit }}</p>
                                                <p><b>City:</b> {{ $address->city }}</p>
                                                <p><b>State:</b> {{ $address->state }}</p>
                                                <p><b>ZIP:</b> {{ $address->zip }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if(auth()->user()->role_id == \App\Enums\UserRoles::SUPER_ADMIN)
                            <div class="form-check d-flex align-items-center gap-x-16">
                                <div>
                                    <input class="form-check-input" type="radio" name="role_id"
                                           {{ (isset($item ) && $item->role_id == \App\Enums\UserRoles::MANAGER) ? 'checked' : '' }}
                                            value="{{\App\Enums\UserRoles::MANAGER}}" id="manager">
                                    <label class="form-check-label" for="manager">Manager</label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="radio" name="role_id"
                                           {{ (isset($item ) && $item->role_id == \App\Enums\UserRoles::DESIGNER) ? 'checked' : '' }}
                                           value="{{\App\Enums\UserRoles::DESIGNER}}" id="designer">
                                    <label class="form-check-label" for="designer">Designer</label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="radio" name="role_id"
                                           {{ (isset($item ) && $item->role_id == \App\Enums\UserRoles::FRONTDESK) ? 'checked' : '' }}
                                           value="{{\App\Enums\UserRoles::FRONTDESK}}" id="frontdesk">
                                    <label class="form-check-label" for="designer">Front Desk</label>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="card-footer bg-light">
                            <button class="btn btn-primary" id="user_form_submit">Submit</button>
                            <button type="button" class="btn btn-secondary clear-form">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDn1gU-9ENcDEK5IsuwJNVgrtqnwRHddMc&country=US&sensor=false&libraries=places&language=en-AU"></script>
    <script>
        $(document).ready(function(){
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

            const phoneInputs = document.querySelectorAll(".phone");
            console.log(phoneInputs);
            var intlTelInputs = {};

            phoneInputs.forEach(function(input) {
                intlTelInputs[input.id] = window.intlTelInput(input, {
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/utils.js?1712488050476",
                    i18n: {
                        ca: "Canada",
                        us: "United States",
                    },
                    onlyCountries: ["ca", "us"],
                    initialCountry: "us",
                    countrySearch: false,
                    formatOnDisplay: true,
                    autoPlaceholder: "polite",
                    showSelectedDialCode: true,
                });
            })

            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function checkError(field) {
                let errors = 0;
                const value = $(field).val() ? $(field).val().trim() : '';
                const fieldName = $(field).attr('name');
                // Clear previous error state
                $(field).removeClass('error is-invalid');
                $(field).closest('.form-group').find('.invalid-feedback').hide();
                // Check for specific field validations
                switch (fieldName) {
                    case 'email':
                        if (!isValidEmail(value)) {
                            $(field).addClass('error is-invalid');
                            errors++;
                        }
                        break;
                    case 'phone':
                        const phoneId = field.attr('id');
                        const iti = intlTelInputs[phoneId];
                        if (!iti.isValidNumberPrecise()) {
                            const errorCode = iti.getValidationError();
                            const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
                            const msg = errorMap[errorCode] || "Invalid number";
                            $(field).closest('.form-group').find('.invalid-feedback').text(msg).show();

                            $(field).addClass('error is-invalid');
                            errors++;
                        }
                        break;
                    default:
                        if (!value) {
                            $(field).addClass('error is-invalid');
                            errors++;
                        }
                }

                return errors ;
            }

            $('#user_form_submit').click((e) => {
                e.preventDefault();
                let errors = 0;

                const fieldArray = [
                    $('#user_form input[name=first_name]'),
                    $('#user_form input[name=last_name]'),
                    $('#user_form input[name=email]'),
                    $('#user_form input[name=phone]'),
                ];
                fieldArray.forEach(elem => {
                    if(elem){
                        errors += checkError(elem);
                    }
                })

                if(!errors){
                    $('#user_form').submit();
                }
            })
        });
    </script>
@endpush
