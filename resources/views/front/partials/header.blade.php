@php
    $basketId = request()->cookie('basket_id');
    $basketProjectsCount = 0;

    if ($basketId) {
        $basket = App\Models\Basket::with('projects')->find($basketId);
        $basketProjectsCount = $basket ? $basket->projects->count() : 0;
    }
@endphp
<header class="ec-header">
    @if(count($alerts=alerts()))
        <div class="global_alert alert_carousel position-relative">
            <div class="swiper-wrapper position-relative">
                @foreach($alerts as $a => $alert)
                    <div class="swiper-slide" style="background: linear-gradient(90deg, {{$alert->background_color}} 0, {{$alert->background_color_end}} 100%);">
                        <div class="container">
                            <div class="slider_content d-flex align-items-center justify-content-center flex-column">
                                <span style="font-size: 16px; font-weight: {{$alert->is_bold ? 700 : 'normal' }}; color: {{$alert->title_color}}">{!! $alert->title  !!}</span>
                                @if(!empty($alert->secondary_text))
                                    @if(!empty($alert->secondary_text_link))
                                        <?php
                                            $regex = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
                                            $is_date =  preg_match($regex, $alert->secondary_text_link);
                                        ?>
                                    @if(!$is_date)
                                        <a href="{{$alert->secondary_text_link}} ">
                                            <span class="link_with_underline" style="font-size: 14px; font-weight: normal; color: {{$alert->title_color}}; border-bottom-color: {{$alert->title_color}}" >{{ $alert->secondary_text }}</span>
                                        </a>
                                        @else
                                        <input type="hidden" class="timer_slider" value="{{$alert->secondary_text_link}}"/>
                                                <div style="font-size: 14px; font-weight: normal; color: {{$alert->title_color}}">
                                                    {!! $alert->secondary_text !!} <span class="countdown"></span>
                                                </div>

                                            @endif
                                    @else
                                        <span style="font-size: 14px; font-weight: normal; color: {{$alert->title_color}}">{!! $alert->secondary_text !!}</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="promotions-section-slider-arrows container">
                <div class="promotions-arrow-left arrow swiper-button-prev"></div>
                <div class="promotions-arrow-right arrow swiper-button-next"></div>
            </div>
        </div>
    @endif

    <div class="header-top d-lg-none">
        <div class="container">
            <div class="row align-items-center">

                <div class="col text-left header-top-left d-none d-lg-block">

                </div>

                <div class="col text-right header-top-center">

                </div>

                <div class="col d-lg-none ">
                    <div class="ec-header-bottons">
                        <a href="#ec-mobile-menu" class="ec-header-btn ec-side-toggle d-lg-none">
                            <img src="{{ asset('/front/assets/images/icons/menu.svg') }}" class="svg_img header_svg"
                                 alt="icon"/>
                        </a>
                        <div class="header-search d-none d-lg-block">
                            <form class="ec-btn-group-form search_form">
                                @csrf
                                <input class="form-control search_input" placeholder="Enter Product Name..." type="text">
                                <button class="submit">
                                    <span class="header_loader"></span>
                                    <img src="{{ asset('/front/assets/images/icons/search.svg') }}"
                                         class="svg_img header_svg" alt="icon"/>
                                </button>
                            </form>
                            <div class="search_results_block"></div>
                        </div>
                        <div class="mobile-header-logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('/front/assets/images/logo/logo.svg') }}" alt="Logo" width="120"/>
                            </a>
                        </div>
                        <div class="ec-header-cart">
                            <a class="ec-header-cart-link" href="{{route('basket.index')}}">
                                <img alt="cart" src="{{ asset('front/assets/images/icons/cart.svg') }}">
                                @auth
                                    <span class="cart-count active">{{auth()->user()->basket ? auth()->user()->basket->projects->count() : 0}}</span>
                                @else
                                    <span class="cart-count active">{{$basketProjectsCount}}</span>
                                @endauth
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ec-header-bottom d-none d-lg-block">
        <div class="container position-relative">
            <div class="row">
                <div class="ec-flex">
                    <div class="d-flex align-self-center justify-content-start gap-2">
                        <div class="header-logo">
                            <a href="{{ route('home') }}"><img src="{{ asset('/front/assets/images/logo/logo.svg') }}"
                                                               alt="Site Logo" width="180"/><img
                                    class="dark-logo" src="{{ asset('/front/assets/images/logo/dark-logo-8.png') }}"
                                    alt="Site Logo"
                                    style="display: none;"/></a>
                        </div>
                        <div class="header_call_block">
                            <span class="header_call_block_phone">
                                <a href="tel:{{ setting('call') }}">{{ setting('phone') }}</a>
                            </span>
                            <span class="header_call_block_text">Quality Customer Service</span>
                        </div>
                    </div>

                    <div class="align-self-center">
                        <div class="header-search">
                            <form class="ec-btn-group-form search_form">
                                @csrf
                                <input class="form-control search_input" placeholder="Enter Product Name..."
                                       type="text">
                                <button class="submit">
                                    <span class="header_loader"></span>
                                    <img src="{{ asset('/front/assets/images/icons/search.svg') }}"
                                         class="svg_img header_svg" alt=""/>
                                </button>
                            </form>
                            <div class="search_results_block"></div>
                        </div>
                    </div>

                    <div class="align-self-center">
                        <div class="ec-header-bottons">

