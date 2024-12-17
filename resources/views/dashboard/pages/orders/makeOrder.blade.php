@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <style>
        .lds-ellipsis {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto;
        }
        .lds-ellipsis div {
            position: absolute;
            top: 33px;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: #3474d4;
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }
        .lds-ellipsis div:nth-child(1) {
            left: 8px;
            animation: lds-ellipsis1 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(2) {
            left: 8px;
            animation: lds-ellipsis2 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(3) {
            left: 32px;
            animation: lds-ellipsis2 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(4) {
            left: 56px;
            animation: lds-ellipsis3 0.6s infinite;
        }
        @keyframes lds-ellipsis1 {
            0% {
                transform: scale(0);
            }
            100% {
                transform: scale(1);
            }
        }
        @keyframes lds-ellipsis3 {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(0);
            }
        }
        @keyframes lds-ellipsis2 {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(24px, 0);
            }
        }
        .refresh:hover{
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <section class="page-content container-fluid">
        <form
                method="post"
                action="{{ route('dashboard.orders.make_order') }}"
                id="make_order_form"
        >
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Create order</h5>
                            <div class="card-body">
                                <input type="hidden" name="type" value="-">
                                <input type="hidden" name="status" value="customRequest">
                                <div class="form-group">
                                    <label for="product_id">Product</label>
                                    <select class="form-control edit_select2 product_select" name="product_id" id="product_id" required>
                                        <option value="" disabled selected>Please select a product</option>
                                        @foreach($products as $product)
                                            <option data-title="{{ $product->title }}" value="{{ $product->id }}" {{ (isset($item) && $item->product_id == $product->id) || old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="attribute-container">
                                    <div class="row attribute-row align-items-end">
                                        <div class="form-group col-sm-5 col-md-5">
                                            <label for="attribute_id">Attribute</label>
                                            <select class="form-control edit_select2 attribute_select" disabled name="attribute_id[]" id="attribute_id" required>
                                                <option value="" disabled selected>Select attribute</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-5">
                                            <label for="type_id">Type</label>
                                            <select class="form-control edit_select2 type_select" disabled name="type_id[]" id="type_id" required>
                                                <option value="" disabled selected>Select type</option>
                                            </select>
                                        </div>
                                        <div class="form-group col d-flex justify-content-end">
                                            <button type="button" class="btn btn-danger delete-attribute">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col">
                                        <button type="button" class="btn btn-success add_attribute mr-3">Add</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Quantity</label>
                                        <input
                                                type="number"
                                                class="form-control"
                                                placeholder="Enter quantity"
                                                name="qty"
                                                value="{{ (isset($item) && isset($item->qty) ) ? $item->qty : old('qty') }}"
                                                required
                                        >
                                        @error('qty')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label for="original_amount">Order Price</label>
                                                <input
                                                        id="original_amount"
                                                        type="number"
                                                        class="form-control"
                                                        placeholder="Enter price"
                                                        name="original_amount"
                                                        value="{{ (isset($item) && isset($item->original_amount) ) ? $item->original_amount : old('original_amount') }}"
                                                        required
                                                >
                                                @error('original_amount')
                                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Payment type</label>
                                                <div class="payment_type">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="payment_type" id="stripe" value="stripe">
                                                        <label class="form-check-label" for="stripe">
                                                            Link
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="payment_type" id="cash" value="cash">
                                                        <label class="form-check-label" for="cash">
                                                            Cash
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="payment_type" id="terminal" value="terminal">
                                                        <label class="form-check-label" for="terminal">
                                                            Terminal
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Notes</label>
                                        <textarea
                                                id="description"
                                                class="form-control"
                                                placeholder="Enter order description"
                                                name="notes"
                                        >{{(isset($item) && isset($item->notes) ) ? $item->notes : old('notes') }}</textarea>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleInputEmail1">Status</label>
                                        <select class="form-control edit_select2 attribute_select" name="delivery_status" id="delivery_status" required>
                                            <option value="5">Design</option>
                                            <option value="0" disabled>Prepress</option>
                                            <option value="1" disabled>Production</option>
                                            <option value="2" disabled>Ready</option>
                                            <option value="3" disabled>Picked up</option>
                                            <option value="4" disabled>Shipping</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">User Details</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>First Name</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter first name"
                                            name="first_name"
                                            value="{{ (isset($item) && isset($item->first_name) ) ? $item->first_name : old('first_name') }}"
                                    >
                                    @error('first_name')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Last Name</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter last name"
                                            name="last_name"
                                            value="{{ (isset($item) && isset($item->last_name) ) ? $item->last_name : old('last_name') }}"
                                    >
                                    @error('last_name')
                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Email</label>
                                    <input
                                            type="email"
                                            class="form-control"
                                            placeholder="Enter email"
                                            name="email"
                                            value="{{ (isset($item) && isset($item->email) ) ? $item->email : old('email') }}"
                                    >
                                    <div class="invalid-feedback">
                                        Please enter valid email.
                                    </div>
                                </div>
                                <div class="form-group col-sm-6" style="display: flex;flex-direction: column">
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
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Address</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            id="address"
                                            autocomplete="false"
                                            placeholder="Enter Address"
                                            name="address"
                                            value="{{ (isset($item) && isset($item->address) ) ? $item->address : old('address') }}"
                                    >
                                </div>
                            </div>
                            <div class="address_info">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Unit/Apartment/Suite</label>
                                        <input type="text" name="unit" class="form-control"
                                               value="{{ isset($item) ? $item->unit : old('unit') }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">ZIP</label>
                                        <input type="text" name="zip" class="form-control"
                                        value="{{ isset($item) ? $item->zip : old('zip') }}">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">City</label>
                                        <input type="text" name="city" class="form-control"
                                        value="{{ isset($item) ? $item->city : old('city') }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">State</label>
                                        <input type="text" name="state" class="form-control"
                                        value="{{ isset($item) ? $item->state : old('state') }}">
                                    </div>

                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Shipping</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Delivery type</label>
                                    <div class="delivery_type">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="delivery_type" id="pickedUp" value="pickup" checked data-tax="{{$pickUp_tax_rate}}">
                                            <label class="form-check-label" for="pickedUp">
                                                Picked Up
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="delivery_type" id="shipping" value="shipping">
                                            <label class="form-check-label" for="shipping">
                                                Shipping
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <i class="icon dripicons-clockwise refresh text-danger" title="Recount Total Price"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <div class="rate_list_form"></div>
                                </div>
                                <div class="form-group col-12 d-flex align-items-center" id="total_block">
                                    <input type="hidden" id="tax_amount" name="tax" value="0.00"/>
                                    <input type="hidden" id="shipping_price" name="shipping_price" value="0.00"/>
                                    <input type="hidden" id="shipping_provider" name="shipping_provider" />
                                    <input type="hidden" id="shipping_provider_id" name="shipping_provider_id" />
                                    <div class="d-flex flex-column align-items-start justify-items-center">
                                        <label class="form-label">Price</label>
                                        <input type="text" class="text-lg" id="price_cost" value="0.00"/>
                                    </div>
                                    <div class="d-flex flex-column align-items-start justify-items-center">
                                        <label class="form-label">Tax</label>
                                        <input type="text" class="text-lg" id="tax_cost" value="0.00"/>
                                    </div>
                                    <div class="d-flex flex-column align-items-start justify-items-center">
                                        <label class="form-label">Shipping</label>
                                        <input type="text" class="text-lg" id="shipping_cost" value="0.00"/>
                                    </div>
                                    <div class="d-flex flex-column align-items-start justify-items-center">
                                        <label class="form-label">Total</label>
                                        <input type="text" class="total_cost text-lg text-danger" id="total_cost" name="total_price" value="0.00"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <button class="btn btn-primary" id="submit_form">Submit</button>
                            <button type="button" class="btn btn-secondary clear-form">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection

@push('scripts')
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDn1gU-9ENcDEK5IsuwJNVgrtqnwRHddMc&country=US&sensor=false&libraries=places&language=en-AU"></script>
    <script src="{{ asset('admin/assets/js/components/select2-init.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    formatOnDisplay:true,
                    autoPlaceholder:"polite",
                    showSelectedDialCode: true,
                });
            });

            function initializeSelect2() {
                $('.edit_select2').each(function() {
                    $(this).removeClass('select2-hidden-accessible')
                        .next('.select2-container')
                        .remove();
                    $(this).removeAttr('data-select2-id')
                        .removeAttr('aria-hidden');
                });
                $('.edit_select2').select2({width: '100%' });

            }

            initializeSelect2();

            $(".add_attribute").click(function() {
                $('.edit_select2').select2('destroy');
                const attributeRow = $(".attribute-row").first().clone();
                attributeRow.find('.edit_select2').each(function(index, element) {
                    $(element).find('option:eq(0)').prop('selected', true);
                    const uniqueId = new Date().getTime();
                    $(element).attr('id', $(element).attr('id') + '_' + uniqueId);
                });
                const typeSelect = attributeRow.find('.type_select');
                typeSelect.empty();
                $('<option>', {
                    value: '',
                    text: 'Select type',
                    disabled: true,
                    selected: true
                }).appendTo(typeSelect);
                attributeRow.appendTo("#attribute-container");

                initializeSelect2();
            });


            $(document).on("click", ".delete-attribute", function() {
                const attributeRows = $('.attribute-row');
                if (attributeRows.length > 1) {
                    const attributeRow = $(this).closest('.attribute-row');
                    attributeRow.remove();
                }
            });

            $(document).on('change', '.product_select', function() {
                // Get the selected attribute ID
                const productId = $(this).val();
                const attributeSelect = $('.attribute-row').find('.attribute_select');

                $.ajax({
                    url: '/dashboard/orders/attribute-types',
                    method: 'GET',
                    data: { product_id: productId },
                    success: function(response) {
                        $('.edit_select2').select2('destroy');
                        attributeSelect.empty();
                        // Add a default option
                        $('<option>', {
                            value: '',
                            text: 'Select type',
                            disabled: true,
                            selected: true
                        }).appendTo(attributeSelect);

                        // Loop through the response data and add options to the type select
                        $.each(response.attributes, function(index, attribute) {
                            $('<option>', {
                                value: attribute.id,
                                text: attribute.notes ? `${attribute.name} (${attribute.notes})` : attribute.name,
                            }).appendTo(attributeSelect);
                        });

                        attributeSelect.prop('disabled', false);
                        const typeSelect = $('.attribute-row').find('.type_select');
                        typeSelect.prop('disabled', true);
                        attributeSelect.trigger('change');
                        initializeSelect2();

                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $(document).on('change', '.attribute_select', function() {
                // Get the selected attribute ID
                const attributeId = $(this).val();
                const typeSelect = $(this).closest('.attribute-row').find('.type_select');

                if(attributeId){
                    $.ajax({
                        url: '/dashboard/orders/attribute-types',
                        method: 'GET',
                        data: { attribute_id: attributeId },
                        success: function(response) {
                            $('.edit_select2').select2('destroy');
                            typeSelect.empty();
                            // Add a default option
                            $('<option>', {
                                value: '',
                                text: 'Select type',
                                disabled: true,
                                selected: true
                            }).appendTo(typeSelect);

                            // Loop through the response data and add options to the type select
                            $.each(response.types, function(index, type) {
                                $('<option>', {
                                    value: type.id,
                                    text: type.name
                                }).appendTo(typeSelect);
                            });

                            typeSelect.prop('disabled', false);
                            typeSelect.trigger('change');
                            initializeSelect2();

                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });

            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function checkError(field) {
                let errors = 0;
                const value = $(field).val().trim();
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

            $('#submit_form').click((e) => {
                e.preventDefault();
                let errors = 0;

                const fieldArray = [
                    $('#make_order_form input[name=first_name]'),
                    $('#make_order_form input[name=last_name]'),
                    $('#make_order_form input[name=email]'),
                    $('#make_order_form input[name=phone]'),
                    $('#make_order_form input[name=address]'),
                    $('#make_order_form input[name=zip]'),
                    $('#make_order_form input[name=city]'),
                    $('#make_order_form input[name=state]')
                ];
                fieldArray.forEach(elem => {
                    if(elem){
                        errors += checkError(elem);
                    }
                })

                if(!errors){
                    $('#make_order_form').submit();
                }
            })

            $('.refresh').click(()=>{
                $('input[name="delivery_type"]').change();
            });

            $('input[name="delivery_type"]').change(function() {
                if ($('input[name="delivery_type"]:checked').val() === 'shipping') {
                    let zipCode = $('input[name="zip"]').val();

                    const data = [];
                    const body = {};
                    data.push({name:'no_pickup', 'value':1});
                    data.push({name:'product_id','value':$("#product_id").val()});
                    data.push({name:'quantity','value':$("input[name='qty']").val()});
                    data.push({name:'address','value':$("input[name='address']").val()});
                    data.push({name:'unit','value':$("input[name='unit']").val()});
                    data.push({name:'zip','value':zipCode});
                    data.push({name:'city','value':$("input[name='city']").val()});
                    data.push({name:'state','value':$("input[name='state']").val()});
                    var total_price = parseFloat($("#original_amount").val());
                    data.push({name:'total_price','value':total_price});
                    for (const dataElement of data) {
                        body[dataElement.name] = dataElement.value
                    }
                    // Ensure the zip code is not empty
                    if (zipCode) {

                        if(!$("#product_id").val()){
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Select Product",
                            });
                            $('#pickedUp').prop('checked', true);
                        }else if(!$("input[name='qty']").val()){
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "No Quantity",
                            });
                            $('#pickedUp').prop('checked', true);
                        }else if(!$("#original_amount").val()){
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "No Price",
                            });
                            $('#pickedUp').prop('checked', true);
                        }else{
                            const loadingSpinner = `<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>`
                            $('.rate_list_form').html(loadingSpinner)
                            $.ajax({
                                type: "POST",
                                url: "{{route('calculateShipmentPrices')}}",
                                data: body,
                                dataType: 'json',
                                success: (data) => {
                                    let tax_rate = renderShipmentVariants(data)
                                }
                            });
                        }
                    } else {
                        if(!$("#product_id").val()){
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Select Product",
                            });
                        }else if(!$("input[name='qty']").val()){
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "No Quantity",
                            });
                        }else if(!$("#original_amount").val()){
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "No Price",
                            });
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Select Zip Code",
                            });
                        }
                        $('#pickedUp').prop('checked', true);
                    }
                }else{
                    if(!$("#original_amount").val()) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "No Price",
                        });
                        return;
                    }
                    $('.rate_list_form').html('');
                    let total_price = parseFloat($("#original_amount").val());
                    let tax_rate = $('#pickedUp').data('tax');
                    let tax = parseFloat((total_price  * tax_rate).toFixed(2));
                    $("#tax_amount").val(tax);
                    $("#price_cost").val(total_price);
                    $("#tax_cost").val(tax);
                    $("#shipping_cost").val(0.00);
                    let i = parseFloat((total_price + tax).toFixed(2));
                    $(".total_cost").attr('data-total', i);
                    $('.total_cost').val(i);
                }
            });


            function renderShipmentVariants(shipmentList) {
                const container = $('.rate_list_form');
                container.html(`<table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Shipping Method</th>
                                <th>Prices</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>`);
                if (shipmentList.length === 0) {
                    return;
                }
                let  tax_rate = 0;
                let selected_price = 0;
                let selected_provider = null;
                let selected_provider_id = null;
                let k = 0;
                $.each(shipmentList, function(provider, shipment) {
                    tax_rate =shipment.tax_rate;
                    var is_checked = '';
                    if(k == 0){
                        is_checked = 'checked';
                        selected_price = shipment.price;
                        selected_provider = shipment.provider;
                        selected_provider_id = shipment.provider_id;
                    }
                    const container = $('.rate_list_form').find('tbody');
                    const elementHTMLString = `
                            <tr class="shipment_element" data-id="${shipment.provider_id}" data-price="${shipment.price}" data-name="${shipment.provider}">
                                <td class="shipment_provider">
                                    <input id="id_${shipment.provider_id}" class="shipment_control" type="radio" name="shipment-method" value="${shipment.provider_id}" ${is_checked}
                                   >
                                    <div>

                                        <label for="id_${shipment.provider_id}" class="shipment_provider_description">
                                            <b>${shipment.text}</b> ${shipment.terms}
                                        </label>
                                    </div>
                                </td>

                                <td class="shipment_prices">
                                    +${shipment.price}$
                                </td>
                            </tr>
                        `
                    container.append(elementHTMLString);
                    k++;
                });

                let total_price = parseFloat($("#original_amount").val());
                let tax = parseFloat((total_price  * tax_rate).toFixed(2));
                $("#tax_amount").val(tax);
                $(".total_cost").attr('data-total', total_price + tax);
                let i = parseFloat((total_price + tax + parseFloat(selected_price)).toFixed(2));
                $('.total_cost').val(i);
                $('#total_block').show();
                $('#shipping_price').val(selected_price);
                $('#shipping_provider').val(selected_provider);
                $('#shipping_provider_id').val(selected_provider_id);
                $("#price_cost").val(total_price);
                $("#tax_cost").val(tax);
                $("#shipping_cost").val(selected_price);

                container.on('change', '.shipment_control', function() {
                    const price = $(this).closest('.shipment_element').data('price');
                    const provider = $(this).closest('.shipment_element').data('name');
                    const provider_id = $(this).closest('.shipment_element').data('id');
                    let total_price = parseFloat($("#original_amount").val());
                    let tax = parseFloat((total_price  * tax_rate).toFixed(2));
                    $("#tax_amount").val(tax);
                    let i = parseFloat((total_price + tax + parseFloat(price)).toFixed(2));
                    $('.total_cost').val(i);
                    $(".total_cost").attr('data-total', i);
                    $('#shipping_price').val(price);
                    $('#shipping_provider').val(provider);
                    $('#shipping_provider_id').val(provider_id);
                    $("#price_cost").val(total_price);
                    $("#tax_cost").val(tax);
                    $("#shipping_cost").val(price);
                });

                return tax_rate;

            }

        });
    </script>
@endpush
