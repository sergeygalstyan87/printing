@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/assets/css/shopping_cart.css') }}"/>
    <link rel="stylesheet" href="{{ asset('front/assets/css/uploadModal.css') }}"/>
@endpush

@php
    $totalOriginalAmount = empty($projects) ? 0 : $projects->sum('original_amount');
@endphp
@section('content')

    <section class="ec-page-content cart_container">
        <div class="container">
            <div class="row cart_title">
                <h1 class="page-title"> Shopping Cart </h1>
            </div>
            <div class="row">
                <div class="cart-content-container">
                    <form action="{{route('order_shipping.shipping')}}" method="POST" id="basket_form">
                        @csrf
                        <div class="cart-items-container">
                            @forelse($projects as $key => $project)
                                <div class="item-container">
                                    <div class="cart_item_block">
                                        <div class="header">
                                            <div class="project_title">
                                                {{$project->project_title}}
                                            </div>
                                            <div class="actions">
                                                <div class="edit-item-link itemEditLink">
                                                    <a href="#"
                                                         data-project-id="{{ $project->id }}"
                                                         data-product-slug="{{ $project->product->slug }}"
                                                         onclick="redirectToProduct(event, this)">
                                                        <i class="fa-solid fa-pencil"></i>
                                                        <span class="site-secondary-link-italic item-action-label"> Edit
                                                            <span class="hidden-xs"> Item</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="delete-item-link itemRemoveLink">
                                                    <a href="{{route('basket.removeItem', $project)}}">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                        <span class="site-secondary-link-italic item-action-label"> Remove
                                                            <span class="hidden-xs"> Item</span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cart_item_content">
                                            <div class="select_item form-check">
                                                <input class="form-check-input product-checkbox" checked type="checkbox" name="projects_ids[]" value="{{$project->id}}">
                                            </div>
                                            <div class="w-100">
                                                <div class="item-name-container">
                                                    <p class="site-paragraph-title-bold product-name-text">
                                                        {{$project->product->title}}
                                                    </p>
                                                </div>
                                                <div class="product-details-block">
                                                    <div class="product-details">
                                                        <div class="product-details-info-block">
                                                            <div class="product-details-info">
                                                                <img class="product_img"
                                                                     src="{{ asset('storage/content/' . $project->product->images[0]) }}"
                                                                     alt="">
                                                                <ul class="specs-list-group dynamic-specs-list-group">
                                                                    @foreach($project->attrs['types'] as $attr => $type)
                                                                        <li class="item-spec">
                                                                            <span class="site-paragraph-title-bold spec-name">{{$attr}}: </span>
                                                                            <span>{{$type}}</span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <ul class="specs-list-group">
                                                                    <li class="item-spec additional-spec">
                                                                        <span class="site-paragraph-title-bold spec-name">Quantity: </span>
                                                                        {{$project->qty}}
                                                                    </li>
                                                                    @if($project->delivery)
                                                                        <li class="item-spec additional-spec">
                                                                            <span class="site-paragraph-title-bold spec-name">Printing Time: </span>
                                                                            {{$project->delivery->title}}
                                                                        </li>
                                                                    @endif
                                                                    @if($project->product->shipping_info)
                                                                        <li class="item-spec additional-spec">
                                                                            <span class="site-paragraph-title-bold spec-name text-danger">Pickup & Shipping</span>
                                                                        </li>
                                                                    @else
                                                                        <li class="item-spec additional-spec">
                                                                            <span class="site-paragraph-title-bold spec-name text-danger">Pickup</span>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="cost_block">
                                                        <div class="item-price-container">
                                                            <span class="site-paragraph-title-bold spec-name">Price: </span>
                                                            <span>
                                                            @if(isset($project->attrs['old_per_set_price']))
                                                                    <span class="old_price text-danger" style="text-decoration: line-through;">${{number_format($project->attrs['old_per_set_price'], 2)}}</span>
                                                                @endif
                                                            <span class="item-price itemPrice"> ${{number_format($project->attrs['per_set_price'], 2)}} </span>
                                                        </span>
                                                        </div>
                                                        <div class="item-set-container">
                                                            <span class="site-paragraph-title-bold spec-name">Sets: </span>
                                                            <span class="sets"> {{$project->sets()->count()}} </span>
                                                        </div>
                                                        @if($project->type == 'Design Offer' && $project->product->design_price)
                                                            <div class="item-set-container">
                                                                <span class="site-paragraph-title-bold spec-name">Design Price: </span>
                                                                <span class="sets"> ${{number_format($project->attrs['design_price'], 2)}} </span>
                                                            </div>
                                                        @endif
                                                        <div class="item-set-container subtotal">
                                                            <div class="subtotal_price_block">
                                                                <p class="site-paragraph-title-bold spec-name">Subtotal:
                                                                    <span class="sets">
                                                                    @if(isset($project->attrs['old_price']))
                                                                            <span class="old_price text-danger" style="text-decoration: line-through;">${{number_format($project->attrs['old_price'], 2)}}</span>
                                                                        @endif
                                                                    <span class="new-price-discount text-danger" style="text-decoration: line-through;"></span>
                                                                    <span class="subtotal_price_per_item new-price" data-price="{{$project->original_amount}}">
                                                                        ${{number_format($project->original_amount, 2)}}
                                                                    </span>
                                                                </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="item-set-container copyItem">
                                                            <a href="{{route('basket.copyItem', $project)}}">
                                                            <span class="duplicate">
                                                                <i class="fa-regular fa-copy"></i>
                                                                Duplicate this item
                                                            </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion accordion-flush" id="accordionFlushExample_{{$key}}">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="flush-heading_{{$key}}">
                                                            <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#flush-collapse_{{$key}}" aria-expanded="false"
                                                                    aria-controls="flush-collapse_{{$key}}">
                                                                Sets
                                                            </button>
                                                        </h2>
                                                        <div id="flush-collapse_{{$key}}" class="accordion-collapse collapse"
                                                             aria-labelledby="flush-heading_{{$key}}"
                                                             data-bs-parent="#accordionFlushExample_{{$key}}">
                                                            <div class="accordion-body">
                                                                @foreach($project->sets as $set)
                                                                    <div class="set_container">
                                                                        <p>{{$set->set_title}}</p>
                                                                        <div class="basket_file_upload" data-bs-toggle="modal" data-bs-target="#uploadModal"
                                                                             data-set-id="{{json_encode($set->id)}}"
                                                                             data-type-ids="{{ json_encode($project->attrs['selected_values']) }}">

                                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                                            <span> Edit artwork</span>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="empty_message">
                                    <p>Your shopping cart is currently empty.</p>
                                    <a href="{{ route('home')}}" class="shop_btn">
                                        <button class="btn btn-primary text-bold" type="button">SHOP NOW</button>
                                    </a>
                                </div>
                            @endforelse
                        </div>
                        <div class="subtotal_block">
                            <div class="subtotal_block_items justify-content-end">
                                <div class="subtotal_price_block total_count">
                                    <p class="subtotal-label">Subtotal:
                                        <span>
                                            <span class="new-price-discount text-danger" style="text-decoration: line-through;"></span>
                                            <span class="new-price" data-price="{{$totalOriginalAmount}}">
                                                ${{number_format($totalOriginalAmount, 2)}}
                                            </span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="subtotal_block_items mt-4 mb-4">
                                <div class="checkout_btn_wrap">
                                    <a href="{{route('home')}}" class="btn btn-outline-primary"> CONTINUE SHOPPING </a>
                                </div>
                                <div id="checkout_btn_wrap">
                                    <input type="hidden" name="coupon_id" value="0"
                                           class="coupon_id">
                                    <input type="hidden" name="basket_id" value="{{$basketId}}">
                                    <button class="checkout-btn btn btn-primary" type="submit"> CHECKOUT NOW </button>
                                </div>
                            </div>
                            <div class="ec-single-stoke">
                                <span class="coupon-toggle-link ">
                                    Have a Gift Certificate or Code?
                                </span>
                                <div class="comp-coupon-section-container coupon_form">
                                    <div class="coupon-input-group">
                                        <div class="site-input-group">
                                            <input type="text" placeholder="Enter Promo Code" name="coupon"
                                                   maxlength="50"
                                                   class="site-form-input name-input form-control coupon_name">
                                        </div>
                                        <button class="btn btn-outline-primary" type="button" id="apply_coupon_code" data-url="{{ route('coupon') }}">
                                            REDEEM
                                        </button>
                                    </div>
                                    <div id="coupon-code-message" >
                                        <div class="coupon_error"></div>
                                        <div class="coupon_text"></div>
                                        <div class="coupon_details"></div>
                                        <div class="coupon_exp_date"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @include('front.pages.partials.product.upload.modal')
