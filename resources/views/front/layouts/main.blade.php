<!DOCTYPE html>
<html lang="en">
@include('front.partials.head')
@stack('styles')
<body>
<div id="ec-overlay"><span class="loader_img"></span></div>

@include('front.partials.header')

@if( isset($breadcrumb) )
    <div class="sticky-header-next-sec  ec-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner justify-content-sm-end">
                    <div class="col-md-6 col-sm-12 d-lg-block">
                        <h2 class="ec-breadcrumb-title">{{ $breadcrumb }}</h2>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 d-md-flex justify-content-sm-end">
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            @if(Route::currentRouteName() == 'product')
                                <li class="ec-breadcrumb-item"><a href="{{ route('category', ['id' => $product->category->id]) }}">{{ $product->category->name }}</a></li>
                                <li class="ec-breadcrumb-item active">{{ $product->title }}</li>
                            @elseif(Route::currentRouteName() == 'category')
                                <li class="ec-breadcrumb-item active">{{ $category->name }}</li>
                            @else
                                <li class="ec-breadcrumb-item active">{{ $breadcrumb }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="bg-white-color">
    @yield('content')
    @include('front.partials.login_register_modal')
</div>

@include('front.partials.footer')
@include('front.partials.foot')
@include('cookie-consent::index')
{{--<call-us-selector phonesystem-url="https://1738.3cx.cloud" party="yansprint"></call-us-selector>--}}
@stack('scripts')


{{--<!-- Start of HubSpot Embed Code --> <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/46673043.js"></script> <!-- End of HubSpot Embed Code -->--}}
{{--<script defer src="https://downloads-global.3cx.com/downloads/livechatandtalk/v1/callus.js" id="tcx-callus-js" charset="utf-8"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/luxon@2.0.2/build/global/luxon.min.js"></script>

<script>
    @if (session('openModal') === 'login')
        document.addEventListener('DOMContentLoaded', function() {
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        });
    @elseif(session('openModal') === 'register')
        document.addEventListener('DOMContentLoaded', function() {
            const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
            registerModal.show();
        });
    @else
        document.addEventListener('DOMContentLoaded', function() {
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.hide();
            const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
            registerModal.hide();
        });
    @endif
    // show chat only on workdays and times
    function isWithinWorkingHours() {
        const timeZone = 'America/Los_Angeles'
        const now = luxon.DateTime.now().setZone(timeZone);
        const day = now.weekday; // 1 (Monday) to 7 (Sunday)
        const hours = now.hour;
        const minutes = now.minute;

        // Check if it's a weekday (Monday to Friday)
        const isWeekday = day >= 1 && day <= 5;

        // Check if it's within working hours (9:30 AM to 4:30 PM)
        const isWorkingTime = (hours === 9 && minutes >= 30) || (hours > 9 && hours < 16) || (hours === 16 && minutes === 0);

        return isWeekday && isWorkingTime;
    }

    // Load the HubSpot script if within working hours
    if (isWithinWorkingHours()) {
        const script = document.createElement('script');
        script.type = 'text/javascript';
        script.id = 'hs-script-loader';
        script.async = true;
        script.defer = true;
        script.src = '//js.hs-scripts.com/46673043.js';
        document.body.appendChild(script);
    }
    // Function to force landscape mode
    function lockOrientation() {
        if (screen.orientation && screen.orientation.lock) {
            if (screen.width < 750) {
                // Lock orientation to portrait for devices with width less than 750px
                screen.orientation.lock("portrait").catch(function(error) {
                    console.warn("Could not lock orientation: " + error);
                });
            } else {
                // Lock orientation to landscape for devices with width greater than 750px
                screen.orientation.lock("landscape").catch(function(error) {
                    console.warn("Could not lock orientation: " + error);
                });
            }
        } else {
            console.warn("Screen orientation API not supported.");
        }
    }

    $(document).ready(function () {

        $(document).mouseup(function(e)
        {
            var search_results_block = $(".search_results_block");

            if (!search_results_block.is(e.target) && search_results_block.has(e.target).length === 0)
            {
                search_results_block.html('')
            }
        });

        var delayTimer;
        $(document).on('input', '.search_input', function (){
            let _token = $(this).parents('form').find('[name=_token]').val(),
                text = $(this).val()

            clearTimeout(delayTimer);
            if(text.length>=3){
                $('.header_loader').show();
                delayTimer = setTimeout(() => {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('search') }}",
                        data: {
                            _token,
                            text
                        },
                        success: function (data) {
                            if(data.success){
                                $('.search_results_block').html(data.html);
                                $('.header_loader').hide();
                            }
                        }
                    });
                }, 1000);
            }else{
                $('.search_results_block').html('');
                $('.header_loader').hide();
            }
        })

        $(document).on('submit', '.search_form', function (e){
            e.preventDefault()
            let _token = $(this).find('[name=_token]').val(),
                text = $(this).find('.search_input').val()

            if(text.length){
                $('.header_loader').show();
                $.ajax({
                    type: "POST",
                    url: "{{ route('search') }}",
                    data: {
                        _token,
                        text
                    },
                    success: function (data) {
                        if(data.success){
                            $('.search_results_block').html(data.html);
                            $('.header_loader').hide();
                        }
                    }
                });
            }else{
                $('.search_results_block').html('');
                $('.header_loader').hide();
            }
        })

        /*--------------------- header alerts owl Slider -------------------------------- */
        const swiper = new Swiper('.alert_carousel', {
            loop: true,
            speed: 500,
            effect: "slide",
            autoplay: {
                delay: 7000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });

    $(document).on('mouseover', '.menu_category_products li a, .menu_products li a', function () {
        let url = $(this).attr('data-url'),
            image = $(this).attr('data-image'),
            title = $(this).attr('data-title')
        $('.menu_hover_product').html('<li><a href="' + url + '"><img src="' + image + '" alt="' + title + '"><button class="btn btn-primary layer shop_btn" type="button">SHOP NOW</button>' + title + '</a></li>')
    })

    function updateCountdown(endTime) {
        var now = new Date().getTime();
        var distance = endTime - now;

        if (distance <= 0) {
            $('#countdown').text("Expired");
            return;
        }

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        $('.countdown').html(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
    }

    // Example usage:
    $(document).ready(function() {
        if($('.timer_slider').length > 0){
            var t = $(".timer_slider").val();
            var dateObject = new Date(t);
            // Set the end time (replace this with your end time)
            var endTime = dateObject.getTime();

            // Update the countdown timer every second
            setInterval(function() {
                updateCountdown(endTime);
            }, 1000);
        }

    });
</script>
</body>
</html>