{{--                            <div class="header_icon_block">--}}
{{--                                <img alt="Call" src="{{ asset('front/assets/images/call.svg') }}">--}}
{{--                                <div class="header_icon_block_texts">--}}
{{--                                    <span>{{setting('call_text')}}</span>--}}
{{--                                    <span>{{ setting('phone') }}</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <a class="header_icon_block" href="mailto:{{ setting('email') }}">--}}
{{--                                <img alt="Email" src="{{ asset('front/assets/images/mail.svg') }}">--}}
{{--                                <div class="header_icon_block_texts">--}}
{{--                                    <span>Email Us 24/7</span>--}}
{{--                                    <span>{{ setting('email') }}</span>--}}
{{--                                </div>--}}
{{--                            </a>--}}

                            <div class="ec-header-user ec-header-user__after dropdown">
                                <div class="user_dropdown">
                                    @auth
                                        <a id="accountLink" href="{{route('profile.orders')}}" class="dropdown-toggle d-flex flex-column" >
                                            <span class="font-bolder">Hi, {{ auth()->user()->first_name }}!</span>
                                            <span style="color: #3474d4">Your account</span>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-right user_dropdown_block">

                                            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>

                                            <li><a class="dropdown-item" href="{{ route('profile.orders') }}">Order History</a></li>
                                            <li><a class="dropdown-item" href="{{ route('profile.requests') }}">Quotes</a></li>
                                            <li><a class="dropdown-item" href="{{ route('profile.addresses') }}">Address Book</a></li>
                                            <li><a class="dropdown-item" href="{{ route('profile.payments') }}">Payment Methods</a></li>

                                            <li>
                                                <a class="dropdown-item" href="{{ route('profile.index') }}"
                                                   onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Logout</a>
                                                <form id="frm-logout" action="{{ route('logout') }}" method="POST"
                                                      style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                        </ul>
                                    @endauth
                                    @guest
                                        <a id="accountLink" href="{{route('profile.orders')}}" class="dropdown-toggle d-flex flex-column" >
                                            <span class="font-bolder">Hi, Log In!</span>
                                            <span style="color: #3474d4">Your account</span>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-right user_dropdown_block">

                                            <li class="login_reg_btn"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Log In or Create Account</button></li>
                                            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>

                                            <li><a class="dropdown-item" href="{{ route('profile.orders') }}">Order History</a></li>
                                            <li><a class="dropdown-item" href="{{ route('profile.requests') }}">Quotes</a></li>
                                            <li><a class="dropdown-item" href="{{ route('profile.addresses') }}">Address Book</a></li>
                                            <li><a class="dropdown-item" href="{{ route('profile.payments') }}">Payment Methods</a></li>
                                        </ul>
                                    @endguest

                                </div>
                            </div>
                            <div class="ec-header-cart">
                                <a class="ec-header-cart-link" href="{{route('basket.index')}}">
                                    <img alt="cart" src="{{ asset('front/assets/images/icons/cart.svg') }}">
                                    @auth
                                        <span class="cart-count active">{{auth()->user()->basket ? auth()->user()->basket->projects->count() : 0}}</span>
                                    @else
                                        <span class="cart-count active">{{$basketProjectsCount}}</span>
                                    @endauth
                                    <span>Cart</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="ec-header-bottom  d-lg-none mobile_search_block">
        <div class="container position-relative">
            <div class="row ">
                <div class="col header_logo_block">
                    <div class="header-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('/front/assets/images/logo/logo.svg') }}"
                                                           alt="Site Logo"/><img
                                class="dark-logo" src="{{ asset('/front/assets/images/logo/dark-logo-8.png') }}"
                                alt="Site Logo"
                                style="display: none;"/></a>
                    </div>
                </div>
                <div class="col">
                    <div class="header-search">
                        <form class="ec-btn-group-form search_form">
                            @csrf
                            <input class="form-control search_input" placeholder="Enter Product Name..." type="text">
                            <button class="submit">
                                <span class="header_loader"></span>
                                <img src="{{ asset('/front/assets/images/icons/search.svg') }}"
                                     class="svg_img header_svg" alt="icon"/>
                            </button>
                        </form>
                        <div class="search_results_block"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="ec-main-menu-desk" class="d-none d-lg-block sticky-nav">
        <div class="container position-relative">
            <div class="row">
                <div class="col-md-12 align-self-center">
                    <div class="ec-main-menu">
                        <ul>
                            @php($categories = \App\Models\Category::where('parent', 0)->orderBy('order', 'ASC')->get())
                            @foreach($categories as $category)
                                <li class="dropdown position-static"><a
                                        href="{{ route('category', ['id' => $category->id]) }}">{{ $category->name }}</a>
                                    @if(count($category->products))
                                        <ul class="mega-menu d-block">
                                            <li class="d-flex gap-3">
{{--                                                <ul class="d-block menu_products">--}}
{{--                                                    @foreach($category->menu_products as $menu_product)--}}
{{--                                                        <li>--}}

