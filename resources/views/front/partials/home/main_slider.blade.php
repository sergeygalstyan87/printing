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
                                            .ec-slide-desc_{{ $s }} ul{padding-left: 20px;display: inline-block;text-align: start}
                                        </style>
                                        <span class="ck-content">
                                            {!! $slider->description !!}
                                        </span>
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
                                            .ec-slide-desc_{{ $st }} ul{padding-left: 20px;display: inline-block;text-align: start}
                                        </style>
                                        <span class="ck-content">
                                            {!! $sliderT->description !!}
                                        </span>
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
                 style="background-image: url({{ asset('storage/content/' . $sliderM->mobile_image) }});background-size:contain">
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
                                            .ec-slide-desc_{{ $sm }} li{list-style-type: disc;}
                                            .ec-slide-desc_{{ $sm }} ul{padding-left: 20px;display: inline-block;text-align: start;}
                                        </style>
                                        <span class="ck-content">
                                            {!! $sliderM->description !!}
                                        </span>
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
