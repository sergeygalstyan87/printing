@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/assets/css/checkout.css') }}"/>
    <link rel="stylesheet" href="{{ asset('front/assets/css/shopping_cart.css') }}"/>
@endpush

@section('content')
    <section class="ec-page-content cart_container">
        <div class="container">
            <form class="shipping-address-form ng-touched ng-dirty show-validations ng-valid" method="POST"
                  id="user_payment_form"
                  action="">
                @csrf
                <div class="flow-checkout-container page-payment-container container">
                    <div class="left_side col-xs-12 col-sm-12 col-md-8">
                        <div class="comp-step-tracker-container">
                            <div class="site-step-item-container finished">
                                <div class="site-step-count">
                                    <img src="{{asset('front/assets/images/checkout/step-done.svg')}}">
                                </div>
                                <div class="site-step-label shipping-step-label"><span>Shipping</span></div>
                            </div>
                            <div class="connector finished"></div>
                            <div class="site-step-item-container active">
                                <div class="site-step-count">
                                    <img src="{{asset('front/assets/images/checkout/step2-active.svg')}}">
                                </div>
                                <div class="site-step-label billing-step-label"><span>Billing</span></div>
                            </div>
                            <div class="connector"></div>
                            <div class="site-step-item-container">
                                <div class="site-step-count">
                                    <img src="{{asset('front/assets/images/checkout/step3.svg')}}">
                                </div>
                                <div class="site-step-label confirmation-step-label"><span>Receipt</span></div>
                            </div>
                        </div>
                        <div class="page-heading-container">
                            <div>
                                <h1 class="page-title">Payment Options </h1>
                            </div>
                        </div>
                        <div class="payment-options-container">
                            <span class="payment-method-heading">Choose Payment Method</span>
                            <div class="payment-method-container">
                                <div>
                                    <div class="comp-new-payment-profile-container active">
                                        <div class="payment-radio-group selected-payment-profile">
                                            <label tabindex="0" id="credit-card-option"
                                                   class="site-custom-radio credit-card-label radio-label-wrapper">
                                                <div class="option-radio-new-payment-info-container">
                                                    <input type="radio" name="payment_type" tabindex="-1"
                                                           class="option-radio-input" value="stripe" id="stripe"
                                                           checked>
                                                    <span class="radio-icon-override"></span>
                                                    <div class="new-payment-profile-label-group active">
                                                        <span class="new-payment-profile-label">Credit Card</span>
                                                        <span class="cc-icons">
                                                                <img alt=""
                                                                     src="{{asset('front/assets/images/payment_system_logos/mastercard.svg')}}">
                                                                <img alt=""
                                                                     src="{{asset('front/assets/images/payment_system_logos/visa.svg')}}">
                                                                <img alt=""
                                                                     src="{{asset('front/assets/images/payment_system_logos/american-express.svg')}}">
                                                                <img alt=""
                                                                     src="{{asset('front/assets/images/payment_system_logos/discover.svg')}}">
                                                            </span>
                                                    </div>
                                                </div>
                                            </label>
                                            <div id="paymentNewProfile">
                                                <div class="new-payment-profile-form">
                                                    <div id="payment_form">
                                                        <div class="stripe_inputs">
                                                            <div class="row show_card_info">
                                                                @if(auth()->user())
                                                                    @include('front.partials.card_view', ['cards' => auth()->user()->getSavedCards()])
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label">Card Number<span
                                                                                    class="required-field">*</span></label>
                                                                        <input name="card_no" type="text"
                                                                               class="form-control card_no">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label">Exp. Month<span
                                                                                    class="required-field">*</span></label>
                                                                        <input name="exp_month" type="number"
                                                                               class="form-control exp_month">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label">Exp. Year<span
                                                                                    class="required-field">*</span></label>
                                                                        <input name="exp_year" type="number"
                                                                               class="form-control exp_year">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label">CVC<span
                                                                                    class="required-field">*</span></label>
                                                                        <input name="cvc" type="number"
                                                                               class="form-control cvc">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="comp-paypal-payment-container">
                                        <div class="payment-radio-group">
                                            <label tabindex="0" class="site-custom-radio radio-label-wrapper">
                                                <div class="option-radio-paypal-payment-info-container">
                                                    <input type="radio" id="paypal" name="payment_type" tabindex="-1"
                                                           class="option-radio-input" value="paypal">
                                                    <span class="radio-icon-override"></span>
                                                    <div class="paypal-payment-label-group">
                                                        <span class="paypal-payment-label"> PayPal </span>
                                                        <span class="paypal-logo-container">
                                                            <img alt="Paypal"
                                                                 src="{{asset('front/assets/images/payment_system_logos/paypal.svg')}}">
                                                        </span>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="checkout-btn-container">
                                        <button id="submitBtn" class="btn btn-primary">
                                            <span class="checkout-btn-label">PLACE ORDER</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right_side right-section-container col-xs-12 col-sm-12 col-md-3 hidden-sm">
                        <div class="order-summary-container">
                            <span class="order-summary-header-label"> Order Summary </span>
                            <div class="app-order-summary">
                                <div class="comp-order-summary-container">
                                    <ul class="site-list-group list-group order-summary-details-list">
                                        <li class="price-group order-subtotal-details list-group-item">
                                            <span class="price-label"> Printing Cost </span>
                                            <span id="disp_printing_sub_total" class="price-value"> $<span
                                                        class="original_amount">{{$total_price}}</span> </span>
                                            <input type="hidden" id="original_amount" name="original_amount"
                                                   value="{{$total_price}}">
                                        </li>
                                        <li class="price-group shipping-price-details list-group-item comp-inline-discount-price-container">
                                            <span class="price-label clearfix"> Shipping &amp; Handling </span>
                                            <span id="disp_estimated_shipping" class="price-value"> $<span
                                                        class="shipping_price">0</span> </span>
                                            <input type="hidden" id="shipping_price" name="shipping_price" value="0">
                                        </li>
                                        <li class="price-group tax-price-details list-group-item">
                                            <span class="price-label"> Tax </span>
                                            <span id="disp_tax" class="price-value"> $<span class="tax">{{$tax}}</span> </span>
                                            <input type="hidden" id="tax" name="tax" value="{{$tax}}">
                                        </li>
                                    </ul>
                                    <ul class="site-list-group list-group">
                                        <li class="estimated-total-details list-group-item">
                                            <span class="price-label"> Total:  </span>
                                            <span id="disp_total_amount" class="price-value"> $<span
                                                        class="amount">{{$total_amount}}</span> </span>
                                            <input type="hidden" id="amount" name="amount" value="{{$total_amount}}">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flow-checkout-container page-payment-container container d-flex flex-column">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-12">
                    </div>
                    <div class="col-12 mb-5">
                        <div class="hidden-lg">
                            <div class="order-summary-container">
                                <span class="order-summary-header-label"> Order Summary </span>
                                <div class="app-order-summary">
                                    <div class="comp-order-summary-container">
                                        <ul class="site-list-group list-group order-summary-details-list">
                                            <li class="price-group order-subtotal-details list-group-item">
                                                <span class="price-label"> Printing Cost </span>
                                                <span id="disp_printing_sub_total" class="price-value"> $<span
                                                            class="original_amount">{{$total_price}}</span> </span>
                                                <input type="hidden" name="original_amount" value="{{$total_price}}">
                                            </li>
                                            <li class="price-group shipping-price-details list-group-item comp-inline-discount-price-container">
                                                <span class="price-label clearfix"> Shipping &amp; Handling </span>
                                                <span class="price-value"> $<span
                                                            class="shipping_price">0</span> </span>
                                                <input type="hidden" name="shipping_price" value="0">
                                            </li>
                                            <li class="price-group tax-price-details list-group-item">
                                                <span class="price-label"> Tax </span>
                                                <span class="price-value"> $<span class="tax">{{$tax}}</span> </span>
                                                <input type="hidden" name="tax" value="{{$tax}}">
                                            </li>
                                        </ul>
                                        <ul class="site-list-group list-group">
                                            <li class="estimated-total-details list-group-item">
                                                <span class="price-label"> Total:  </span>
                                                <span class="price-value"> $<span
                                                            class="amount">{{$total_amount}}</span> </span>
                                                <input type="hidden" name="amount" value="{{$total_amount}}">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @include('front.pages.partials.basket.address_modal')

@endsection

@push('scripts')
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-md5@0.7.3/src/md5.min.js"></script>
    <script type="module" src="{{ asset('front/assets/js/custom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key=AIzaSyDn1gU-9ENcDEK5IsuwJNVgrtqnwRHddMc&country=US&sensor=false&libraries=places&language=en-AU"></script>
    <script src="{{ asset('front/assets/js/order.js') }}"></script>
    <script>
        var calculateShipmentPricesUrl = "{{ route('calculateShipmentPrices') }}";
        var onlyPickup = {{json_encode($onlyPickup)}};
        $(document).ready(function () {
            let address_id = $('.profile_address.selected').data('id');
            if (address_id) {
                $('#user_checkout_form .address_id').val(address_id);
            }
        })
    </script>
@endpush