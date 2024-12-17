@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/assets/css/demo8.css') }}"/>
@endpush

@section('content')

    <div class="ec-main-slider section section-space-pb">
        {{--        container--}}
        <div class="">
           @include('front.partials.home.main_slider')
        </div>
    </div>

    <section class="section ec-category-section section-space-p">
        <div class="container">
            <div class="row d-none">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="ec-title">Top Category</h2>
                    </div>
                </div>
            </div>
            <div class="row margin-minus-b-15 margin-minus-t-15">
                <div id="ec-cat-slider" class="ec-cat-slider owl-carousel">
                    @foreach($services as $s => $service)
                        <div class="ec_cat_content ec_cat_content_{{ $s + 1 }}">
                            <div class="ec_cat_inner ec_cat_inner-{{ $s + 1 }}">
                                <div class="ec_ser_inner">
                                    <div class="ec-service-image">
                                        <img src="{{ asset('storage/content/' . $service->image) }}" width="100">
                                    </div>
                                    <div class="ec-service-desc">
                                        <h2>{{ $service->title }}</h2>
                                        <p>{{ $service->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="section ec-product-tab section-space-p">
        <div class="container">
            <div class="row">

                <!-- Sidebar area start -->
                <div class="ec-side-cat-overlay"></div>
                <div class="col-lg-3 sidebar-dis-991" data-animation="fadeIn">
                    <div class="cat-sidebar">
                        <div class="cat-sidebar-box">
                            <div class="ec-sidebar-wrap">
                                <!-- Sidebar Category Block -->
                                <div class="ec-sidebar-block">
                                    <div class="ec-sb-title">
                                        <h3 class="ec-sidebar-title">Categories
                                            <button class="ec-close">×</button>
                                        </h3>
                                    </div>
                                    @php($categories = \App\Models\Category::where('parent', 0)->orderBy('id', 'DESC')->get())
                                    @foreach($categories as $category)
                                        <div class="ec-sb-block-content">
                                            <ul>
                                                <li>
                                                    <div class="ec-sidebar-block-item">{{ $category->name }}</div>
                                                    @if($category->childs->count())
                                                        <ul class="ec-cat-sub-dropdown">
                                                            @foreach($category->childs as $child)
                                                                @if($child->subproducts->count())
                                                                    <li>
                                                                        <div class="ec-sidebar-sub-item">
                                                                            {{ $child->name }}
{{--                                                                            <a href="{{ route('category', ['id' => $category->id]) }}">{{ $child->name }}--}}
{{--                                                                                <span>{{ $child->subproducts->count() }}</span>--}}
{{--                                                                            </a>--}}
                                                                        </div>
                                                                        <ul class="ec-prod-sub-dropdown">
                                                                            @foreach($child->subproducts as $product)
                                                                                <li>
                                                                                    <div class="ec-sidebar-sub-item">
                                                                                        <a href="{{ route('product', ['slug' => $product->slug]) }}">
                                                                                            <span>{{ $product->title }}</span>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="ec-sidebar-slider">
                            <div class="ec-sb-slider-title">Best Sellers</div>
                            <div class="ec-sb-pro-sl">
                                @foreach($bestsellers as $bestseller)
                                    <div>
                                        <div class="ec-sb-pro-sl-item">
                                            <a href="{{ route('product', ['slug' => $bestseller->slug]) }}"
                                               class="sidekka_pro_img"
                                               style="background-image: url('{{ asset('storage/content/small-images/' . $bestseller->images[0]) }}')"
                                            >
                                            </a>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title">
                                                    <a href="{{ route('product', ['slug' => $bestseller->slug]) }}">{{ $bestseller->title }}</a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-12">

                    <div class="row space-t-50">
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2 class="ec-title">New Products</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-minus-b-15">
                        <div class="col">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="all">
                                    <div class="row">
                                        @foreach($products as $product)
                                            <div class="col-md-4 col-lg-3 col-6 ec-product-content">
                                                <div class="ec-product-inner">
                                                    <div class="ec-pro-image-outer">
                                                        <div class="ec-pro-image">
                                                            <a href="{{ route('product', ['slug' => $product->slug]) }}"
                                                               class="image"
                                                               style="background-image: url('{{ asset('storage/content/small-images/' . $product->images[0]) }}')">
                                                                {{--                                                                @foreach($product->images as $i => $image)--}}
                                                                {{--                                                                    @if($i == 0)--}}
                                                                {{--                                                                        <img class="main-image"--}}
                                                                {{--                                                                             src="{{ asset('storage/content/' . $image) }}"--}}
                                                                {{--                                                                             alt="{{ $product->title }}"--}}
                                                                {{--                                                                        />--}}
                                                                {{--                                                                    @elseif($i == 1)--}}
                                                                {{--                                                                        <img class="hover-image"--}}
                                                                {{--                                                                             src="{{ asset('storage/content/' . $image) }}"--}}
                                                                {{--                                                                             alt="{{ $product->title }}"--}}
                                                                {{--                                                                        />--}}
                                                                {{--                                                                    @endif--}}
                                                                {{--                                                                @endforeach--}}
                                                            </a>
                                                        </div>
                                                        <a href="{{ route('product', ['slug' => $product->slug]) }}" class="layer shop_btn">
                                                            <button class="btn btn-primary text-bold" type="button">SHOP NOW</button>
                                                        </a>
                                                    </div>
                                                    <div class="ec-pro-content">
                                                        <a href="{{ route('product', ['slug' => $product->slug]) }}">
                                                            <h6 class="ec-pro-stitle">{{ $product->title }}</h6>
                                                        </a>
                                                    </div>
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
    </section>

    <section class="home_banner section ec-ser-spe-section">
        <div class="" data-animation="fadeIn">
            <div class="">
                <div class="col-md-12" data-animation="fadeIn" style="padding: 0;">
                    <div class="ec-banner-inner">
                        @if(Str::endsWith($banner->image, ['.mp4', '.mov', '.ogg', '.webm']))
                            {{-- If image is a video file --}}
                            <video autoplay loop muted playsinline poster="{{ asset('storage/content/' . $banner->image) }}"
                                   class="video-background"
                                   style="height: 400px; width: 100%; object-fit: cover;">
                                <source src="{{ asset('storage/content/' . $banner->image) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <div class="ec-banner-block ec-banner-block-1 home_banner_block"
                             data-default-image="{{ asset('storage/content/' . $banner->image) }}"
                             @if($banner->mobile_image)
                                 data-mobile-image="{{ asset('storage/content/' . $banner->mobile_image) }}"
                             @endif
                             @if($banner->tablet_image)
                                 data-tablet-image="{{ asset('storage/content/' . $banner->tablet_image) }}"
                             @endif
                        >
                            <div class="container banner-block">
                                <div class="banner-content">
                                    @if(trim($banner->title) || trim($banner->big_title) || trim($banner->description))
                                        <div class="banner-text">
                                            @if(trim($banner->title))
                                                <span class="ec-banner-disc"
                                                      style="color: {{ $banner->title_color }}">{{ $banner->title }}</span>
                                            @endif
                                            @if(trim($banner->big_title))
                                                <span class="ec-banner-title"
                                                      style="color: {{ $banner->big_title_color }}">{{ $banner->big_title }}</span>
                                            @endif
                                            @if(trim($banner->description))
                                                <span class="ec-banner-stitle"
                                                      style="color: {{ $banner->description_color }}">{{ $banner->description }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    @if($banner->button_text)
                                    <span class="ec-banner-btn"><a href="{{ $banner->button_url }}"
                                                                   style="color: {{ $banner->button_text_color }}">{{ $banner->button_text }}<i
                                                class="ecicon eci-angle-double-right" aria-hidden="true"></i></a></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($reviews->count())
        <!-- Ec testmonial Start -->
        <section class="section ec-test-section" style="padding: 40px 0;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="section-title mb-0">
                            <h2 class="ec-bg-title">Testimonial</h2>
                            <h2 class="ec-title">Client Review</h2>
                            <p class="sub-title mb-3">What say client about us</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="ec-test-outer">
                        <div id="ec-testimonial-slider">
                            @foreach($reviews as $review)
                                <div class="comp-testi-list-carousel-item-container wgt-list-carousel-item-container
                                    star-rating accessibility-item ec-test-item" tabindex="0">
                                    <div class="wgt-list-outline">
                                        <div class="wgt-list-heading">
                                            <div class="wgt-list-carousel-item-image ">
                                                <img alt="testimonial" title="testimonial" src="{{ asset('storage/content/' . $review->image) }}"/>
                                            </div>
                                            <div class="wgt-list-carousel-item-title">
                                                <div class="wgt-list-item-title">{{ $review->name }}</div>
                                                <div class="wgt-list-item-subtitle">{{ $review->position }}</div>
                                                <div class="wgt-list-carousel-item-addon-styles rating">
                                                    @for($i = 1; $i <= $review->stars; $i++)
                                                        <i class="ecicon eci-star fill"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wgt-list-item-description">
                                            {{ $review->review }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="section ec-test-section partners_logo" style="padding: 40px 0;">
        <div class="container">
            <div class="ec-test-outer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2 class="ec-title">Trusted Online Printer of Choice</h2>
                        </div>
                    </div>
                </div>
                <div class="row margin-minus-b-15 margin-minus-t-15">
                    <div id="partners_logo-slider" class="ec-cat-slider owl-carousel">
                        @foreach($partnersLogo as $p => $logo)
                            <div class="ec_cat_content ec_cat_content_{{ $p + 1 }}">
                                <div class="ec_cat_inner ec_cat_inner-{{ $p + 1 }}">
                                    <div class="ec_ser_inner">
                                        <div class="ec-service-image">
                                            <img src="{{ asset('front/assets/images/partners-logo/' . $logo) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section ec-test-section" style="padding: 40px 0;">
        <div class="container">
            <div class="row">
                <div class="ec-test-outer subscribe-form-block">
                    <div class="col-md-12 text-center">
                        <div class="section-title mb-0">
                            <h2 class="ec-bg-title"></h2>
                            <h2 class="ec-title">It's good to be on the list.</h2>
                            <p class="sub-title mb-3">Get 10% off your order when you sign up for our emails</p>
                        </div>
                    </div>
                    <div class="row d-flex flex-column align-items-center justify-content-center">
                        <div class="col-sm-12 col-md-12 col-lg-6 subscribe-form">
                            <div class="d-flex align-items-center w-100">
                                <input type="email" class="ec-email-subscribe" placeholder="Subscription email" name="email">
                            </div>
                            <div class="subscribe-error text-danger"></div>
                            <div class="subscribe-success text-success"></div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 mt-3 mb-3 text-center text-justify">
                            Yes, I'd like to receive special offer emails from Yans print, as well as news about products, services and my designs in progress. Read our <a href="{{route('policy')}}" class="text-decoration-underline">Privacy policy</a>.
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 mt-3 subscribe-form text-center">
                            <button type="submit" class="subscribe_btn">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('front/assets/js/demo-8.js') }}"></script>
    <script type="module" src="{{ asset('front/assets/js/custom.js') }}"></script>
@endpush
