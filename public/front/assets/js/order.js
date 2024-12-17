var options = {
    componentRestrictions: {country: ['us', 'ca']} // Restrict to USA and Canada
};

$(".address").each(function () {
    var $container = $(this).closest(".address-container");
    var autocomplete = new google.maps.places.Autocomplete(this, options);

    // Add listener for when a place is selected
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();

        const addressInfo = {
            zipCode: '',
            address: '',
            unitNumber: '',
            state: '',
            city: ''
        };

        // Extract and assign address components
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
                addressInfo.address += item.long_name + ' ';
            }
        });

        // Update the fields within the closest address container
        $container.find("input[name='zip']").val(addressInfo.zipCode);
        $container.find("input[name='address']").val(addressInfo.address.trim());
        $container.find("input[name='unit']").val(addressInfo.unitNumber);
        $container.find("input[name='state']").val(addressInfo.state);
        $container.find("input[name='city']").val(addressInfo.city);
    });
});


const phoneInputs = document.querySelectorAll(".phone");
var intlTelInputs = {};

phoneInputs.forEach(function (input) {
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
});

function checkError(field) {
    let errors = 0;

    if (field.length >= 1) {
        field.each(function () {
            const value = $(this).val().trim();
            const fieldName = $(this).attr('name');
            // Clear previous error state
            $(this).removeClass('error is-invalid');
            $(this).closest('.form-group').find('.invalid-feedback').hide();
            // Check for specific field validations
            switch (fieldName) {
                case 'email':
                    if (!isValidEmail(value)) {
                        $(this).addClass('error is-invalid');
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
                        $(this).closest('.form-group').find('.invalid-feedback').text(msg).show();

                        $(this).addClass('error is-invalid');
                        errors++;
                    }
                    break;
                default:
                    if (!value) {
                        $(this).addClass('error is-invalid');
                        errors++;
                    }
            }
        });
    }

    return errors === field.length;
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

$(document).ready(() => {
    let pickup_original_amount = $('#original_amount').val();
    let pickup_tax = $('#tax').val();
    let pickup_amount = $('#amount').val();

    $('.choose_address').on('click', () => {
        $('.address_block').hide();
        $('.address_list').show();
    })

    $(document).on('click', '.create_order_address', function () {
        $('#address_modal').modal('show');
    })

    $('#address_modal').on('hidden.bs.modal', function () {
        $('.order_new_address_form').trigger("reset");
    });

    $(document).on('click', '.edit-address-link', function () {
        const addressData = $(this).data('address');
        const modal = $('#address_modal');

        modal.find('input[name="first_name"]').val(addressData.first_name || '');
        modal.find('input[name="last_name"]').val(addressData.last_name || '');
        modal.find('input[name="email"]').val(addressData.email || '');
        modal.find('input[name="company"]').val(addressData.company || '');
        modal.find('input[name="phone"]').val(addressData.phone || '');
        modal.find('input[name="address"]').val(addressData.address || '');
        modal.find('input[name="unit"]').val(addressData.unit || '');
        modal.find('input[name="zip"]').val(addressData.zip || '');
        modal.find('input[name="city"]').val(addressData.city || '');
        modal.find('input[name="state"]').val(addressData.state || '');

        modal.find('#default_address').prop('checked', addressData.default === 1);

        modal.find('.address_id').val(addressData.id)
        modal.modal('show');
    });

    $(document).on('submit', '.order_new_address_form', function (e) {
        e.preventDefault();

        let errors = 0;

        const fieldArray = [
            $('.order_new_address_form input[name=first_name]'),
            $('.order_new_address_form input[name=last_name]'),
            $('.order_new_address_form input[name=email]'),
            $('.order_new_address_form input[name=phone]'),
            $('.order_new_address_form input[name=address]'),
            $('.order_new_address_form input[name=zip]'),
            $('.order_new_address_form input[name=city]'),
            $('.order_new_address_form input[name=state]')
        ];

        fieldArray.forEach(elem => {
            if (elem) {
                errors += checkError(elem);
            }
        })

        let formData = new FormData(this);
        let address_id = $('.order_new_address_form input[name=address_id]').val();
        let url = address_id ? `/profile/addresses/update/${address_id}` : "/order-add-address";
        if (!errors) {
            $.ajax({
                type: "POST",
                url: url,
                success: function (data) {
                    if (data.status) {
                        if(address_id){
                            window.location.reload();
                            return;
                        }
                        $('.profile_address').removeClass('selected');
                        if(data.address.default){
                            $('.profile_address').removeClass('default-address');
                        }
                        let response = `<div class="profile_address comp-address-book-card-container selected ${data.address.default ? 'default-address' : ''}"
                            data-id="${data.address.id}">
                                <div class="address-book-card-body">
                                    <span class="check-circle-icon fa fa-check-circle"></span>
                                    <div tabindex="0" class="address-info">
                                        ${
                                            data.address.default ?
                                            `<div class="default-address-label">
                                                            <span class="default-address-icon dri-lyons dri-star-solid">
                                                                <i class="fa-solid fa-star"></i>
                                                            </span>
                                                                Preferred Address
                                                            </div>`
                                            : ""
                                        }
                                        <div class="address-item company-info">${data.address.first_name} ${data.address.last_name}</div><br>
                                        <div class="address-item company-info">${data.address.company}</div><br>
                                        <div class="address-item">${data.address.address} </div>
                                        <div class="address-item">${data.address.city}, ${data.address.state} ${data.address.zip}</div>
                                        <div class="address-item">${data.address.phone}</div>
                                    </div>
                                    <a href="javascript:void(0)" data-address='${JSON.stringify(data.address)}' class="edit-address-link site-secondary-link-italic"> Edit </a>
                                </div>
                            </div>`;
                            $('.customer-addresses-container').append(response);

                        $('.address_id').val(data.address.id)
                        $('.order_new_address_form').trigger("reset")
                        $('#address_modal').modal('hide');
                    }
                },
                async: true,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 60000
            });
        }
    })

    $(document).on('click', '.profile_address', function () {
        $('.profile_address').removeClass('selected')
        $(this).addClass('selected')
        $('#user_checkout_form .address_id').val($(this).attr('data-id'))
    })

    $('input[name="shipping_method_type"]').change(function (e) {
        let value = this.value;

        if(value === 'pickup'){
            $('.shipping-cart-and-rates-container.pickup').show();
            $('.shipping-method-container .pickup').show();

            $('.shipping-cart-and-rates-container.shipping').hide();
            $('.shipping-method-container .shipping').hide();
            $('.checkout-btn').prop('disabled', false);

            price_block_update(pickup_original_amount, 0, pickup_tax, pickup_amount);
        }else if (value === 'shipping'){
            let address_id = $(".address_id").val();
            if(!address_id){
                Swal.fire({
                    text: "For shipping, you need to add an address.",
                    icon: "warning",
                    confirmButtonColor: "#3474d4",
                    confirmButtonText: "Ok"
                }).then(() => {
                    $('input[name="shipping_method_type"][value="pickup"]').prop('checked', true).trigger('change');
                });
            }else if(onlyPickup.length){
                Swal.fire({
                    title: "Pickup-Only Products Detected",
                    text: "Some products can only be picked up. Do you want to proceed without them, or return to the basket?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Continue",
                    cancelButtonText: "Go Back to Basket",
                    confirmButtonColor: "#3474d4",
                    cancelButtonColor: "#d33"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.shipping-cart-and-rates-container.pickup').hide();
                        $('.shipping-method-container .pickup').hide();

                        $('.shipping-cart-and-rates-container.shipping').show();
                        $('.shipping-method-container .shipping').show();

                        $('.checkout-btn').prop('disabled', true);
                        shipping_calculation(e);
                    } else {
                        window.location.href = "/basket/index";
                    }
                });
            }
            else{
                $('.shipping-cart-and-rates-container.pickup').hide();
                $('.shipping-method-container .pickup').hide();

                $('.shipping-cart-and-rates-container.shipping').show();
                $('.shipping-method-container .shipping').show();

                $('.checkout-btn').prop('disabled', true);

                shipping_calculation(e);
            }
        }
    });

    function shipping_calculation(e){
        e.preventDefault()

        const data = $('#user_checkout_form').serializeArray();
        const body = {};
        data.push({name:'address_id', 'value':$(".address_id").val()});
        data.push({name:'no_pickup', 'value':1});
        for (const dataElement of data) {
            body[dataElement.name] = dataElement.value
        }

        const loadingSpinner = `<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>`
        $('.shipping-cart-and-rates-container.shipping .comp-shipping-options-column-container').html(loadingSpinner)

        $.ajax({
            type: "POST",
            url: 'shipping/calculation',
            data: body,
            dataType: 'json',
            success: (data) => {
                $('.shipping-rate-container .comp-shipping-options-column-container').html(data.view)
            }
        });
    }

    function price_block_update(original_amount, shipping, tax, amount){
        $('input[name="original_amount"]').val(original_amount);
        $('input[name="shipping_price"]').val(shipping);
        $('input[name="tax"]').val(tax);
        $('input[name="amount"]').val(amount);

        $('.original_amount').html(original_amount);
        $('.shipping_price').html(shipping);
        $('.tax').html(tax);
        $('.amount').html(amount);
    }

    $(document).on('click', '.shipping-rates .shipping-column-group', function () {
        const $clicked = $(this);
        const index = $clicked.index();
        let is_mobile = $clicked.hasClass('shipping-column-group-mobile-container');
        let totalShippingPrice = 0;
        let totalTax = 0;
        let totalAmount = 0;

        if(is_mobile) {
            $('.shipping-rates .shipping-column-group').removeClass('selected');
            $('.shipping-column-group-mobile').removeClass('selected');

            $clicked.addClass('selected');
            $clicked.find('.shipping-column-group-mobile').addClass('selected');

            $clicked.find('.shipping-column-group-mobile.selected').each(function () {
                const $block = $(this);
                const selectedData = $block.data();
                let eachProjectOriginalAmount = parseFloat(selectedData.originalPrice) || 0;

                const shippingPrice = parseFloat(selectedData.price) || 0;
                const taxRate = parseFloat(selectedData.tax) || 0;

                const tax = eachProjectOriginalAmount * taxRate;

                totalShippingPrice += shippingPrice;
                totalTax += tax;
            });
        }else{
            $('.shipping-rates').each(function () {
                $(this).children('.shipping-column-group')
                    .removeClass('selected')
                    .eq(index)
                    .addClass('selected');

                const $selected = $(this).find('.shipping-column-group.selected');

                const eachProjectOriginalAmount = parseFloat( $(this).closest('.shipping-option-column-container').data('original-price')) || 0;

                if ($selected.length) {
                    const selectedData = $selected.data();

                    const shippingPrice = parseFloat(selectedData.price) || 0;
                    const taxRate = parseFloat(selectedData.tax) || 0;

                    const tax = eachProjectOriginalAmount * taxRate;

                    totalShippingPrice += shippingPrice;
                    totalTax += tax;
                }
            });
        }

        const original_amount = parseFloat($("#original_amount").val()) || 0;
        totalAmount = original_amount + totalShippingPrice + totalTax;

        totalShippingPrice = totalShippingPrice.toFixed(2);
        totalTax = totalTax.toFixed(2);
        totalAmount = totalAmount.toFixed(2);


        price_block_update(original_amount, totalShippingPrice, totalTax, totalAmount);

        $('.checkout-btn').prop('disabled', false);

    });

    $(document).on('keypress', '.card_no', function (e) {
        if (e.keyCode >= 48 && e.keyCode <= 57 && this.value.length < 19) {
            this.value = this.value.replace(/\W/g, '').replace(/(\d{4})/g, '$1 ').trim();
        } else {
            e.preventDefault();
        }
    });
    $(document).on('blur', '.exp_month', function (e) {
        this.value = this.value.replace(/^0+(?!\d)/g, '');
        // Validate the month
        const validMonthRegex = /^(0[0-9]|1[0-2])$/g;
        if (!validMonthRegex.test(this.value)) {
            this.value = '';
        }
    });
    $(document).on('blur', '.exp_year', function (e) {

        const currentYear = new Date().getFullYear();

        // Parse the input value as an integer
        const enteredYear = parseInt(this.value, 10);

        if (isNaN(enteredYear) || enteredYear < currentYear) {
            this.value = '';
        }
    });

    $(document).on('blur', '.cvc', function (e) {
        const cvvPattern = /^[0-9]{3,4}$/;
        if (!cvvPattern.test(this.value)) {
            this.value = '';
        }
    });

    $(document).on('click', '.credit-card', function() {
        // Check if the clicked card is already selected
        if ($(this).hasClass('selected')) {
            // Remove 'selected' class and hide the icon
            $(this).removeClass('selected');
            $(this).find('.credit-card-selected').addClass('hidden');
        } else {
            // Remove 'selected' class and hide the icon from all cards
            $('.credit-card').removeClass('selected');
            $('.credit-card .credit-card-selected').addClass('hidden');

            // Add 'selected' class and show the icon on the clicked card
            $(this).addClass('selected');
            $(this).find('.credit-card-selected').removeClass('hidden');
        }
    });

    $(document).on('change', 'input[name="payment_type"]', function (){
        let type = $(this).val();

        if(type === 'stripe'){
            $('#paymentNewProfile').removeClass('collapse');
        }else{
            $('#paymentNewProfile').addClass('collapse');

            $('html, body').animate({
                scrollTop: $('#paymentNewProfile').offset().top - 20
            }, 500);
        }
    })


})