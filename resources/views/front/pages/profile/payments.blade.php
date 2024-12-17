@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/payment.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/checkout.css') }}">
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
                                    <div class="ec-vendor-block-profile cards_list">
                                        <h5>Saved Cards</h5>
                                        <div class="d-flex flex-wrap gap-3 align-items-center justify-content-start">
                                            @if(count($cards))
                                                @foreach($cards as $card)
                                                    <div>
                                                        <!-- Visa - selectable -->
                                                        <div class="credit-card {{$card['brand']}} selectable {{$card['default_card'] ? 'selected' : ''}}"
                                                             data-id="{{$card['id']}}">
                                                            <div class="credit-card-selected profile {{$card['default_card'] ? '' : 'hidden'}}">
                                                                <i class="fa-solid fa-check"></i>
                                                            </div>
                                                            <div class="credit-card-last4">
                                                                {{$card['last4']}}
                                                            </div>
                                                            <div class="credit-card-expiry">
                                                                {{$card['exp_month']}}/{{$card['exp_year']}}
                                                            </div>
                                                            <div class="credit-card-delete">
                                                                <i class="fa-regular fa-trash-can delete_card" onclick="deleteCard(event, '{{$card['id']}}')"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="add_card_block">
                                                <div class="add_card_sign">
                                                    <i class="fa-solid fa-plus"></i>
                                                    <span>Add New Card</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form class="ec-vendor-block-profile add_card_form stripe_inputs" method="post" action="{{route('profile.store_card')}}">
                                        <div class="row flex-wrap">
                                            @csrf
                                            <div class="col-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Card Number<span class="required-field">*</span></label>
                                                    <input name="card_no" type="text" class="form-control card_no">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Exp. Month<span class="required-field">*</span></label>
                                                    <input name="exp_month" type="number" class="form-control exp_month">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Exp. Year<span class="required-field">*</span></label>
                                                    <input name="exp_year" type="number" class="form-control exp_year">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">CVC<span class="required-field">*</span></label>
                                                    <input name="cvc" type="number" class="form-control cvc">
                                                </div>
                                            </div>
                                            <div class="d-grid my-4">
                                                <button class="btn btn-primary add_card_btn">Add Card</button>
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
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('front/assets/js/demo-8.js') }}"></script>
    <script>
        Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        @if (session('error'))
            showError('{{ session('error') }}');
        @endif

        function showError(message) {
            Toast.fire({
                icon: 'error',
                title: message
            });
        }

        function deleteCard(e, id){
            e.stopPropagation();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3474d4",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'card/delete',
                        data: {'id': id},
                        dataType: 'json',
                        encode: true
                    })
                        .done(function (response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your card has been deleted.",
                                icon: "success",
                                confirmButtonColor: "#3474d4",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        })
                        .fail(function (xhr, textStatus, errorThrown) {
                            console.error(xhr.responseText);
                        });
                }
            });
        }

        $(document).ready(function() {
            $('.credit-card').on('click', function(e) {
                e.stopPropagation();
                // Remove 'selected' class and icon from all cards
                $('.credit-card').removeClass('selected');
                $('.credit-card .credit-card-selected').addClass('hidden');

                // Add 'selected' class and show icon on the clicked card
                $(this).toggleClass('selected');
                if ($(this).hasClass('selected')) {
                    $(this).find('.credit-card-selected').removeClass('hidden');
                } else {
                    $(this).find('.credit-card-selected').addClass('hidden');
                }

                const cardId = $(this).data('id');

                $.ajax({
                    url: 'card/update-default-card',
                    type: 'POST',
                    data: {
                        id: cardId
                    },
                    success: function(response) {
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });
                    },
                });
            });

            $('.add_card_block').on('click', ()=>{
                $('.cards_list').hide();
                $('.add_card_form').show();

            })
            $('.add_card_form').on('submit', function(e) {
                e.preventDefault();
                let errors = 0;

                const fields = [
                    $('[name=card_no]'),
                    $('[name=exp_month]'),
                    $('[name=exp_year]'),
                    $('[name=cvc]')
                ];

                // Loop through each field for validation
                fields.forEach(field => {
                    const value = field.val().trim();
                    const fieldName = field.attr('name');
                    // Clear previous error state
                    field.removeClass('error is-invalid');
                    field.closest('.form-group').find('.invalid-feedback').hide();
                    // Check for specific field validations
                    if (!value) {
                        field.addClass('error is-invalid');
                        field.closest('.form-group').find('.invalid-feedback').show();
                        errors++;
                    }
                });

                if (!errors) {
                    this.submit();
                }
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
        });
    </script>
@endpush
