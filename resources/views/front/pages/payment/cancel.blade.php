@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/custom.css') }}">
@endpush

@section('content')

    <section class="checkout_page ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-checkout-leftside col-12 ">
                    <!-- checkout content Start -->
                    <div class="ec-checkout-content">
                        <div class="ec-checkout-inner">

                            <div class="ec-checkout-wrap margin-bottom-30">
                                <div class="ec-checkout-block">
                                    <h3 style="text-align: center;color: red;margin-bottom: 0;">Order has been canceled</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--cart content End -->
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('front/assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-md5@0.7.3/src/md5.min.js"></script>
    <script src="{{ asset('front/assets/js/custom.js') }}"></script>
@endpush
