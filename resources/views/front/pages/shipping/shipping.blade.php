@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/assets/css/checkout.css') }}"/>
    <link rel="stylesheet" href="{{ asset('front/assets/css/shopping_cart.css') }}"/>
@endpush

@section('content')
    <section class="ec-page-content cart_container">
        <div class="container">
            <form class="shipping-address-form ng-touched ng-dirty show-validations ng-valid" method="POST" id="user_checkout_form"
            action="{{route('order_shipping.show_payment_form')}}">
                @csrf
                <div class="flow-checkout-container page-shipping-container container">
                    <div class="left_side col-xs-12 col-sm-12 col-md-8">
                        <div class="comp-step-tracker-container">
                            <div class="site-step-item-container active">
                                <div class="site-step-count">
                                    <img src="{{asset('front/assets/images/checkout/step1-active.svg')}}">
                                </div>
                                <div class="site-step-label shipping-step-label"><span>Shipping</span></div>
                            </div>
                            <div class="connector"></div>
                            <div class="site-step-item-container">
                                <div class="site-step-count">
                                    <img src="{{asset('front/assets/images/checkout/step2.svg')}}">
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
                                <h1 class="page-title">Shipping Information </h1>
                            </div>
                        </div>
                        <div class="shipping-address-container">
                            <div class="comp-shipping-address-container">
                                <div id="comp_new_address_form_container" class="comp-new-address-form-container">
                                    <div>
                                        <div class="comp-address-form-container">

                                            <input type="hidden" class = "shipping_provider_id" name="shipping_provider_id" value="">

                                            <input type="hidden" class = "shipping_provider" name="shipping_provider" value="">
                                            <input type="hidden" class="shipping_price" name="shipping_price" value="0">
                                            <input type="hidden" name="address_id" class="address_id" value="">
                                            <input type="hidden" name="projects_ids" class="project_ids" value="{{json_encode($projects)}}">
                                            <div class="shipping_address">
                                                @auth
                                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                                @endauth
                                                <div class="address_list mt-3">
                                                    <div class="shipping-address-container">

                                                        @auth
                                                        <?php $addresses = auth()->user()->addresses; ?>
                                                            <div class="shipping-address">
                                                                <div class="comp-shipping-address-container">
                                                                    <div class="comp-customer-address-book-container">
                                                                        <div class="customer-addresses-container">
                                                                            @foreach($addresses as $address)
                                                                                <div class="profile_address comp-address-book-card-container {{$address->default ? 'selected default-address' : ''}}"
                                                                                data-id="{{$address->id}}">
                                                                                    <div class="address-book-card-body">
                                                                                        <span class="check-circle-icon fa fa-check-circle"></span>
                                                                                        <div tabindex="0" class="address-info">
                                                                                            <div class="default-address-label">
                                                                                                <span class="default-address-icon dri-lyons dri-star-solid">
                                                                                                    <i class="fa-solid fa-star"></i>
                                                                                                </span>
                                                                                                Preferred Address
                                                                                            </div>
                                                                                            <div class="address-item company-info">{{$address->first_name}} {{$address->last_name}}</div><br>
                                                                                            <div class="address-item company-info">{{$address->company}}</div><br>
                                                                                            <div class="address-item">{{$address->address}} </div>
                                                                                            <div class="address-item">{{$address->city}}, {{$address->state}} {{$address->zip}}</div>
                                                                                            <div class="address-item">{{$address->phone}}</div>
                                                                                        </div>
                                                                                        <a href="javascript:void(0)" data-address='@json($address)' class="edit-address-link site-secondary-link-italic"> Edit </a>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="address-book-actions-container">
                                                                            <div class="new-address-btn-container">
                                                                                <a href="javascript:void(0)" class="add-new-address-button create_order_address site-btn-icon-tertiary btn btn-outline-primary">
                                                                                    <i class="fa-solid fa-plus"></i>
                                                                                    ADD NEW ADDRESS
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endauth
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                            <span id="disp_printing_sub_total" class="price-value"> $<span class="original_amount">{{$total_price}}</span> </span>
                                            <input type="hidden" id="original_amount" name="original_amount" value="{{$total_price}}">
                                        </li>
                                        <li class="price-group shipping-price-details list-group-item comp-inline-discount-price-container">
                                            <span class="price-label clearfix"> Shipping &amp; Handling </span>
                                            <span id="disp_estimated_shipping" class="price-value"> $<span class="shipping_price">0</span> </span>
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
                                            <span id="disp_total_amount" class="price-value"> $<span class="amount">{{$total_amount}}</span> </span>
                                            <input type="hidden" id="amount" name="amount" value="{{$total_amount}}">
                                        </li>
                                    </ul>
                                    <div class="checkout-btn-container">
                                        <button class="checkout-btn site-btn-primary-semi-bold btn btn-primary">
                                            <span class="checkout-btn-label"> CONTINUE TO BILLING</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flow-checkout-container page-shipping-container container d-flex flex-column">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-12">
                        <div class="shipping-address-container">
                            <div class="comp-shipping-address-container">
                                <div id="comp_new_address_form_container" class="comp-new-address-form-container">
                                    <div>
                                        <div class="comp-address-form-container">
                                            <div class="shipping-options-container">
                                                <div class="select-shipping-options-container">
                                                    <label class="site-custom-radio radio-label-wrapper shipping-option-delivery-container">
                                                        <input type="radio" name="shipping_method_type" value="pickup"
                                                               class="option-radio-input ng-valid ng-dirty ng-touched" checked>
                                                        <div class="shipping-radio-label-container">
                                                            <span class="radio-icon-override"></span>
                                                            <span class="radio-label shipping-option-label">Pickup</span>
                                                        </div>
                                                    </label>
                                                    <label class="site-custom-radio radio-label-wrapper shipping-option-delivery-container">
                                                        <input type="radio" name="shipping_method_type" value="shipping"
                                                               class="option-radio-input ng-valid ng-dirty ng-touched">
                                                        <div class="shipping-radio-label-container">
                                                            <span class="radio-icon-override"></span>
                                                            <span class="radio-label shipping-option-label">Delivery</span>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="shipping-method-container">
                                                    <div class="shipping">
                                                        <div class="shipping-section-heading">
                                                            <div class="heading-container">
                                                                <div class="heading-text ng-star-inserted">
                                                                    <span>Choose Estimated Delivery Dates</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pickup">
                                                        <div class="shipping-section-heading">
                                                            <div class="heading-container">
                                                                <div class="heading-text ng-star-inserted">
                                                                    <span>Pickup Information</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="shipping-cart-and-rates-container pickup pick ng-star-inserted">
                                                    <div class="pickup_section">
                                                        <div class="pickup_left">
                                                            <div class="pickup_address_block">
                                                                <p class="pickup_address">{{ setting('address') }}</p>
                                                                <a href="{{ setting('map_link') }}" class="pickup_direction"
                                                                   target="_blank">Get Direction</a>
                                                            </div>
                                                            <div class="pickup_heading">Hours Of Operation</div>
                                                            <div class="pickup_working_days">
                                                                <span>
                                                                    <span class="text-bold">Monday </span>9:00AM - 6:00PM
                                                                </span>
                                                                <span>
                                                                    <span class="text-bold">Tuesday </span>9:00AM - 6:00PM
                                                                </span>
                                                                <span>
                                                                    <span class="text-bold">Wednesday </span>9:00AM - 6:00PM
                                                                </span>
                                                                <span>
                                                                    <span class="text-bold">Thursday </span>9:00AM - 6:00PM
                                                                </span>
                                                                <span>
                                                                    <span class="text-bold">Friday </span>9:00AM - 6:00PM
                                                                </span>
                                                                <span>
                                                                    <span class="text-bold">Saturday </span>Closed
                                                                </span>
                                                                <span>
                                                                    <span class="text-bold">Sunday </span>Closed
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="pickup_map">
                                                            <iframe
                                                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3299.370806978807!2d-118.45333039999998!3d34.213549199999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2976c67c9d12d%3A0x1a077e43c00e9e3c!2sYans%20Print!5e0!3m2!1sen!2s!4v1671570250290!5m2!1sen!2s"
                                                                    width="100%" height="300" style="border:0;" allowfullscreen=""
                                                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="shipping-cart-and-rates-container shipping ng-star-inserted">
                                                    <div class="shipping-rate-container">
                                                        <div class="ng-star-inserted">
                                                            <div class="comp-shipping-options-column-container">
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
                    <div class="col-12 mb-5">
                        <div class="shipping-actions-container hidden-xs hidden-sm">
                            <div class="return-to-cart-link-container col">
                                <a class="return-to-cart-link site-secondary-link-italic" href="{{route('basket.index')}}">
                                    <span aria-hidden="true">&lt;</span>
                                    <span> Return to Cart</span>
                                </a>
                            </div>
                            <div class="checkout-btn-container col-xs-8 col-sm-5 col-md-5 col-lg-3">
                                <button class="checkout-btn site-btn-primary-semi-bold btn btn-primary">
                                    <span class="checkout-btn-label"> CONTINUE TO BILLING</span>
                                </button>
                            </div>
                        </div>
                        <div class="hidden-lg">
                            <div class="order-summary-container">
                                <span class="order-summary-header-label"> Order Summary </span>
                                <div class="app-order-summary">
                                    <div class="comp-order-summary-container">
                                        <ul class="site-list-group list-group order-summary-details-list">
                                            <li class="price-group order-subtotal-details list-group-item">
                                                <span class="price-label"> Printing Cost </span>
                                                <span id="disp_printing_sub_total" class="price-value"> $<span class="original_amount">{{$total_price}}</span> </span>
                                                <input type="hidden" name="original_amount" value="{{$total_price}}">
                                            </li>
                                            <li class="price-group shipping-price-details list-group-item comp-inline-discount-price-container">
                                                <span class="price-label clearfix"> Shipping &amp; Handling </span>
                                                <span class="price-value"> $<span class="shipping_price">0</span> </span>
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
                                                <span class="price-value"> $<span class="amount">{{$total_amount}}</span> </span>
                                                <input type="hidden" name="amount" value="{{$total_amount}}">
                                            </li>
                                        </ul>
                                        <div class="checkout-btn-container col-12 mb-3">
                                            <button class="checkout-btn site-btn-primary-semi-bold btn btn-primary">
                                                <span class="checkout-btn-label"> CONTINUE TO BILLING</span>
                                            </button>
                                        </div>
                                        <div class="shipping-actions-container mb-3">
                                            <div class="return-to-cart-link-container col d-flex justify-content-center">
                                                <a class="return-to-cart-link site-secondary-link-italic" href="{{route('basket.index')}}">
                                                    <span aria-hidden="true">&lt;</span>
                                                    <span> Return to Cart</span>
                                                </a>
                                            </div>
                                        </div>
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
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDn1gU-9ENcDEK5IsuwJNVgrtqnwRHddMc&country=US&sensor=false&libraries=places&language=en-AU"></script>
    <script src="{{ asset('front/assets/js/order.js') }}"></script>
    <script>
        var calculateShipmentPricesUrl = "{{ route('calculateShipmentPrices') }}";
        var onlyPickup = {{json_encode($onlyPickup)}};
        $(document).ready(function (){
            let address_id = $('.profile_address.selected').data('id');
            if(address_id){
                $('#user_checkout_form .address_id').val(address_id);
            }
        })
    </script>
@endpush