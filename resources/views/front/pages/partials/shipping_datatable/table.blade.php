<div class="large_screen">
    <div class="shipping-option-column-container header ng-star-inserted">
        <div class="cart-item-details"></div>
        <div class="shipping-rates">
            @foreach ($deliveryTypeTotals as $deliveryType => $data)

                <div class="shipping-column-group has-border-top ng-star-inserted">
                    <span class="check-circle-icon fa fa-check-circle ng-star-inserted"></span>
                    <div class="price-label-container">
                        <div class="option-price-container ng-star-inserted">
                            <div class="service-transit"> {{$deliveryType}}</div>
                            <div class="price-container">
                                ${{$data}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    @php $index = 0; @endphp
    @foreach ($matrix as $product_is => $data)
        <div class="shipping-option-column-container ng-star-inserted" data-original-price="{{$data['project']->original_amount}}">
            <div class="cart-item-details">
                <div>
                    <div class="cart-item">
                        <div class="file-preview ng-star-inserted">
                            <div>
                                <div class="comp-order-summary-item-file-preview-container">
                                    <div class="item-preview-details-container ng-star-inserted">
                                        <div class="preview-unavailable">
                                            <img class="blank-image" src="{{asset('front/assets/images/no-image-preview.png')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-item-description">
                            <div class="proj-name">{{$data['project']->product->title}}</div>
                            <div class="qty">Quantity: {{$data['project']->qty}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shipping-rates">
                @foreach($allDeliveryTypes as $key => $type)
                    @php
                        $provider_id = null;
                        $provider_name = null;
                        $price = '';
                        $tax_rate = null;

                        if(isset($data[$type])){
                            $price = $data[$type]['price'];
                            $provider_name = $data[$type]['provider'];
                            $provider_id = $data[$type]['provider_id'];
                            $tax_rate = $data[$type]['tax_rate'];
                        }
                    @endphp
                    <div class="shipping-column-group ng-star-inserted {{$index == count($matrix)-1 ? 'has-border-bottom' : ''}}"
                         data-id="{{$provider_id}}" data-price="{{$price}}" data-name="{{$provider_name}}" data-tax="{{$tax_rate}} ">
                        <div class="delivery-dates-container  {{$index != count($matrix)-1 ? 'has-border-bottom' : ''}}">
                            <div class="dates-wrapper">
                                <span class="date-container">${{$price}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @php $index++; @endphp
    @endforeach
</div>

<div class="mobile_screen">
    @foreach ($matrix as $product_is => $data)
        <div class="shipping-option-column-container ng-star-inserted" data-original-price="{{$data['project']->original_amount}}">
            <div class="cart-item-details">
                <div>
                    <div class="cart-item">
                        <div class="file-preview ng-star-inserted">
                            <div>
                                <div class="comp-order-summary-item-file-preview-container">
                                    <div class="item-preview-details-container ng-star-inserted">
                                        <div class="preview-unavailable">
                                            <img class="blank-image" src="{{asset('front/assets/images/no-image-preview.png')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-item-description">
                            <div class="proj-name">{{$data['project']->product->title}}</div>
                            <div class="qty">Quantity: {{$data['project']->qty}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="mobile_delivery_type">
        @foreach($allDeliveryTypes as $key => $type)

            <div class="shipping-option-column-container ng-star-inserted">
                <div class="shipping-rates">
                    <div class="shipping-column-group shipping-column-group-mobile-container  has-border-top has-border-bottom ng-star-inserted">
                        <span class="check-circle-icon fa fa-check-circle ng-star-inserted"></span>
                        <div class="price-label-container">
                            <div class="option-price-container ng-star-inserted">
                                <div class="service-transit"> {{$type}}</div>
                                <div class="price-container">
                                    ${{$deliveryTypeTotals[$type]}}
                                </div>
                            </div>
                        </div>
                        @foreach ($matrix as $product_is => $data)
                            @php
                                $provider_id = null;
                                $provider_name = null;
                                $price = '';
                                $tax_rate = null;

                                if(isset($data[$type])){
                                    $price = $data[$type]['price'];
                                    $provider_name = $data[$type]['provider'];
                                    $provider_id = $data[$type]['provider_id'];
                                    $tax_rate = $data[$type]['tax_rate'];
                                }
                            @endphp
                            <div class="shipping-column-group-mobile ng-star-inserted" data-original-price="{{$data['project']->original_amount}}"
                                 data-id="{{$provider_id}}" data-price="{{$price}}" data-name="{{$provider_name}}" data-tax="{{$tax_rate}} ">
                                <div class="delivery-dates-container">
                                    <div class="dates-wrapper">
                                        <span class="date-container">${{$price}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
