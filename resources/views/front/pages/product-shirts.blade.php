@php use App\Models\Address; @endphp
@extends('front.layouts.main')
@section('meta')
    @parent
    <meta property="og:image"
          content="{{  asset('storage/content/'.($product->images)[0] )}}"/>
@endsection
<?php
$hidden_attrs = [];
?>
@push('styles')
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/uploadModal.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
@endpush

@section('content')
    <input type="hidden" id="cutting_width" value="{{$product->cutting_width}}"/>
    <input type="hidden" id="cutting_height" value="{{$product->cutting_height}}"/>
    <form id="calculation_form" class="section-space-pt" action="{{$project ? route('basket.updateItem', $project) : route('basket.addDesignApparel')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="{{$product->id}}" id="product_id"/>
        <input type="hidden" name="min_price" value="{{$product->min_price}}" id="min_price"/>
        <input type="hidden" id="total_amount" name="total_amount">
        <input type="hidden" id="per_item_amount" name="per_item_amount">
        <input type="hidden" name="type" value="Upload Print Ready Files"/>
        <!-- Sart Single product -->
        <section class="single_product_section ec-page-content section-space-p" style="padding-top: 0;">
            <div class="container">
                <div class="row">
                    <div class="ec-pro-rightside ec-common-rightside col-lg-12 col-md-12">
                        <div class="single-pro-block">
                            <div class="single-pro-inner">
                                <div class="row" style="justify-content:center;align-items:start">
                                    <div class="single-pro-img single-pro-img-no-sidebar">
                                        <div class="single-product-scroll">
                                            <div class="swiper mobile_single_product">
                                                <div class="swiper-wrapper">
                                                    @foreach($product->images as $i => $image)
                                                        <div class="swiper-slide">
                                                            <div class="single_product_big_image open_product_popup"
                                                                 style="background-image: url('{{ asset('storage/content/' . $image) }}')"
                                                                 data-id="{{ $i }}"
                                                                 data-image="{{ asset('storage/content/' . $image) }}"
                                                            ></div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="swiper-pagination"></div>
                                            </div>
                                            <div class="single-product-cover">
                                                @foreach($product->images as $i => $image)
                                                    <div class="single-slide">
                                                        <div class="single_product_big_image open_product_popup"
                                                             style="background-image: url('{{ asset('storage/content/' . $image) }}')"
                                                             data-id="{{ $i }}"
                                                             data-image="{{ asset('storage/content/' . $image) }}"
                                                        ></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="single_product_slider">
                                                {{--                                           --}}
                                                <div class="single_product_video_block">
                                                    @if($product->video)
                                                        <a href="{{ $product->video }}"
                                                           class="popup_btn  @if(!$product->video) disable @endif">
                                                            <i class="ecicon eci-video-camera"></i>
                                                            View Video
                                                        </a>
                                                    @endif
                                                </div>
                                                {{--                                                --}}
                                                <div class="single-nav-thumb">
                                                    @foreach($product->images as $i => $image)
                                                        <div class="single-slide">
                                                            <a href="javascript:void(0)" class="product_popup_{{ $i }}">
                                                                <img src="{{ asset('storage/content/' . $image) }}"
                                                                     style="object-fit: cover;object-position: center;width: 100%;
    height: 100%;">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="popup_images" style="display:none;">
                                                @foreach($product->images as $i => $image)
                                                    <a href="{{ asset('storage/content/' . $image) }}"
                                                       class="image-popup-vertical-fit product_popup_{{ $i }}"
                                                    ><img src="{{ asset('storage/content/' . $image) }}" style="object-fit: cover;object-position: center;width: 100%;
    height: 100%;"></a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="ec-single-pro-tab">
                                            <div class="ec-single-pro-tab-wrapper">
                                                <div class="ec-single-pro-tab-nav">
                                                    <nav>
                                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                            <button class="nav-link active" id="nav-description-tab"
                                                                    data-bs-toggle="tab"
                                                                    data-bs-target="#ec-spt-nav-details" type="button"
                                                                    role="tab" aria-controls="ec-spt-nav-details"
                                                                    aria-selected="true">Description
                                                            </button>
                                                            @foreach($con_a as $aaa_id => $attribute)
                                                                @php
                                                                    $modifiedName = strtolower(str_replace(' ', '_', $attribute['name']));
                                                                @endphp
                                                                @foreach($product_information['types'][$aaa_id] as $type_id => $type_data)
                                                                    @if(isset($type_data['type_details']) && $type_data['type_details']['title'])
                                                                        <button class="nav-link" id="nav-{{$modifiedName}}-tab"
                                                                            data-bs-toggle="tab"
                                                                            data-bs-target="#ec-spt-nav-{{$modifiedName}}"
                                                                            type="button" role="tab"
                                                                            aria-controls="ec-spt-nav-{{$modifiedName}}"
                                                                            aria-selected="false">{{$attribute['name']}}
                                                                        </button>
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                            @if($product->template_details && $product->template_details[0]['title'])
                                                                <button class="nav-link" id="nav-template-tab"
                                                                        data-bs-toggle="tab"
                                                                        data-bs-target="#ec-spt-nav-template"
                                                                        type="button" role="tab"
                                                                        aria-controls="ec-spt-nav-template"
                                                                        aria-selected="false">Templates
                                                                </button>
                                                            @endif
                                                            <button class="nav-link" id="nav-file-setup-tab"
                                                                    data-bs-toggle="tab"
                                                                    data-bs-target="#ec-spt-nav-file-setup"
                                                                    type="button" role="tab"
                                                                    aria-controls="ec-spt-nav-file-setup"
                                                                    aria-selected="false">File Setup
                                                            </button>
                                                        </div>
                                                    </nav>
{{--                                                    <ul class="nav nav-tabs">--}}
{{--                                                        <li class="nav-item">--}}
{{--                                                            <a class="nav-link active" data-bs-toggle="tab"--}}
{{--                                                               data-bs-target="#ec-spt-nav-details" role="tablist">Description</a>--}}
{{--                                                        </li>--}}
{{--                                                    </ul>--}}
                                                </div>
                                                <div class="tab-content  ec-single-pro-tab-content">
                                                    <div id="ec-spt-nav-details" class="tab-pane fade show active">
                                                        <div class="ec-single-pro-tab-desc ck-content">
                                                            {!! $product->description !!}
                                                        </div>
                                                        <div class="product_read_more_block">
                                                            <div class="read_more_overlay"></div>
                                                            <button>Read More</button>
                                                        </div>
                                                    </div>
                                                    @foreach($con_a as $aaa_id => $attribute)
                                                        @php
                                                            $modifiedName = strtolower(str_replace(' ', '_', $attribute['name']));
                                                        @endphp
                                                        @foreach($product_information['types'][$aaa_id] as $type_id => $type_data)
                                                            @if(isset($type_data['type_details']) && $type_data['type_details']['title'])
                                                                <div id="ec-spt-nav-{{$modifiedName}}" class="tab-pane fade show">
                                                                    <div class="ec-single-pro-tab-desc">
                                                                        @include('front.pages.partials.product.tabs.paperStockTab', ['types' => $product_information['types'][$aaa_id], 'attribute' => $attribute])
                                                                    </div>
                                                                    <div class="product_read_more_block">
                                                                        <div class="read_more_overlay"></div>
                                                                        <button>Read More</button>
                                                                    </div>
                                                                </div>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                    <div id="ec-spt-nav-template" class="tab-pane fade show">
                                                        <div class="ec-single-pro-tab-desc">
                                                            @include('front.pages.partials.product.tabs.templatesTab')
                                                        </div>
                                                        <div class="product_read_more_block">
                                                            <div class="read_more_overlay"></div>
                                                            <button>Read More</button>
                                                        </div>
                                                    </div>
                                                    <div id="ec-spt-nav-file-setup" class="tab-pane fade show">
                                                        <div class="ec-single-pro-tab-desc">
                                                            @include('front.pages.partials.product.tabs.fileSetupTab')
                                                        </div>
                                                        <div class="product_read_more_block">
                                                            <div class="read_more_overlay"></div>
                                                            <button>Read More</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="single-pro-desc single-pro-desc-no-sidebar">
                                        <div class="single-pro-content">
                                            <h5 class="ec-single-title">{{ $product->title }}</h5>
                                            <div class="first_step">
                                                @include('front.pages.partials.product.steps.first_step_shirts')
                                            </div>
                                            <div class="second_step">
                                                <div>
                                                    <div class="form-group custom_group ">
                                                        <label class="form-label" for="project_title">Project Name <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" class="custom_input" id="project_title"
                                                               name="project_title" value="{{$project ? $project->project_title : ''}}">
                                                    </div>
                                                    <input type="hidden" id="set_count" value="1">
                                                    <input type="hidden" class="form-control" placeholder="Set Name" name="set_title[1]" value="">
                                                </div>
                                            </div>
                                            <input type="hidden" id="finishing_price" name="finising_price"
                                                   value="{{$product->finishing_price}}"/>
                                            <div class="ec-single-price-stoke">
                                                <div class="ec-single-price">
                                                <span>
                                                    <span class="product_total_text">Total</span>
                                                    <span class="new-price-discount"
                                                          style="text-decoration: line-through;"></span>
                                                    <span class="new-price"></span>
                                                </span>
                                                    <span class="price_item_block"
                                                          style="display:none;color: #000000;text-align: right">

                                                </span>
                                                </div>
                                            </div>
                                            <div class="ec-single-qty">
                                                <div class="ec-single-cart apparel_product">
                                                    @if($project)
                                                        <button class="btn btn-primary product_design" data-id="{{ $product->id }}">
                                                        <span class="continue_with_icon">
                                                            <span>Edit Design</span>
                                                        </span>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-primary product_design" data-id="{{ $product->id }}">
                                                            <span class="continue_with_icon">
                                                                <span>Add Design</span>
                                                            </span>
                                                        </button>
                                                    @endif
                                                    @if(isset($product->shipping_info))
                                                        <div class="single_product_sipping">
                                                        <div class="single_product_sipping_block">
                                                            <div class="single_product_sipping_block_left">
                                                                <img
                                                                        src="https://img.icons8.com/ios/50/null/document-delivery.png"
                                                                        width="25"/>
                                                                <p>Shipping Estimate</p>
                                                                <input type="hidden" id="total_price_amount" value="0"/>
                                                            </div>
                                                            <i class="ecicon eci-angle-down"></i>
                                                        </div>
                                                        <div class="single_product_sipping_form">
                                                            <div class="single_product_sipping_form_top">
                                                                <div class="single_product_sipping_postcode">
                                                                    <label for="">Enter ZIP code for shipping</label>
                                                                    <input type="number" min="0"
                                                                           class="shipping_postcode">
                                                                </div>
                                                                <button class="btn btn-primary calculate_shipping"
                                                                        type="button"
                                                                        data-url="{{route('calculateShipmentPrices')}}"
                                                                        disabled>CALCULATE
                                                                </button>
                                                            </div>
                                                            <div id="shipping-errors"></div>
                                                            <table class="single_product_sipping_total table table-striped">
                                                                <thead></thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
{{--                                            <div class="ec-single-qty-custom" style="display: none;">--}}
{{--                                                <button class="btn btn-danger" id="cancel_btn" style="float: left">--}}
{{--                                                    Cancel--}}
{{--                                                </button>--}}
{{--                                                <button class="btn btn-primary request_continue" id="request_continue"--}}
{{--                                                        data-id="3" style="float: right">--}}
{{--                                                    Request--}}
{{--                                                </button>--}}
{{--                                                <div class="clearfix"></div>--}}
{{--                                            </div>--}}
                                            <div class="single_product_contacts" style="clear: both">
                                                <a href="mailto:{{ setting('email') }}" class="single_product_contact">
                                                    <img src="{{ asset('front/assets/images/mail.svg') }}" alt="Email"
                                                         width="30">
                                                    <span>Email Us</span>
                                                </a>
                                                @if(!$project)
                                                    <a href="javascript:void(0)" class="single_product_contact">
                                                        <img src="{{ asset('front/assets/images/estimate.svg') }}"
                                                             alt="Chat">
                                                        <span>Get a custom Estimate</span>
                                                    </a>
                                                @endif
                                                <a href="tel:{{ setting('call') }}" class="single_product_contact">
                                                    <img src="{{ asset('front/assets/images/phone.png') }}" alt="Phone">
                                                    <span>Call: {{ setting('phone') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="mobile-ec-single-pro-tab">
                                            <div class="ec-single-pro-tab-wrapper">
                                                <div class="tab-content  ec-single-pro-tab-content">
                                                    <div class="tab-container container-fluid">
                                                        <div class="tab-content" id="nav-tabContent">
                                                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header" id="flush-headingOne">
                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                                            Description
                                                                        </button>
                                                                    </h2>
                                                                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                                                                        <div class="accordion-body">
                                                                            <div id="ec-spt-nav-details-mobile" class="tab-pane fade show active">
                                                                                <div class="ec-single-pro-tab-desc ck-content">
                                                                                    {!! $product->description !!}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @foreach($con_a as $aaa_id => $attribute)
                                                                    @php
                                                                        $modifiedName = strtolower(str_replace(' ', '_', $attribute['name']));
                                                                    @endphp
                                                                    @foreach($product_information['types'][$aaa_id] as $type_id => $type_data)
                                                                        @if(isset($type_data['type_details']) && $type_data['type_details']['title'])
                                                                            <div class="accordion-item">
                                                                                <h2 class="accordion-header" id="flush-header-{{$modifiedName}}">
                                                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-{{$modifiedName}}" aria-expanded="false" aria-controls="flush-{{$modifiedName}}">
                                                                                        {{$attribute['name']}}
                                                                                    </button>
                                                                                </h2>
                                                                                <div id="flush-{{$modifiedName}}" class="accordion-collapse collapse" aria-labelledby="flush-{{$modifiedName}}" data-bs-parent="#accordionFlushExample" style="">
                                                                                    <div class="accordion-body">
                                                                                        <div id="ec-spt-nav-{{$modifiedName}}-mobile">
                                                                                            <div class="ec-single-pro-tab-desc">
                                                                                                @include('front.pages.partials.product.tabs.paperStockTab', ['types' => $product_information['types'][$aaa_id], 'attribute' => $attribute])
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @break;
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                                @if(isset($product->template_details) && $product->template_details[0]['title'])

                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="flush-headingFour">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                                                                Templates
                                                                            </button>
                                                                        </h2>
                                                                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample" style="">
                                                                            <div class="accordion-body">
                                                                                <div id="ec-spt-nav-template-mobile">
                                                                                    <div class="ec-single-pro-tab-desc">
                                                                                        @include('front.pages.partials.product.tabs.templatesTab')
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header" id="flush-headingFive">
                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                                                            File Setup
                                                                        </button>
                                                                    </h2>
                                                                    <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample" style="">
                                                                        <div class="accordion-body">
                                                                            <div id="ec-spt-nav-file-setup-mobile">
                                                                                <div class="ec-single-pro-tab-desc">
                                                                                    @include('front.pages.partials.product.tabs.fileSetupTab')
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
                                        @if(count($related_products))
                                            <!-- Related Product Start -->
                                            <section
                                                    class="suggestions_section section ec-releted-product section-space-p">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-12 text-center">
                                                            <div class="section-title">
                                                                <h2 class="ec-bg-title">Suggestions for you</h2>
                                                                <h2 class="ec-title">Suggestions for you</h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row margin-minus-b-30 product_list">
                                                        <!-- Related Product Content -->
                                                        @foreach($related_products as $related_product)
                                                            <div
                                                                    class="col-lg-6 col-md-4 col-sm-4 col-6 mb-6 pro-gl-content">
                                                                <div class="ec-product-inner">
                                                                    <div class="ec-pro-image-outer">
                                                                        <div class="ec-pro-image">
                                                                            <a href="{{ route('product', ['slug' => $related_product->slug]) }}"
                                                                               class="image"
                                                                               style="background-image: url('{{ asset('storage/content/small-images/' . $related_product->images[0]) }}')">
                                                                            </a>
                                                                        </div>
                                                                        <a href="{{ route('product', ['slug' => $related_product->slug]) }}" class="layer shop_btn">
                                                                            <button class="btn btn-primary text-bold" type="button">SHOP NOW</button>
                                                                        </a>
                                                                    </div>
                                                                    <div class="ec-pro-content">
                                                                        <h5 class="ec-pro-title"><a
                                                                                    href="{{ route('product', ['slug' => $related_product->slug]) }}">{{ $related_product->title }}</a>
                                                                        </h5>
                                                                        <div
                                                                                class="ec-pro-list-desc">{{ $related_product->excerot }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- Related Product end -->
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        @include('front.pages.partials.product.upload.modal')

    </form>
    <!-- End Single product -->

    <div class="size_popup_modal">
        <div class="size_popup_overlay"></div>
        <div class="size_popup_block">
            <div class="size_popup_header">
                <h4>Information</h4>
                <i class="ecicon eci-close"></i>
            </div>
            <div class="size_popup_content">
                <p>The maximum size for this product is <span class="size_popup_sizes"></span>. Your order will be made
                    out of more then 1 piece. Please contact customer service for details</p>
            </div>
            <div class="size_popup_footer">
                <button>Close</button>
            </div>
        </div>
    </div>
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="helpModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ck-content" id="helpModalContent"></div>
            </div>
        </div>
    </div>

    <div id="related_types" style="display: none;">
        <?php
        $hidden_types = json_encode([]);
        if (!empty($product->hidden_types)) {
            $hidden_types = $product->hidden_types;
        }
        echo $hidden_types;
        ?>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('front/assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-md5@0.7.3/src/md5.min.js"></script>
    <script type="module" src="{{ asset('front/assets/js/uploadModal.js') }}"></script>
    <script type="module" src="{{ asset('front/assets/js/custom-shirts.js') }}"></script>
    <script src="{{ asset('front/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.selectric/1.11.1/jquery.selectric.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key=AIzaSyDn1gU-9ENcDEK5IsuwJNVgrtqnwRHddMc&country=US&sensor=false&libraries=places&language=en-AU"></script>
    <script>
        var options = {
            componentRestrictions: {country: ['us', 'ca']} // Restrict to USA and Canada
        };
        var autocomplete = new google.maps.places.Autocomplete($("#custom_address")[0], options);

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
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
            $("input[name='custom_zip']").val(addressInfo.zipCode);
            $("input[name='custom_address']").val(addressInfo.address);
            $("input[name='custom_unit']").val(addressInfo.unitNumber);
            $("input[name='custom_state']").val(addressInfo.state);
            $("input[name='custom_city']").val(addressInfo.city);

        });

    </script>
    <script>
        var productImagesByType = @json($product_images_by_type);
        var defaultProductImages = @json($default_product_images);

        var swiper = new Swiper(".mobile_single_product", {
            pagination: {
                el: ".swiper-pagination",
            },
        });
        $('select').selectric({nativeOnMobile: true,});
        function popUp_init(){
            $('.popup_btn').magnificPopup({
                type: 'iframe',
                iframe: {
                    markup: '<div class="mfp-iframe-scaler">' +
                        '<div class="mfp-close"></div>' +
                        '<iframe class="mfp-iframe" frameborder="0" allow="autoplay"></iframe>' +
                        '</div>',
                    patterns: {
                        youtube: {
                            index: 'youtube.com/',
                            id: 'v=',
                            src: 'https://www.youtube.com/embed/%id%?autoplay=1'
                        }
                    }
                }
            });

            $('.popup_btn').magnificPopup({
                type: 'iframe',
                iframe: {
                    markup: '<div class="mfp-iframe-scaler">' +
                        '<div class="mfp-close"></div>' +
                        '<iframe class="mfp-iframe" frameborder="0" allow="autoplay"></iframe>' +
                        '</div>',
                    patterns: {
                        youtube: {
                            index: 'youtube.com/',
                            id: function (url) {
                                const m = url.match(/^.+youtube.com\/.*[?&]v=([^&]+)/);
                                if (m !== null) {
                                    return m[1];
                                }
                                return null;
                            },
                            src: 'https://www.youtube.com/embed/%id%?autoplay=1'

                        }
                    }
                }
            });

            $('.image-popup-vertical-fit').magnificPopup({
                type: 'image',
                mainClass: 'mfp-with-zoom',
                gallery: {
                    enabled: true,
                    enableEscapeKey:true,
                },
                callbacks: {
                    beforeOpen: function () {
                        // Save the current scroll position
                        const scrollTop = $(window).scrollTop();
                        // Set the body overflow to hidden and position fixed
                        $('body').css({
                            overflowY: 'hidden',
                            position: 'fixed',
                            top: -scrollTop + 'px',
                            width: '100%'
                        });
                    },
                    close: function() {
                        // Restore the scroll position and body styles
                        const scrollTop = parseInt($('body').css('top')) * -1;
                        $('body').css({
                            overflowY: 'auto',
                            position: '',
                            top: '',
                            width: ''
                        });
                        $(window).scrollTop(scrollTop);
                    }
                },
            });
        }

        popUp_init();

        // Shipping
        $(document).on('click', '.single_product_sipping_block', function () {
            $(this).parent().toggleClass('active')
        })

        $(document).on('change', '#custom_delivery_type', function () {
            $('#custom_address_block').toggle('custom_address');
            if (!$(this).prop('checked')) {
                $("input[name='custom_zip']").val('');
                $("input[name='custom_address']").val('');
                $("input[name='custom_unit']").val('');
                $("input[name='custom_state']").val('');
                $("input[name='custom_city']").val('');
            }
        });

        $(document).ready(function() {
            $('.accordion-button').on('click', function () {
                const targetId = $(this).data('bs-target');
                const headingId = $(this).closest('.accordion-item').find('.accordion-header');

                $(targetId).on('shown.bs.collapse', function () {
                    $('html, body').animate({
                        scrollTop: headingId.offset().top - 100
                    });
                });
            });
            $('.select_type').selectric({
                optionsItemBuilder: function(itemData, element, index) {
                    const imgSrc = $(itemData.element).data('img');
                    const imgHtml = imgSrc ? '<img src="' + imgSrc + '" class="type_icon" alt="Type icon">' : '';
                    return '<div class="option_img">' + imgHtml + '<span>' + itemData.text + '</span></div>';
                }
            });
            $('select').on('change selectric-select', function (event, element, selectric) {
                const selectricDiv = $(this).closest('.selectric-wrapper');
                selectricDiv.addClass('selectric-selected');
                updateSelectedLabel(this);
            });

            $('select').on('change selectric-select mousedown', function (event, element, selectric) {
                const selectricDiv = $(this).closest('.selectric-wrapper');

                if (event.type === 'mousedown') {
                    selectricDiv.addClass('selectric-selected');
                }
            });

            $('.opened_list_item').on('click', function () {
                const $this = $(this);
                const typeId = $this.data('id');
                const aaaId = $this.data('attr');
                const $select = $('#attribute_' + aaaId);

                const isMultipleSelect = $this.closest('.multiple_select').length > 0;

                let selectedValues = Array.isArray($select.val()) ? $select.val() : [$select.val()];

                if (isMultipleSelect) {
                    if ($this.hasClass('selectric-selected')) {
                        $this.removeClass('selectric-selected');
                        selectedValues = selectedValues.filter(id => id !== typeId.toString());
                    } else {
                        $this.addClass('selectric-selected');
                        selectedValues.push(typeId.toString());
                    }
                }else {
                    $this.closest('.opened_list').find('.opened_list_item').removeClass('selectric-selected');
                    $this.addClass('selectric-selected');
                    selectedValues = [typeId.toString()];
                }

                $select.val(selectedValues).trigger('change');

            });

            function updateSelectedLabel(selectElement) {
                const selectedImgSrc = $(selectElement).find('option:selected').data('img');
                const selectedText = $(selectElement).find('option:selected').text();
                const iconHtml = selectedImgSrc ? '<img src="' + selectedImgSrc + '" class="type_icon" alt="Type icon">' : '';
                $(selectElement).closest('.selectric-wrapper').find('.label').html(selectedText + iconHtml);
            }

            $('.select_type').each(function() {
                updateSelectedLabel(this);
            });

            $('.helpIcon').on('click', function () {
                const attrId = $(this).data('attr-id');

                $('#helpModalContent').html('<p>Loading...</p>');
                $('#helpModal').modal('show');

                $.ajax({
                    url: '/help-text/' + attrId,
                    method: 'GET',
                    success: function (response) {
                        $('#helpModalLabel').html('<p>' + response.attribute.name+ '</p>');
                        $('#helpModalContent').html('<p>' + response.attribute.help_text+ '</p>');
                    },
                    error: function () {
                        $('#helpModalContent').html('<p>Error loading help text. Please try again.</p>');
                    }
                });
            });

            $(window).on('scroll', function() {
                let mobileTotalBlock = $('.mobile_total_block');
                let windowScroll = $(window).scrollTop(); // Current scroll position from the top
                let windowHeight = $(window).height(); // Height of the viewport
                let documentHeight = $(document).height(); // Total height of the document

                // Check if the scroll position plus the viewport height is at least 400px above the bottom
                if (windowScroll + windowHeight >= documentHeight - 400) {
                    mobileTotalBlock.addClass('scroll-change-background'); // Add class when 400px above bottom
                } else {
                    mobileTotalBlock.removeClass('scroll-change-background'); // Remove class if not in range
                }
            });

        })
    </script>
@endpush