{{--                                                            <a--}}
{{--                                                                href="{{ route('product', ['slug' => $menu_product->slug]) }}"--}}
{{--                                                                data-title="{{ $menu_product->title }}"--}}
{{--                                                                data-image="{{ asset('storage/content/small-images/' . $menu_product->images[0]) }}"--}}
{{--                                                                data-url="{{ route('product', ['slug' => $menu_product->slug]) }}"--}}
{{--                                                            >--}}
{{--                                                                <img width="150"--}}
{{--                                                                     src="{{ asset('storage/content/small-images/' . $menu_product->images[0]) }}"--}}
{{--                                                                     alt="{{ $menu_product->title }}">--}}
{{--                                                                {{ $menu_product->title }}--}}
{{--                                                            </a>--}}
{{--                                                        </li>--}}
{{--                                                    @endforeach--}}
{{--                                                </ul>--}}
                                                <div class="menu_category_products">
                                                    @foreach($category->childs as $subcategory)

                                                        <ul>
                                                            @if($subcategory->subproducts->count())
                                                                <li>
                                                                    <b>{{ $subcategory->name }}</b>
                                                                    <div class="divider"></div>
                                                                </li>
                                                                @foreach($subcategory->subproducts as $menu_product)

                                                                    <li>
                                                                        <a
                                                                            href="{{ route('product', ['slug' => $menu_product->slug]) }}"
                                                                            data-title="{{ $menu_product->title }}"
                                                                            data-image="{{ asset('storage/content/small-images/' . $menu_product->images[0]) }}"
                                                                            data-url="{{ route('product', ['slug' => $menu_product->slug]) }}"
                                                                        >{{ $menu_product->title }}
                                                                            @if($menu_product->text && $menu_product->text == 'New')
                                                                                <span class="new_or_best_seller">{{ $menu_product->text }}</span>
                                                                                @elseif($menu_product->text)
                                                                                <span class="new_or_best_seller" style="background-color: #3474d4">{{ $menu_product->text }}</span>
                                                                            @endif
                                                                        </a>

                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    @endforeach
                                                </div>
                                                <ul class="d-block menu_hover_product"></ul>
                                            </li>
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="ec-mobile-menu" class="ec-side-cart ec-mobile-menu">
        <div class="ec-menu-title">
            <button class="ec-close">×</button>
            <div class="ec-header-user dropdown">
                <button class="dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa-regular fa-user" style="font-size: 25px"></i>
{{--                    <img src="{{ asset('/front/assets/images/icons/user.svg') }}"--}}
{{--                         class="svg_img header_svg" alt=""/>--}}
                </button>
                @auth
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.orders') }}">Order History</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.requests') }}">Quotes</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.addresses') }}">Address Book</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.payments') }}">Payment Methods</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.index') }}"
                               onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Logout</a>
                            <form id="frm-logout" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                @endauth
                @guest

                    <ul class="dropdown-menu dropdown-menu-right user_dropdown_block">
                        <li class="login_reg_btn"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Log In or Create Account</button></li>
                        <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>

                        <li><a class="dropdown-item" href="{{ route('profile.orders') }}">Order History</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.requests') }}">Quotes</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.addresses') }}">Address Book</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.payments') }}">Payment Methods</a></li>
                    </ul>
                @endguest
            </div>
        </div>
        <div class="header-search">
            <form class="ec-btn-group-form search_form">
                @csrf
                <input class="form-control search_input" placeholder="Enter Product Name..." type="text">
                <button class="submit">
                    <span class="header_loader"></span>
                    <img src="{{ asset('/front/assets/images/icons/search.svg') }}"
                         class="svg_img header_svg" alt="icon"/>
                </button>
            </form>
            <div class="search_results_block"></div>
        </div>
{{--        <div class="mobile_menu_icons">--}}
{{--            <a href="tel:{{ setting('call') }}">--}}
{{--                <img src="{{ asset('front/assets/images/call.svg') }}" alt="Call">--}}
{{--            </a>--}}
{{--            <a href="mailto:{{ setting('email') }}">--}}
{{--                <img src="{{ asset('front/assets/images/mail.svg') }}" alt="Email">--}}
{{--            </a>--}}
{{--            <a href="sms:{{ setting('call') }}">--}}
{{--                <img src="{{ asset('front/assets/images/sms.svg') }}" width="30" alt="SMS">--}}
{{--            </a>--}}
{{--        </div>--}}
        <div class="ec-menu-inner">
            <div class="ec-menu-content">
                <ul>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('category', ['id' => $category->id]) }}">{{ $category->name }}</a>
                            <ul class="sub-menu">
                                @foreach($category->childs as $subcategory)
                                    @if($subcategory->subproducts->count())
                                        <li>
                                            <a href="#">{{ $subcategory->name }}</a>
                                            <ul class="sub-menu">
                                                @foreach($subcategory->subproducts as $menu_product)
                                                    <li>
                                                        <a
                                                            href="{{ route('product', ['slug' => $menu_product->slug]) }}"
                                                            data-title="{{ $menu_product->title }}"
                                                            data-image="{{ asset('storage/content/' . $menu_product->images[0]) }}"
                                                            data-url="{{ route('product', ['slug' => $menu_product->slug]) }}"
                                                        >{{ $menu_product->title }}
                                                            @if($menu_product->text)
                                                                <span class="new_or_best_seller">{{ $menu_product->text }}</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="header-res-lan-curr">
                <div class="header-res-social">
                    <div class="header-top-social">
                        <ul class="mb-0">
                            @if(setting('facebook') != '#')
                                <li class="list-inline-item"><a class="hdr-facebook" href="{{ setting('facebook') }}">
                                        <i class="fa-brands fa-facebook-f sidebar_social_icon"></i></a>
                                </li>
                            @endif
                            @if(setting('twitter') != '#')
                                <li class="list-inline-item"><a class="hdr-twitter" href="{{ setting('twitter') }}">
                                        <i class="fa-brands fa-x-twitter sidebar_social_icon"></i></a>
                                </li>
                            @endif
                            @if(setting('instagram') != '#')
                                <li class="list-inline-item"><a class="hdr-instagram" href="{{ setting('instagram') }}">
                                        <i class="fa-brands fa-instagram sidebar_social_icon"></i></a>
                                </li>
                            @endif
                            @if(setting('etsy') != '#')
                                <li class="list-inline-item"><a class="hdr-linkedin" href="{{ setting('etsy') }}">
                                        <i class="fa-brands fa-etsy sidebar_social_icon"></i></a>
                                </li>
                            @endif
                            @if(setting('youtube') != '#')
                                <li class="list-inline-item"><a class="hdr-linkedin" href="{{ setting('youtube') }}">
                                        <i class="fa-brands fa-youtube sidebar_social_icon"></i></a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
