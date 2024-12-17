@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/assets/css/demo8.css') }}" />
@endpush

@section('content')

    <section class="ec-page-content section-space-p bg-white">
        <div class="container">
            <div class="row">
                <div class="ec-common-wrapper">
                    <div class="ec-contact-leftside">
                        <div class="ec-contact-container">
                            <div class="ec-contact-form">
                                <form action="#" method="post">
                                    <span class="ec-contact-wrap">
                                        <label>First Name*</label>
                                        <input type="text" name="firstname" placeholder="Enter your first name"
                                               required />
                                    </span>
                                    <span class="ec-contact-wrap">
                                        <label>Last Name*</label>
                                        <input type="text" name="lastname" placeholder="Enter your last name"
                                               required />
                                    </span>
                                    <span class="ec-contact-wrap">
                                        <label>Email*</label>
                                        <input type="email" name="email" placeholder="Enter your email address"
                                               required />
                                    </span>
                                    <span class="ec-contact-wrap">
                                        <label>Phone Number*</label>
                                        <input type="text" name="phonenumber" placeholder="Enter your phone number"
                                               required />
                                    </span>
                                    <span class="ec-contact-wrap">
                                        <label>Comments/Questions*</label>
                                        <textarea name="address"
                                                  placeholder="Please leave your comments here.."></textarea>
                                    </span>
                                    <span class="ec-contact-wrap ec-recaptcha">
                                        <span class="g-recaptcha"
                                              data-sitekey="6LfKURIUAAAAAO50vlwWZkyK_G2ywqE52NU7YO0S"
                                              data-callback="verifyRecaptchaCallback"
                                              data-expired-callback="expiredRecaptchaCallback"></span>
                                        <input class="form-control d-none" data-recaptcha="true" required
                                               data-error="Please complete the Captcha">
                                        <span class="help-block with-errors"></span>
                                    </span>
                                    <span class="ec-contact-wrap ec-contact-btn">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </span>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="ec-contact-rightside">
                        <div class="ec_contact_map">
                            <div class="ec_map_canvas">
                                <iframe id="ec_map_canvas"
                                        src="{{ setting('map_embed') }}"></iframe>
                                <a href="https://sites.google.com/view/maps-api-v2/mapv2"></a>
                            </div>
                        </div>
                        <div class="ec_contact_info">
                            <h1 class="ec_contact_info_head">Contact us</h1>
                            <ul class="align-items-center">
                                <li class="ec-contact-item">
                                    <i class="ecicon eci-map-marker" aria-hidden="true"></i>
                                    <span>Address :</span>{{ setting('address') }}
                                </li>
                                <li class="ec-contact-item align-items-center">
                                    <i class="ecicon eci-phone" aria-hidden="true"></i>
                                    <span>Call Us :</span>
                                    <a href="tel:{{ setting('call') }}">{{ setting('phone') }}</a>
                                </li>
                                <li class="ec-contact-item align-items-center">
                                    <i class="ecicon eci-envelope" aria-hidden="true"></i>
                                    <span>Email :</span>
                                    <a href="mailto:{{ setting('email') }}">{{ setting('email') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('front/assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
@endpush