@endsection

@push('scripts')
    <script src="{{ asset('front/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
    <script type="module" src="{{ asset('front/assets/js/uploadModal.js') }}"></script>
    <script>
        function redirectToProduct(e, element) {
            e.preventDefault();
            const productSlug = element.getAttribute('data-product-slug');
            const projectId = element.getAttribute('data-project-id');
            const url = `/product/${productSlug}?project_id=${projectId}`;
            window.location.href = url;
        }

        $(document).ready(() => {

            $(document).on('click', '.itemRemoveLink', function (e){
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    confirmButtonColor: '#3474d4',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const deleteUrl = $(this).find('a').attr('href');
                        window.location.href = deleteUrl;
                    }
                });
            })

            $(document).on('click', '.coupon-toggle-link', function () {
                $('.coupon_form').toggle();
            })
            $(document).on('click', '#apply_coupon_code', function (e) {
                e.preventDefault();
                var route = $(this).attr('data-url');
                var coupon_val = $(".coupon_name").val();
                $('.coupon_error, .coupon_text, .coupon_details, .coupon_exp_date').html('');
                if (coupon_val == '') {
                    $('.coupon_error').html('Can not be empty');
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: route,
                    data: {coupon: coupon_val},
                    dataType: 'json',

                    success: (data) => {
                        if(data.login){
                            Swal.fire({
                                text: 'For using that coupon, you need to be logged in.',
                                icon: 'warning',
                                confirmButtonText: 'Log In',
                                confirmButtonColor: "#3474d4",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/login';
                                }
                            });
                        }else{
                            let coupon_percent
                            if (data.message) {
                                coupon_percent = 0
                                $('.coupon_error').html(data.message)
                            } else {
                                coupon_percent = data.percent || data.fixed_price;
                                $('.coupon_text').html(data.text);
                                $('.coupon_details').html(data.details);
                                $('.coupon_exp_date').html(data.exp_date);

                                $('.new-price').each(function() {
                                    let $newPrice = $(this);
                                    let originalPrice = parseFloat($newPrice.data('price'));
                                    let newPriceValue = originalPrice;

                                    if (coupon_percent > 0) {
                                        if (data.percent) {
                                            newPriceValue = originalPrice - (originalPrice * parseFloat(coupon_percent) / 100);
                                        } else if (data.fixed_price) {
                                            let coupon_price = coupon_percent / ($('.new-price').length - 1);
                                            newPriceValue = originalPrice - parseFloat(coupon_price);
                                        }

                                        $newPrice.text('$' + newPriceValue.toFixed(2));
                                        $newPrice.closest('.subtotal_price_block')
                                            .find('.new-price-discount')
                                            .text('$' + originalPrice.toFixed(2));
                                    } else {
                                        $newPrice.closest('.subtotal_price_block').find('.new-price-discount').text('');
                                    }
                                })

                                if(data.fixed_price){
                                    let originalPrice = parseFloat($('.total_count .new-price').data('price'));
                                    let new_price = originalPrice - parseFloat(coupon_percent);
                                    $('.total_count .new-price').text(new_price.toFixed(2));
                                }
                            }

                            $('.coupon_id').val(data.coupon);
                        }
                    }
                });
            })

            $('.product-checkbox').on('change', function() {
                const isAnyChecked = $('.product-checkbox:checked').length > 0;

                $('.checkout-btn').prop('disabled', !isAnyChecked);

                let subtotal = 0;
                $('.product-checkbox:checked').each(function () {
                    const price = parseFloat($(this).closest('.cart_item_block')
                        .find('.subtotal_price_per_item')
                        .data('price')) || 0;

                    subtotal += price;
                });

                let coupon = $('.coupon_name').val();

                $('.subtotal_block .new-price').data('price', subtotal);
                $('.subtotal_block .new-price').text(`$${subtotal.toFixed(2)}`);

                if(coupon){
                    $('#apply_coupon_code').click();
                }
            });

            $('.checkout-btn').on('click', function(e) {
                e.preventDefault();

                const isAuthenticated = '{{ Auth::check() }}';
                if (!isAuthenticated) {
                    $('#registerModal').modal('show');
                } else {
                    $('#basket_form').submit();
                }
            });
        })
    </script>
@endpush
