@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">
    <style>
        .category_breadcrumb {
            margin: 35px 0;
            display: flex;
        }

        .category_divider {
            padding: 0 15px;
        }

        .category_name {
            font-size: 18px;
            line-height: 22px;
            font-weight: 400;
        }

        .subcategory_name {
            font-weight: 600;
            font-size: 18px;
            white-space: pre-wrap;
            line-height: 22px;
        }

        @media screen and (max-width: 480px) {
            .category_breadcrumb {
                flex-wrap: wrap;
            }

            .category_name, .subcategory_name {
                font-size: 18px;
                line-height: 22px;
                white-space: nowrap;
            }
        }

        .show_more_category {
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 30px;
            border: 1px solid;
            font-size: 18px;
            cursor: pointer;
            height: 100%;
        }

        .hidden_category_item {
            display: none;
        }
    </style>
@endpush

@section('content')
    @if(count($sliders))
        <div class="ec-main-slider section section-space-pb category_slider">
        {{--        container--}}
        <div class="">
            <div id="home_banner" class="ec-slider swiper-container main-slider-nav main-slider-dot">
                <!-- Main slider -->
                <div class="swiper-wrapper">
                    @foreach($sliders as $s => $slider)
                        <div class="ec-slide-item swiper-slide d-flex slide-1"
                             style="background-image: url({{ asset('storage/content/' . $slider->image) }})">
                            <div class="container align-self-center">
                                <div class="row">
                                    <div class="col-sm-12 align-self-center">
                                        <div class="ec-slide-content">
                                            <div class="ec-slide-content_title slider-animation">
                                                <h1 class="ec-slide-title"
                                                    style="color: {{ $slider->big_title_color }}">{{ $slider->big_title }}</h1>
                                                @if($slider->title)
                                                    <h2 class="ec-slide-stitle"
                                                        style="color: {{ $slider->title_color }}">{{ $slider->title }}</h2>
                                                @endif
                                                <div class="ec-slide-desc ec-slide-desc_{{ $s }}">
                                                    <style>
                                                        .ec-slide-desc_{{ $s }} p, .ec-slide-desc_{{ $s }} li {
                                                            color: {{ $slider->description_color }};
                                                            /*border: 1px solid white;*/
                                                            /*border-radius: 0;*/
                                                            margin: 0;
                                                        }
                                                        .ec-slide-desc_{{ $s }} li{list-style-type: disc}
                                                        .ec-slide-desc_{{ $s }} ul{padding-left: 20px;display: inline-block;text-align: justify}
                                                    </style>
                                                    {!! $slider->description !!}
                                                </div>
                                                @if($slider->button_text)
                                                    <a href="{{ $slider->button_url }}" class="btn btn-lg btn-primary slider_btn"
                                                       style="color: {{ $slider->button_text_color }}; border-radius: 0; border:1px solid {{ $slider->button_text_color }}">{{ $slider->button_text }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination swiper-pagination-white"></div>
                <div class="swiper-buttons">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
            <div class=" hidden main-slider-nav main-slider-dot main_slider_tablet">
                <!-- Main slider -->
                <div class="swiper-wrapper">
                    @foreach($slidersTablet as $st => $sliderT)
                        <div class="ec-slide-item swiper-slide d-flex slide-1"
                             style="background-image: url({{ asset('storage/content/' . $sliderT->tablet_image) }});background-size: contain">
                            <div class="container align-self-center">
                                <div class="row">
                                    <div class="col-sm-12 align-self-center">
                                        <div class="ec-slide-content">
                                            <div class="ec-slide-content_title slider-animation">
                                                <h1 class="ec-slide-title"
                                                    style="color: {{ $sliderT->big_title_color }}">{{ $sliderT->big_title }}</h1>
                                                @if($sliderT->title)
                                                    <h2 class="ec-slide-stitle"
                                                        style="color: {{ $sliderT->title_color }}">{{ $sliderT->title }}</h2>
                                                @endif
                                                <div class="ec-slide-desc ec-slide-desc_{{ $st }}">
                                                    <style>
                                                        .ec-slide-desc_{{ $st }} p, .ec-slide-desc_{{ $st }} li {
                                                            color: {{ $sliderT->description_color }};
                                                            /*border: 1px solid white;*/
                                                            /*border-radius: 0;*/
                                                            margin: 0;
                                                        }
                                                        .ec-slide-desc_{{ $st }} li{list-style-type: disc}
                                                        .ec-slide-desc_{{ $st }} ul{padding-left: 20px;display: inline-block;text-align: justify}
                                                    </style>
                                                    {!! $sliderT->description !!}
                                                </div>
                                                @if($sliderT->button_text)
                                                    <a href="{{ $sliderT->button_url }}" class="btn btn-lg btn-primary slider_btn"
                                                       style="color: {{ $sliderT->button_text_color }}; border-radius: 0; border:1px solid {{ $sliderT->button_text_color }}">{{ $sliderT->button_text }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination swiper-pagination-white"></div>
                <div class="swiper-buttons">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
            <div class=" hidden main-slider-nav main-slider-dot main_slider_mobile">
                <!-- Main slider -->
                <div class="swiper-wrapper">
                    @foreach($slidersMobile as $sm => $sliderM)
                        <div class="ec-slide-item swiper-slide d-flex slide-1"
                             style="background-image: url({{ asset('storage/content/' . $sliderM->mobile_image) }});background-size: contain">
                            <div class="container align-self-center">
                                <div class="row">
                                    <div class="col-sm-12 align-self-center">
                                        <div class="ec-slide-content">
                                            <div class="ec-slide-content_title slider-animation">
                                                <h1 class="ec-slide-title"
                                                    style="color: {{ $sliderM->big_title_color }}">{{ $sliderM->big_title }}</h1>
                                                @if($sliderM->title)
                                                    <h2 class="ec-slide-stitle"
                                                        style="color: {{ $sliderM->title_color }}">{{ $sliderM->title }}</h2>
                                                @endif
                                                <div class="ec-slide-desc ec-slide-desc_{{ $sm }}">
                                                    <style>
                                                        .ec-slide-desc_{{ $sm }} p, .ec-slide-desc_{{ $sm }} li {
                                                            color: {{ $sliderM->description_color }};
                                                            /*border: 1px solid white;*/
                                                            /*border-radius: 0;*/
                                                            margin: 0;
                                                        }
                                                        .ec-slide-desc_{{ $sm }} li{list-style-type: disc}
                                                        .ec-slide-desc_{{ $sm }} ul{padding-left: 20px;display: inline-block;text-align: justify}
                                                    </style>
                                                    {!! $sliderM->description !!}
                                                </div>
                                                @if($sliderM->button_text)
                                                    <a href="{{ $sliderM->button_url }}" class="btn btn-lg btn-primary slider_btn"
                                                       style="color: {{ $sliderM->button_text_color }}; border-radius: 0; border:1px solid {{ $sliderM->button_text_color }}">{{ $sliderM->button_text }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination swiper-pagination-white"></div>
                <div class="swiper-buttons">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <section class="ec-page-content">
        <div class="container">
            <div class="row">
                <div class="ec-shop-rightside col-lg-12 col-md-12">

                    @foreach($category->childs as $subcategory)
                        @if(count($subcategory->subproducts))
                            <div class="category_breadcrumb">
                                <div class="category_name">{{ $category->name }}</div>
                                <span class="category_divider">|</span>
                                <div class="subcategory_name">{{ $subcategory->name }}</div>
                            </div>

                            <div class="shop-pro-content category_products">
                                <div class="shop-pro-inner">
                                    <div class="row">
                                        @foreach($subcategory->subproducts as $p => $product)
                                            <div
                                                class="col-lg-3 col-md-4 col-sm-6 col-6 mb-6 pro-gl-content {{ $p > 6 ? 'hidden_category_item' : '' }}">
                                                <div class="ec-product-inner">
                                                    <div class="ec-pro-image-outer">
                                                        <div class="ec-pro-image">
                                                            <a href="{{ route('product', ['slug' => $product->slug]) }}"
                                                               class="image"
                                                               style="background-image: url('{{ asset('storage/content/small-images/' . $product->images[0]) }}')">

                                                            </a>
                                                        </div>
                                                        <a href="{{ route('product', ['slug' => $product->slug]) }}" class="layer shop_btn">
                                                            <button class="btn btn-primary" type="button">SHOP NOW</button>
                                                        </a>
                                                    </div>
                                                    <div class="ec-pro-content">
                                                        <h5 class="ec-pro-title"><a
                                                                href="{{ route('product', ['slug' => $product->slug]) }}">{{ $product->title }}</a>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($p == 7)
                                                <div
                                                    class="col-lg-3 col-md-6 col-sm-6 col-6 mb-6 pro-gl-content">
                                                    <span class="show_more_category">
                                                        Show More
                                                    </span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if(!count($category->products))
                        <p style="margin-bottom: 40px;">Not items found</p>
                    @endif

                    {{--                    <div class="shop-pro-content category_products">--}}
                    {{--                        <div class="shop-pro-inner">--}}
                    {{--                            <div class="row">--}}
                    {{--                                @if(count($products))--}}
                    {{--                                    @foreach($products as $product)--}}
                    {{--                                        <div class="col-lg-3 col-md-6 col-sm-6 col-6 mb-6 pro-gl-content">--}}
                    {{--                                            <div class="ec-product-inner">--}}
                    {{--                                                <div class="ec-pro-image-outer">--}}
                    {{--                                                    <div class="ec-pro-image">--}}
                    {{--                                                        <a href="{{ route('product', ['slug' => $product->slug]) }}"--}}
                    {{--                                                           class="image"--}}
                    {{--                                                           style="background-image: url('{{ asset('storage/content/' . $product->images[0]) }}')">--}}

                    {{--                                                        </a>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}
                    {{--                                                <div class="ec-pro-content">--}}
                    {{--                                                    <h5 class="ec-pro-title"><a--}}
                    {{--                                                            href="{{ route('product', ['slug' => $product->slug]) }}">{{ $product->title }}</a>--}}
                    {{--                                                    </h5>--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}
                    {{--                                    @endforeach--}}
                    {{--                                @else--}}
                    {{--                                    <p>Not items found</p>--}}
                    {{--                                @endif--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    {{--                        @if($count)--}}
                    {{--                            <!-- Ec Pagination Start -->--}}
                    {{--                            <div class="ec-pro-pagination">--}}
                    {{--                                @if($count > 12)--}}
                    {{--                                    <span>Showing 1-8 of {{ $count }} item(s)</span>--}}
                    {{--                                @else--}}
                    {{--                                    <span>Showing 1-{{ $count }} of {{ $count }} item(s)</span>--}}
                    {{--                                @endif--}}
                    {{--                                {{ $products->links() }}--}}
                    {{--                            </div>--}}
                    {{--                            <!-- Ec Pagination End -->--}}
                    {{--                        @endif--}}
                    {{--                    </div>--}}
                    <!--Shop content End -->
                </div>

            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('front/assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('front/assets/js/demo-8.js') }}"></script>
    <script>
        $(document).on('click', '.show_more_category', function () {
            $(this).parents('.category_products').find('.hidden_category_item').show()
            $(this).parent('div').remove();
        })

        function updateBackgroundSize() {
            const slides = document.querySelectorAll('.ec-slide-item');

            const backgroundSize = window.innerHeight > window.innerWidth ? 'contain' : 'cover';

            slides.forEach(slide => {
                slide.style.backgroundSize = backgroundSize;
                slide.style.backgroundPosition = 'center';
            });
        }

        window.addEventListener('orientationchange', updateBackgroundSize);
        window.addEventListener('resize', updateBackgroundSize);
    </script>
@endpush
