@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/checkout.css') }}">
    <style>
        .shipment_provider_description{
            margin-bottom:0;
        }
    </style>
@endpush

@section('content')

    <section class="checkout_page ec-page-content section-space-p">
        <div class="container">
            <input type="hidden" name="default_tax_rate" class="default_tax_rate" value="<?= $tax_rate;?>"/>
            <div class="row">
                <div class="col-md-8">
                    <h2 class="checkout_heading"><span class="checkout_step checkout_step_1 active">1</span>Upload your files
                        <i class="edit_filled_tab fa-regular fa-pen-to-square d-none" onclick="toggleSection(event, 'checkout_section_1')"></i>
                    </h2>
                    <section class="checkout_section checkout_section_1">
                        {{--                        <a class="btn btn-primary m-3" href="{{ route('processTransaction') }}">Pay $1000</a>--}}
                        {{--                        @if(\Session::has('error'))--}}
                        {{--                            <div class="alert alert-danger">{{ \Session::get('error') }}</div>--}}
                        {{--                            {{ \Session::forget('error') }}--}}
                        {{--                        @endif--}}
                        @if(\Session::has('success'))
                            <div class="alert alert-success">{{ \Session::get('success') }}</div>
                            {{ \Session::forget('success') }}
                        @endif
                        <div class="upload_files">
                            <div class="upload_files_types">
                                <input id="order_type_1" type="radio" name="type" value="Upload Print Ready Files"/>
                                <label for="order_type_1" class="upload_files_type upload_type_1">
                                    <span class="upload_type_image"></span>
                                    <span class="upload_type_text">Upload Print Ready Files</span>
                                </label>
                                <input id="order_type_2" type="radio" name="type" value="Order Now Upload Later"/>
                                <label for="order_type_2" class="upload_files_type upload_type_2">
                                    <span class="upload_type_image"></span>
                                    <span class="upload_type_text">Order Now Upload Later</span>
                                </label>
                                <input id="order_type_3" type="radio" name="type" value="Help with Artwork"/>
                                <label for="order_type_3" class="upload_files_type upload_type_3">
                                    <span class="upload_type_image"></span>
                                    <span class="upload_type_text">Help with Artwork</span>
                                </label>
                            </div>

                            <form id="upload_type_1_form" class="upload_type_form" method="POST" action=""
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6" style="position: relative">
                                        <div class="form-group mb-3">
                                            <h6>Select files <i class="fa-regular fa-circle-question tooltipIcon"></i></h6>
                                            <div class="tooltip-wrapper">
                                                <div style="padding:18px; background:#fff; color: #000">
                                                    <div style="background:#fff;color: black;">
                                                        <div>
                                                            <p><span style="font-weight: 800">What are the recommended file formats?</span><br>
                                                                <span>PDF, JPG, JPEG, PSD, PNG, TIF, TIFF, EPS, Illustrator, Publisher, DOCX, DOC, XLS, XLSX. PPT, PPTX, TXT, CSV, BMP, GIF, SVG, ZIP</span>
                                                            </p>
                                                            <p><span style="font-weight: 800">What is the maximum allowed file size to upload?</span><br>
                                                                <span>600 MB. If your file is larger than 600 MB, please contact <a class="text-primary" href="{{route('contact')}}">Customer Service</a> for assistance.</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="file" name="files[]" accept="/*" multiple
                                                   class="checkout_image"/>
                                            <div class="text-danger small error"></div>
                                        </div>
                                        <div class="progress_bars"></div>
                                        <div class="uploaded_images mb-3"></div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Job name / PO<span class="required-field">*</span></label>
                                            <input name="job_name" type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Project Notes<span class="required-field">*</span></label>
                                            <textarea name="notes" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="ec-new-option mb-2">
                                            <h6>Do you need help with file?</h6>
                                            <div class="checkout_radio_block">
                                                <input type="radio" id="help_with_file_4" name="help_with_file"
                                                       value="No, our design team is working on it." checked>
                                                <label for="help_with_file_4">No, our design team is working on
                                                    it.</label>
                                            </div>
                                            <div class="checkout_radio_block">
                                                <input type="radio" id="help_with_file_5" name="help_with_file"
                                                       value="YES (minor changes)">
                                                <label for="help_with_file_5">YES (minor changes)</label>
                                            </div>
                                            <div class="checkout_radio_block">
                                                <input type="radio" id="help_with_file_6" name="help_with_file"
                                                       value="YES (design from scratch)">
                                                <label for="help_with_file_6">YES (design from scratch)</label>
                                            </div>
                                            <div class="form-group help_with_file_textarea">
                                                <textarea name="changes" class="form-control"
                                                          placeholder="Type the changes here"></textarea>
                                            </div>
                                        </div>
                                        <div class="ec-new-option">
                                            <h6>Proofing Options?</h6>
                                            <div class="checkout_radio_block">
                                                <input type="radio" id="proofing_options_4" name="proofing_options"
                                                       value='NO proof needed, "print as is"'>
                                                <label for="proofing_options_4">NO proof needed, "print as is"</label>
                                            </div>
                                            <div class="checkout_radio_block">
                                                <input type="radio" id="proofing_options_5" name="proofing_options"
                                                       value="YES (online PDF proof)"
                                                       checked>
                                                <label for="proofing_options_5">YES (online PDF proof)</label>
                                            </div>
                                            <div class="checkout_radio_block">
                                                <input type="radio" id="proofing_options_6" name="proofing_options"
                                                       value="YES (hard copy proof)">
                                                <label for="proofing_options_6">YES (hard copy proof)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid my-4">
                                    <button class="btn btn-primary checkout_step_1_submit">Continue</button>
                                </div>
                            </form>
                            <form id="upload_type_2_form" class="upload_type_form" method="POST" action=""
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Job name / PO<span class="required-field">*</span></label>
                                            <input name="job_name" type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Project Notes<span class="required-field">*</span></label>
                                            <textarea name="notes" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="ec-new-option mb-2">
                                            <h6>Do you need help with file?</h6>
                                            <div class="checkout_radio_block">
                                                <input type="radio" id="help_with_file_1" name="help_with_file"
                                                       value="No, our design team is working on it."
                                                       checked>
                                                <label for="help_with_file_1">No, our design team is working on
                                                    it.</label>
                                            </div>
                                            <div class="checkout_radio_block">
                                                <input type="radio" id="help_with_file_2" name="help_with_file"
                                                       value="YES (minor changes)">
                                                <label for="help_with_file_2">YES (minor changes)</label>
                                            </div>
                                            <div class="checkout_radio_block">
                                                <input type="radio" id="help_with_file_3" name="help_with_file"
                                                       value="YES (design from scratch)">
                                                <label for="help_with_file_3">YES (design from scratch)</label>
                                            </div>
                                            <div class="form-group ">
                                                <textarea name="changes" class="form-control"
                                                          placeholder="Type the changes here"></textarea>
                                            </div>
                                        </div>
                                        <div class="ec-new-option">
                                            <h6>Proofing Options?</h6>
                                            <div class="checkout_radio_block">
                                                <input type="radio" id="proofing_options_1" name="proofing_options"
                                                       value='NO proof needed, "print as is"'>
                                                <label for="proofing_options_1">NO proof needed, "print as is"</label>
                                            </div>
                                            <div class="checkout_radio_block">
                                                <input type="radio" id="proofing_options_2" name="proofing_options"
                                                       value="YES (online PDF proof)"
                                                       checked>
                                                <label for="proofing_options_2">YES (online PDF proof)</label>
                                            </div>
                                            <div class="checkout_radio_block">
                                                <input type="radio" id="proofing_options_3" name="proofing_options"
                                                       value="YES (hard copy proof)">
                                                <label for="proofing_options_3">YES (hard copy proof)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid my-4">
                                    <button class="btn btn-primary checkout_step_1_submit">Continue</button>
                                </div>
                            </form>
                            <form id="upload_type_3_form" class="upload_type_form" method="POST" action=""
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <h6>Select files <i class="fa-regular fa-circle-question tooltipIcon"></i></h6>
                                            <div class="tooltip-wrapper">
                                                <div style="padding:18px; background:#fff; color: #000">
                                                    <div style="background:#fff;color: black;">
                                                        <div>
                                                            <p><span style="font-weight: 800">What are the recommended file formats?</span><br>
                                                                <span>PDF, JPG, JPEG, PSD, PNG, TIF, TIFF, EPS, Illustrator, Publisher, DOCX, DOC, XLS, XLSX. PPT, PPTX, TXT, CSV, BMP, GIF, SVG, ZIP</span>
                                                            </p>
                                                            <p><span style="font-weight: 800">What is the maximum allowed file size to upload?</span><br>
                                                                <span>600 MB. If your file is larger than 600 MB, please contact <a class="text-primary" href="{{route('contact')}}">Customer Service</a> for assistance.</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="file" name="files[]" accept="/*" multiple
                                                   class="checkout_image"/>
                                            <div class="text-danger small error"></div>
                                        </div>
                                        <div class="progress_bars"></div>
                                        <div class="uploaded_images mb-3"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Job name / PO<span class="required-field">*</span></label>
                                            <input name="job_name" type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Project Notes<span class="required-field">*</span></label>
                                            <textarea name="notes" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid my-4">
                                    <button class="btn btn-primary checkout_step_1_submit">Continue</button>
                                </div>
                            </form>

                        </div>
                    </section>

                    <h2 class="checkout_heading">
                        <span class="checkout_step checkout_step_2">2</span>
                        Contact Information
                        <i class="edit_filled_tab fa-regular fa-pen-to-square d-none" onclick="toggleSection(event, 'checkout_section_2')"></i>
                    </h2>
                    <section class="checkout_section checkout_section_2">
                        @auth
                            <form id="user_checkout_form" method="POST" action="" style="display: block">
                                <div class="step_two_old_values"></div>
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Full name<span class="required-field">*</span></label>
                                            <input name="name" type="text" class="form-control"
                                                   value="{{ auth()->user()->name ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Company name</label>
                                            <input name="company" type="text" class="form-control"
                                                   value="{{ auth()->user()->company ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Email<span class="required-field">*</span></label>
                                            <input name="email" type="email" class="form-control"
                                                   value="{{ auth()->user()->email ?? '' }}">
                                            <div class="invalid-feedback">
                                                Please enter valid email.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Phone<span class="required-field">*</span></label>
{{--                                            <input type="hidden" name="phone_full">--}}
{{--                                            <input type="hidden" name="country_code">--}}
                                            <input name="phone" type="tel" class="form-control phone"
                                                   value="{{ auth()->user()->phone ?? '' }}" id="user_checkout_form_phone">
                                            <div class="invalid-feedback error-msg">
                                                Please enter valid phone number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid my-4">
                                    <button class="btn btn-primary user_checkout_submit checkout_step_2_submit">Continue</button>
                                </div>
                            </form>
                        @else
                            <div class="upload_files_types">
                                <input id="contact_type_1" type="radio" name="contact_type" value="Guest Checkout"
                                       checked/>
                                <label for="contact_type_1" class="upload_files_type contact_type_1">
                                    <span class="upload_type_image"></span>
                                    <span class="upload_type_text">Guest Checkout</span>
                                </label>
                                <input id="contact_type_2" type="radio" name="contact_type" value="Sign In"/>
                                <label for="contact_type_2" class="upload_files_type contact_type_2">
                                    <span class="upload_type_image"></span>
                                    <span class="upload_type_text">Sign In</span>
                                </label>
                                <input id="contact_type_3" type="radio" name="contact_type" value="Create an Account"/>
                                <label for="contact_type_3" class="upload_files_type contact_type_3">
                                    <span class="upload_type_image"></span>
                                    <span class="upload_type_text">Create an Account</span>
                                </label>
                            </div>

                            <form id="guest_checkout_form" class="contact_checkout_form" method="POST" action=""
                                  style="display: block">
                                @csrf
                                <div class="step_two_old_values"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Full Name<span class="required-field">*</span></label>
                                            <input name="name" type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Email<span class="required-field">*</span></label>
                                            <input name="email" type="email" class="form-control">
                                            <div class="invalid-feedback">
                                                Please enter valid email.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Company Name</label>
                                            <input name="company" type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Phone<span class="required-field">*</span></label>
                                            <input name="phone" type="tel" class="form-control phone" id="guest_checkout_form_phone">
                                            <div class="invalid-feedback error-msg">
                                                Please enter valid phone number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid my-4">
                                    <button class="btn btn-primary checkout_step_2_submit">Continue</button>
                                </div>
                            </form>

                            <form id="login_checkout_form" class="contact_checkout_form" method="POST" action="">
                                @csrf
                                <div class="step_two_old_values"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Email<span class="required-field">*</span></label>
                                            <input name="email" type="email" class="form-control">
                                            <div class="invalid-feedback">
                                                Please enter valid email.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Password<span class="required-field">*</span></label>
                                            <input name="password" type="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid my-4">
                                    <button class="btn btn-primary">Continue</button>
                                </div>
                            </form>

                            <form id="after_login_checkout_form" class="contact_checkout_form" method="POST" action="">
                                @csrf
                                <div class="after_login_old_values"></div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Full Name<span class="required-field">*</span></label>
                                            <input name="name" type="text" class="form-control after_login_name" value="">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Company name</label>
                                            <input name="company" type="text" class="form-control after_login_company" value="">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Email<span class="required-field">*</span></label>
                                            <input name="email" type="email" class="form-control after_login_email" value="">
                                            <div class="invalid-feedback">
                                                Please enter valid email.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Phone<span class="required-field">*</span></label>
                                            <input name="phone" type="tel" class="form-control after_login_phone phone" value="" id="login_checkout_form_phone">
                                            <div class="invalid-feedback error-msg">
                                                Please enter valid phone number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid my-4">
                                    <button class="btn btn-primary checkout_step_2_submit">Continue</button>
                                </div>
                            </form>

                            <form id="register_checkout_form" class="contact_checkout_form" method="POST" action="">
                                @csrf
                                <div class="step_two_old_values"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Full name<span class="required-field">*</span></label>
                                            <input name="name" type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Email<span class="required-field">*</span></label>
                                            <input name="email" type="email" class="form-control">
                                            <div class="invalid-feedback">
                                                Please enter valid email.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Company name</label>
                                            <input name="company" type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Phone<span class="required-field">*</span></label>
                                            <input name="phone" type="tel" class="form-control phone" id="register_checkout_form_phone">
                                            <div class="invalid-feedback error-msg">
                                                Please enter valid phone number.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Password<span class="required-field">*</span></label>
                                            <input name="password" type="password" class="form-control">
                                            <div class="invalid-feedback">
                                                The password must be at least 8 characters.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Password Confirmation<span class="required-field">*</span></label>
                                            <input name="confirm_password" type="password" class="form-control">
                                            <div class="invalid-feedback">
                                                The confirm password and password must match.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="register_errors"></ul>
                                    </div>
                                </div>
                                <div class="d-grid my-4">
                                    <button class="btn btn-primary">Continue</button>
                                </div>
                            </form>
                        @endauth
                    </section>

                    <h2 class="checkout_heading"><span class="checkout_step checkout_step_3">3</span>Delivery
                        <i class="edit_filled_tab fa-regular fa-pen-to-square d-none" onclick="toggleSection(event, 'checkout_section_delivery')"></i>
                    </h2>
                    <section class="checkout_section checkout_section_delivery">
                        <div class="swiper-container">
                            <!-- Add Pagination -->
                            <div class="swiper-pagination">
                            </div>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="pickup_section">
                                        <div class="pickup_heading">Location</div>
                                        <div class="pickup_left">
                                            <div class="pickup_address_block">
                                                <p class="pickup_address">{{ setting('address') }}</p>
                                                <a href="{{ setting('map_link') }}" class="pickup_direction"
                                                   target="_blank">Get Direction</a>
                                            </div>
                                            <div class="pickup_heading">Hours Of Operation</div>
                                            <p class="pickup_working_days">Monday 9:00AM - 6:00PM
                                                Tuesday 9:00AM - 6:00PM
                                                Wednesday 9:00AM - 6:00PM
                                                Thursday 9:00AM - 6:00PM
                                                Friday 9:00AM - 6:00PM
                                                Saturday Closed
                                                Sunday Closed</p>
                                        </div>
                                        <div class="pickup_map">
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3299.370806978807!2d-118.45333039999998!3d34.213549199999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2976c67c9d12d%3A0x1a077e43c00e9e3c!2sYans%20Print!5e0!3m2!1sen!2s!4v1671570250290!5m2!1sen!2s"
                                                width="100%" height="300" style="border:0;" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>
                                    </div>
                                </div>
                                @if(isset($product->shipping_info))
                                    <div class="swiper-slide">
                                    <div class="checkout_delivery_block">
                                        <div class="pickup_heading">Your Address Book</div>
                                        @guest
                                            <form action="" class="guest_address_form row mb-3">
                                                <div class="col-md-8 mt-3">
                                                    <label class="form-label">Address<span class="required-field">*</span></label>
                                                    <input type="text" name="address" class="form-control" autocomplete="false" id="address">
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="form-label">Unit/Apartment/Suite</label>
                                                    <input type="text" name="unit" class="form-control">
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="form-label">ZIP<span class="required-field">*</span></label>
                                                    <input type="text" name="zip" class="form-control">
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="form-label">City<span class="required-field">*</span></label>
                                                    <input type="text" name="city" class="form-control">
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="form-label">State<span class="required-field">*</span></label>
                                                    <input type="text" name="state" class="form-control">
                                                </div>



                                            </form>
                                        @else
                                            <div class="delivery_logged_in row">
                                                <?php $addresses = auth()->user()->addresses; ?>

                                                @if(count($addresses))

                                                    @foreach($addresses as $address)
                                                        <div class="col-md-6">

                                                            <div
                                                                class="profile_address {{ $address->default ? 'default' : '' }}"
                                                                data-id="{{ $address->id }}">

                                                                <p><b>Name:</b> {{ $address->name }}</p>
                                                                @if($address->company)
                                                                    <p><b>Company:</b> {{ $address->company }}</p>
                                                                @endif
                                                                <p><b>Email:</b> {{ $address->email }}</p>
                                                                <p><b>Phone:</b> {{ $address->phone }}</p>
                                                                <p><b>Address:</b> {{ $address->address }}</p>
                                                                <p><b>Unit/Apartment/Suite:</b> {{ $address->unit }}</p>
                                                                <p><b>City:</b> {{ $address->city }}</p>
                                                                <p><b>State:</b> {{ $address->state }}</p>
                                                                <p><b>ZIP:</b> {{ $address->zip }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <div class="col-md-6 checkout_add_address_block">
                                                    <div class="profile_address add">
                                                        <a href="javascript:void(0)" class="create_order_address">
                                                            <i class="ecicon eci-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="" class="order_new_address_form row">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                                <div class="col-md-4 mt-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Name<span class="required-field">*</span></label>
                                                        <input type="text" name="name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Email<span class="required-field">*</span></label>
                                                        <input type="email" name="email" class="form-control">
                                                        <div class="invalid-feedback">
                                                            Please enter valid email.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Phone<span class="required-field">*</span></label>
                                                        <input type="tel" name="phone" class="form-control phone" id="order_new_address_form_phone">
                                                        <div class="invalid-feedback error-msg">
                                                            Please enter valid phone number.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 mt-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Address<span class="required-field">*</span></label>
                                                        <input type="text" name="address" class="form-control" id="address" autocomplete="false">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Unit/Apartment/Suite</label>
                                                        <input type="text" name="unit" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <div class="form-group">
                                                        <label class="form-label">ZIP<span class="required-field">*</span></label>
                                                        <input type="text" name="zip" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <div class="form-group">
                                                        <label class="form-label">City<span class="required-field">*</span></label>
                                                        <input type="text" name="city" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <div class="form-group">
                                                        <label class="form-label">State<span class="required-field">*</span></label>
                                                        <input type="text" name="state"  class="form-control">
                                                    </div>
                                                </div>



                                                <div class="col-md-4 mt-3">
                                                    <button class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        @endif
                                        <button class="btn btn-primary delivery_lists">Submit address</button>

                                        <form class="rate_list_form">
                                            <h6><em>Submit your address to see the possible providers</em></h6>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <button class="btn btn-primary delivery_continue checkout_step_3_submit">Continue</button>
                    </section>

                    <h2 class="checkout_heading">
                        <span class="checkout_step checkout_step_4">4</span>
                        Payment
                        <i class="edit_filled_tab fa-regular fa-pen-to-square d-none" onclick="toggleSection(event, 'checkout_section_3')"></i>
                    </h2>
                    <section class="checkout_section checkout_section_3">
                        <form id="place_order_form" action="{{ route('processTransaction') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="hidden" class = "shipping_provider_id" name="shipping_provider_id" value="">

                            <input type="hidden" class = "shipping_provider" name="shipping_provider" value="">
                            <input type="hidden" class="shipping_price" name="shipping_price" value="0">
                            <input type="hidden" name="address_id" class="address_id" value="">
<input type="hidden" class="delivery_type" name="delivery_type" value="pickup"/>
                            <div class="place_order_form_old_values"></div>
                            <div class="ec-new-option mb-2">
                                <h6>Please select payment method</h6>
                                @if(auth()->user() && in_array(auth()->user()->role_id, [\App\Enums\UserRoles::SUPER_ADMIN,\App\Enums\UserRoles::MANAGER]))
                                <div class="flex align-items-center">
                                    <input type="radio" id="cash" value="cash" name="payment_type">
                                    <label for="cash" style="color: #3474d4;font-size: 18px;font-weight: bold;">
                                        Cash
                                    </label>
                                </div>
                                <div class="flex align-items-center">
                                    <input type="radio" id="terminal" value="terminal" name="payment_type">
                                    <label for="terminal" style="color: #3474d4;font-size: 18px;font-weight: bold;">
                                        Terminal
                                    </label>
                                </div>
                                @endif
                                <div class="flex align-items-center">
                                    <input type="radio" id="paypal" value="paypal" name="payment_type">
                                    <label for="paypal">
                                        <img src="{{ asset('front/assets/images/checkout/paypal.webp' ) }}" alt="PayPal"
                                             width="100">
                                    </label>
                                </div>
                                <div class="flex align-items-center">
                                    <input type="radio" id="stripe" value="stripe" name="payment_type" checked>
                                    <label for="stripe">
                                        <img src="{{ asset('front/assets/images/checkout/cards_image.png' ) }}"
                                             alt="PayPal" width="200">
                                    </label>
                                </div>
                            </div>

                            <div class="stripe_inputs">
                                <div class="row show_card_info">
                                    @if(auth()->user() && !in_array(auth()->user()->role_id, [\App\Enums\UserRoles::SUPER_ADMIN,\App\Enums\UserRoles::MANAGER]))
                                        @include('front.partials.card_view', ['cards' => auth()->user()->getSavedCards()])
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Card Number<span class="required-field">*</span></label>
                                            <input name="card_no" type="text" class="form-control card_no">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Exp. Month<span class="required-field">*</span></label>
                                            <input name="exp_month" type="number" class="form-control exp_month">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Exp. Year<span class="required-field">*</span></label>
                                            <input name="exp_year" type="number" class="form-control exp_year">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">CVC<span class="required-field">*</span></label>
                                            <input name="cvc" type="number" class="form-control cvc">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sww" style="font-size: 14px;color: red"></div>
                            <div class="d-grid my-4">
                                <button class="btn btn-primary place_order">Place Order</button>
                            </div>
                        </form>
                    </section>
                </div>

                <div class="col-md-4">
<?php
                    $total = $result['price'];
                    ?>
                    <h5>{{ $product->title }}</h5>
                    <img src="{{ asset('storage/content/' . $product->images[0]) }}" alt="{{ $product->title }}"
                         width="200">
                    <table class="checkout_right w-100 mt-3" style="line-height:30px">
                        @foreach($result['types'] as $key=>$type)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $type }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>Quantity</td>
                            <input type="hidden" name="qty" value="{{ $result['quantity'] }}"/>
                            <td>{{ $result['quantity'] }}</td>
                        </tr>
                        @if(isset($delivery) && $delivery !== false)
                            <tr>
                                <td>Turnaround</td>
                                <td>{{ $delivery->title }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>Price</td>
                            <input type="hidden" id="total_price" name="total_price" value="{{ number_format($result['price'],2)}}"/>
                            <td>${{ number_format($total, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td>Shipping</td>
                            <td class="shipping_cost">${{ $shipping }}</td>
                        </tr>
                        @if(!empty($result['coupon']))
                            <tr>
                                <td>Coupon</td>
                                <td>{{ $result['coupon']['name'] }} ({{ $result['coupon']['percent'] }}%)</td>
                            </tr>
                        @endif
                        <tr style="border-top: 1px solid">
                            <input type="hidden" name="tax" id="tax_rate" value="0"/>
                            <td>Tax</td>
                            <td>$<span  id="tax_amount">0.00</span></td>
                        </tr>
                        <tr style="border-top: 1px solid;font-size: 20px;font-weight: bold;">
                            <td>Total</td>
                            <td class="total_cost" data-total="{{$total}}">${{ number_format($total, 2, '.', '') }}</td>
                        </tr>
                    </table>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.1.2/js/swiper.min.js"></script>--}}
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDn1gU-9ENcDEK5IsuwJNVgrtqnwRHddMc&country=US&sensor=false&libraries=places&language=en-AU"></script>
    <script>
        var options = {
            componentRestrictions: { country: ['us', 'ca'] } // Restrict to USA and Canada
        };
        var autocomplete = new google.maps.places.Autocomplete($("#address")[0], options);

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
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
            $("input[name='zip']").val(addressInfo.zipCode);
            $("input[name='address']").val(addressInfo.address);
            $("input[name='unit']").val(addressInfo.unitNumber);
            $("input[name='state']").val(addressInfo.state);
            $("input[name='city']").val(addressInfo.city);

        });

        const phoneInputs = document.querySelectorAll(".phone");
        var intlTelInputs = {};

        phoneInputs.forEach(function(input) {
            intlTelInputs[input.id] = window.intlTelInput(input, {
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/utils.js?1712488050476",
                i18n: {
                    ca: "Canada",
                    us: "United States",
                },
                onlyCountries: ["ca", "us"],
                initialCountry: "us",
                countrySearch: false,
                formatOnDisplay:true,
                autoPlaceholder:"polite",
                showSelectedDialCode: true,
            });
        });

    </script>

    <script>
        const swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                bulletClass: 'swiper-pagination-bullet',
                bulletActiveClass: 'swiper-pagination-bullet-active',
                renderBullet: function (index, className) {
                    var tabsName = ['PICKUP', 'SHIPPING'];
                    if (index === (tabsName.length - 1)) {
                        return '<span class="' + className + ' ' + tabsName[index].toLowerCase() + '_tab_item">'
                            + tabsName[index] + '</span>'
                            + '<div class="active-mark"></div>';
                    }
                    return '<span class="' + className + ' ' + tabsName[index].toLowerCase() + '_tab_item">'
                        + tabsName[index] + '</span>';
                },
            },
            allowTouchMove: false,
            simulateTouch: false,
        });

        $('.checkout_section_delivery').hide()

        function toggleSection(event, sectionId) {
            const currentHeading = event.currentTarget.parentNode;

            const sections = document.querySelectorAll('.checkout_section');
            sections.forEach(section => {
                if (section.classList.contains(sectionId)) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });

            const headings = document.querySelectorAll('.checkout_heading .checkout_step');
            headings.forEach(heading => {
                heading.classList.remove('active');
            });

            const checkoutStep = currentHeading.querySelector('.checkout_step');
            checkoutStep.classList.add('active');
        }

        $(function () {
            $(document).ready(function () {

                var Upload = function (file, progressBar, uploadedImages) {
                    this.file = file;
                    this.progressBar = progressBar;
                    this.uploadedImages = uploadedImages;
                };

                Upload.prototype.getType = function () {
                    return this.file.type;
                };
                Upload.prototype.getSize = function () {
                    return this.file.size;
                };
                Upload.prototype.getName = function () {
                    return this.file.name;
                };
                Upload.prototype.validateFileSize = function () {
                    var maxSize = 629145600; // 600MB in bytes
                    var fileSize = this.getSize();
                    return fileSize <= maxSize;
                };
                Upload.prototype.doUpload = function () {
                    let that = this;
                    return new Promise(function (resolve, reject) {
                        let formData = new FormData();

                        formData.append("image", that.file, that.getName());
                        formData.append("product_title", '{{$product->title}}');
                        formData.append("order_id", '{{$order->id}}');
                        formData.append("upload_file", true);
                        formData.append("resize", true);
                        formData.append("_token", '{{ csrf_token() }}');
                        that.progressBar.append('<div id="progress-wrp"><div class="progress-bar"></div><div class="status">0%</div></div>');

                        $.ajax({
                            type: "POST",
                            url: "{{ route('upload_images') }}",
                            xhr: function () {
                                var myXhr = $.ajaxSettings.xhr();
                                if (myXhr.upload) {
                                    myXhr.upload.addEventListener('progress', that.progressHandling, false);
                                }
                                return myXhr;
                            },
                            success: function (data) {
                                that.uploadedImages.append(data.image);
                                let progress_bar_id = "#progress-wrp";
                                $(progress_bar_id + " .progress-bar").css("width", +100 + "%");
                                $(progress_bar_id + " .status").text(100 + "%");
                                $(progress_bar_id).remove();
                                resolve(data);
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                reject(errorThrown);
                            },
                            async: true,
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            timeout: 60000
                        });
                    });
                };

                Upload.prototype.progressHandling = function (event) {
                    let percent = 0,
                        position = event.loaded || event.position,
                        total = event.total,
                        progress_bar_id = "#progress-wrp"

                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 97);
                    }
                    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
                    $(progress_bar_id + " .status").text(percent + "%");
                    if (percent === 100) {
                        $(progress_bar_id).remove()
                    }
                };

                $(".checkout_image").on("change", async function (e) {
                    let files = $(this)[0].files;
                    let parentTab = $(this).closest('.upload_type_form');
                    let progressBar = parentTab.find('.progress_bars');
                    let uploadedImages = parentTab.find('.uploaded_images');
                    let errorBlock = $(this).next('.error');
                    errorBlock.empty();

                    for (const [key, val] of Object.entries(files)) {
                        let upload = new Upload(val, progressBar, uploadedImages);
                        if (upload.validateFileSize()) {
                            try {
                                await upload.doUpload();
                            } catch (error) {
                                errorBlock.text("An error occurred while uploading the file: " + error);
                                break;
                            }
                        } else {
                            errorBlock.text("Uploaded file is too large. Max File size is 600Mb");
                        }
                    }

                    $(this).val('');
                });

                $(document).on('change', 'input[name=type]', function () {
                    $('.upload_type_form').hide()
                    let val = $(this).val()
                    if (val === 'Upload Print Ready Files') {
                        $('#upload_type_1_form').show()
                    } else if (val === 'Order Now Upload Later') {
                        $('#upload_type_2_form').show()
                    } else {
                        $('#upload_type_3_form').show()
                    }
                })

                $(document).on('change', 'input[name=contact_type]', function () {
                    $('.contact_checkout_form').hide()
                    let val = $(this).val()
                    if (val === 'Guest Checkout') {
                        $('#guest_checkout_form').show()
                    } else if (val === 'Sign In') {
                        $('#login_checkout_form').show()
                    } else {
                        $('#register_checkout_form').show()
                    }
                })

                $(document).on('change', 'input[name=help_with_file]', function () {
                    // $('.contact_checkout_form').hide()
                    let val = $(this).val()
                    if (val === 'YES (minor changes)' || val === 'YES (design from scratch)') {
                        $('.help_with_file_textarea').show()
                    } else {
                        $('.help_with_file_textarea').hide()
                    }
                })

                $(document).on('click', '.checkout_step_1_submit', function (e) {
                    e.preventDefault()
                    let errors = 0,
                        job_name = $(this).parents('form').find('[name=job_name]'),
                        notes = $(this).parents('form').find('[name=notes]')

                    if (job_name.val().trim().length) {
                        job_name.removeClass('error')
                    } else {
                        job_name.addClass('error')
                        errors = 1
                    }

                    if (notes.val().trim().length) {
                        notes.removeClass('error')
                    } else {
                        notes.addClass('error')
                        errors = 1
                    }

                    if (errors){
                        const firstErrorElement = $(this).parents('form').find('.error:first');
                        const ecHeaderElement = document.querySelector('.ec-header');
                        const ecHeaderHeight = ecHeaderElement.offsetHeight;
                        if (firstErrorElement.length) {
                            $('html, body').animate({
                                scrollTop: firstErrorElement[0].offsetTop - ecHeaderHeight - 50
                            }, 200);
                        }
                    }else {
                        $('.checkout_step').removeClass('active')
                        $('.checkout_step_2').addClass('active')
                        $('.checkout_section_1').hide()
                        $('.checkout_section_2').show()
                        $('.checkout_step_1').siblings('.edit_filled_tab').removeClass('d-none');
                    }
                })

                function checkError(field) {
                    let errors = 0;

                    if (field.length >= 1) {
                        field.each(function () {
                            const value = $(this).val().trim();
                            const fieldName = $(this).attr('name');
                            // Clear previous error state
                            $(this).removeClass('error is-invalid');
                            $(this).closest('.form-group').find('.invalid-feedback').hide();
                            // Check for specific field validations
                            switch (fieldName) {
                                case 'email':
                                    if (!isValidEmail(value)) {
                                        $(this).addClass('error is-invalid');
                                        errors++;
                                    }
                                    break;
                                case 'phone':
                                    const phoneId = field.attr('id');
                                    const iti = intlTelInputs[phoneId];
                                    if (!iti.isValidNumberPrecise()) {
                                        const errorCode = iti.getValidationError();
                                        const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
                                        const msg = errorMap[errorCode] || "Invalid number";
                                        $(this).closest('.form-group').find('.invalid-feedback').text(msg).show();

                                        $(this).addClass('error is-invalid');
                                        errors++;
                                    }
                                    break;
                                default:
                                    if (!value) {
                                        $(this).addClass('error is-invalid');
                                        errors++;
                                    }
                            }
                        });
                    }

                    return errors === field.length;
                }

                function isValidEmail(email) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(email);
                }

                $(document).on('submit', '#guest_checkout_form, #user_checkout_form', function (e) {
                    e.preventDefault()

                    let errors = 0;

                    const fieldArray = [
                        $(this).closest('form').find('[name=name]'),
                        $(this).closest('form').find('[name=email]'),
                        $(this).closest('form').find('[name=phone]')
                    ];

                    fieldArray.forEach(elem => {
                        errors += checkError(elem);
                    })

                    if (errors){
                        const firstErrorElement = $(this).closest('form').find('.error:first');
                        const ecHeaderElement = document.querySelector('.ec-header');
                        const ecHeaderHeight = ecHeaderElement.offsetHeight;
                        if (firstErrorElement.length) {
                            $('html, body').animate({
                                scrollTop: firstErrorElement[0].offsetTop - ecHeaderHeight - 50
                            }, 200);
                        }
                        return;
                    }else {
                        $('.checkout_step_2').removeClass('active')
                        $('.checkout_step_3').addClass('active')
                        $('.checkout_section_2').hide()
                        $('.checkout_section_delivery').show()
                        $('.checkout_step_2').siblings('.edit_filled_tab').removeClass('d-none');
                        $('.checkout_step_3').siblings('.edit_filled_tab').removeClass('d-none');

                    }


                    let html = ''
                    $(this).serializeArray().forEach(function (item) {
                        html += '<input type="hidden" name="' + item.name + '" value="' + item.value + '">'
                    });
                    html += '<input type="hidden" name="type" value="' + $('input[name=type]:checked').val() + '">'
                    let amount = '{{ $total }}'
                    html += '<input type="hidden" name="amount" value="' + amount + '">'
                    @if($delivery)
                    let delivery_id = '{{ $delivery->id }}'
                    html += '<input type="hidden" name="delivery_id" value="' + delivery_id + '">'
                    @endif

                    $('.place_order_form_old_values').html(html)
                })

                $(document).on('click', '.delivery_continue', function () {
                  if(($('input[name="shipment-method"]').val() == undefined) && ($(".delivery_type").val() != 'pickup')){
                      var message = "Please submit shipment address.";
                      const container = $('.rate_list_form');
                      container.html("<h6><em style='color:red;'>Submit your address to see the possible providers</em></h6>");
                      return;
                  }
                    $('.checkout_step_3').removeClass('active')
                    $('.checkout_step_4').addClass('active')
                    $('.checkout_section_delivery').hide()
                    $('.checkout_section_3').show()
                    $('.checkout_step_4').siblings('.edit_filled_tab').removeClass('d-none');
                    if($(".delivery_type").val() == 'pickup'){
                        var def_rate = +$(".default_tax_rate").val();
                        var total_price = (parseFloat($("#total_price").val())).toFixed(2);

                        var tax = total_price  * def_rate;

                        $("#tax_amount").html(tax.toFixed(2));
                        $("#tax_rate").val(tax.toFixed(2));
                        var pr = parseFloat(total_price) + parseFloat(tax);

                        $(".total_cost").attr('data-total', pr.toFixed(2));
                        var i = pr.toFixed(2);

                        $('.total_cost').html('$'+i);
                    }else{
                        if($('.guest_address_form').length){
                            let html = ''
                            $('.guest_address_form').serializeArray().forEach(function (item) {
                                html += '<input type="hidden" name="' + item.name + '" value="' + item.value + '">'
                            });
                            $('.place_order_form_old_values').append(html)
                        }else if($('.order_new_address_form').length){
                            let html = ''
                            $('.order_new_address_form').serializeArray().forEach(function (item) {
                                html += '<input type="hidden" name="' + item.name + '" value="' + item.value + '">'
                            });
                            $('.place_order_form_old_values').append(html)
                        }

                        if($('.rate_list_form').length){
                            let html = ''
                            const serializedArray = $('.rate_list_form').serializeArray();
                            const lastIndex = serializedArray.length - 1;
                            const item = serializedArray[lastIndex];
                            const chosenPrice = +$(`.shipment_element[data-id=${item.value}]`).attr('data-price');
                            const chosenName = $(`.shipment_element[data-id=${item.value}]`).attr('data-name');



                            $('.shipping_cost').html(`$${chosenPrice.toFixed(2)}`);
                            $('.shipping_provider').val(`${chosenName}`);
                            $('.shipping_provider_id').val(`${item.value}`);
                            $('.shipping_price').val(`${chosenPrice.toFixed(2)}`);

                            const totalPrice = +$('.total_cost').attr('data-total')
                            $('.total_cost').html(`$${(totalPrice + chosenPrice).toFixed(2)}`)

                            if (item.value) {
                                html += '<input type="hidden" name="' + item.name + '" value="' + item.value + '">'
                            }
                            $('.place_order_form_old_values').append(html)
                        }
                    }



                })

                function renderShipmentVariants(shipmentList) {
                    const container = $('.rate_list_form');
                    container.html(`<table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Shipping Method</th>
                                <th>Prices</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>`);
                    // container.html(`<tr><th>Shipping Method</th><th>Prices</th></tr>`);

                    if (shipmentList.length === 0) {
                        container.html("<h6><em>Submit your address to see the possible providers</em></h6>");
                        return;
                    }
                    let  tax_rate = 0;
                    let k = 0;
                    $.each(shipmentList, function(provider, shipment) {
                        tax_rate =shipment.tax_rate;
                        var is_checked = '';
                        if(k == 0){
                            is_checked = 'checked';
                        }
                        const container = $('.rate_list_form').find('tbody');
                        const elementHTMLString = `
                            <tr class="shipment_element" data-id="${shipment.provider_id}" data-price="${shipment.price}" data-name="${shipment.provider}">
                                <td class="shipment_provider">
                                    <input id="id_${shipment.provider_id}" class="shipment_control" type="radio" name="shipment-method" value="${shipment.provider_id}" ${is_checked}>
                                    <div>

                                        <label for="id_${shipment.provider_id}" class="shipment_provider_description">
                                            <b>${shipment.text}</b> ${shipment.terms}
                                        </label>
                                    </div>
                                </td>

                                <td class="shipment_prices">
                                    +${shipment.price}$
                                </td>
                            </tr>
                        `
                        container.append(elementHTMLString);
                        // container.html(container.html() + elementHTMLString)
k++;
                    });

                    return tax_rate;

                }

                $(document).on('click', '.delivery_lists', function (e) {
                    e.preventDefault()
                    let errors = 0;

                    const fieldArray = [
                        $('.checkout_section_delivery input[name=name]'),
                        $('.checkout_section_delivery input[name=email]'),
                        $('.checkout_section_delivery input[name=phone]'),
                        $('.checkout_section_delivery input[name=address]'),
                        $('.checkout_section_delivery input[name=zip]'),
                        $('.checkout_section_delivery input[name=city]'),
                        $('.checkout_section_delivery input[name=state]')
                    ];

                    fieldArray.forEach(elem => {
                        if(elem){
                            errors += checkError(elem);
                        }
                    })
                    const isVisible = $('.order_new_address_form').is(':visible');
                    const isVisibleGuestForm = $('.guest_address_form').is(':visible');
                    if ((errors && isVisible) || (errors && errors > 3 && isVisibleGuestForm)) {
                        const firstErrorElement = $(".checkout_section_delivery").find('.error:first');
                        const ecHeaderElement = document.querySelector('.ec-header');
                        const ecHeaderHeight = ecHeaderElement.offsetHeight;
                        if (firstErrorElement.length) {
                            $('html, body').animate({
                                scrollTop: firstErrorElement[0].offsetTop - ecHeaderHeight - 50
                            }, 200);
                        }
                        return;
                    }

                    const data = $('@guest .guest_address_form @else .order_new_address_form @endif'.trim()).serializeArray();
                    const body = {};
                    data.push({name:'address_id', 'value':$(".address_id").val()});
                    data.push({name:'no_pickup', 'value':1});
                    data.push({name:'product_id','value':$("input[name='product_id']").val()});
                    data.push({name:'quantity','value':$("input[name='qty']").val()});
                    var total_price = parseFloat($("#total_price").val());
                    data.push({name:'total_price','value':total_price});
                    for (const dataElement of data) {
                        body[dataElement.name] = dataElement.value
                    }

                    const loadingSpinner = `<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>`
                    $('.rate_list_form').html(loadingSpinner)

                    $.ajax({
                        type: "POST",
                        url: "{{route('calculateShipmentPrices')}}",
                        data: body,
                        dataType: 'json',
                        success: (data) => {

                            var tax_rate = renderShipmentVariants(data)

                            var total_price = parseFloat($("#total_price").val());

                            var tax = total_price  * tax_rate;

                            $("#tax_amount").html(tax);
                            $("#tax_rate").val(tax);
                            $(".total_cost").attr('data-total', total_price + tax);
                            var i = total_price + tax;

                            $('.total_cost').html('$'+i);
                        }
                    });
                })

                $(document).on('submit', '#login_checkout_form', function (e) {
                    e.preventDefault();

                    let errors = 0;

                    const fieldArray = [
                        $(this).closest('form').find('[name=email]'),
                        $(this).closest('form').find('[name=password]')
                    ];

                    fieldArray.forEach(elem => {
                        errors += checkError(elem);
                    })

                    if (errors){
                        const firstErrorElement = $(this).closest('form').find('.error:first');
                        const ecHeaderElement = document.querySelector('.ec-header');
                        const ecHeaderHeight = ecHeaderElement.offsetHeight;
                        if (firstErrorElement.length) {
                            $('html, body').animate({
                                scrollTop: firstErrorElement[0].offsetTop - ecHeaderHeight - 50
                            }, 200);
                        }
                        return;
                    }

                    let formData = new FormData(this)

                    $.ajax({
                        type: "POST",
                        url: "{{ route('order_login') }}",
                        success: (data) => {
                            if (data.status) {
                                $(this).append('<input type="hidden" name="user_id" value="' + data.user_id + '">')
                                $('.after_login_name').val(data.name)
                                $('.after_login_email').val(data.email)
                                $('.after_login_company').val(data.company)
                                $('.after_login_phone').val(data.phone)

                                let html = ''
                                $(this).serializeArray().forEach(function (item) {
                                    html += '<input type="hidden" name="' + item.name + '" value="' + item.value + '">'
                                });
                                html += '<input type="hidden" name="type" value="' + $('input[name=type]:checked').val() + '">'
                                let amount = '{{ $total }}'
                                html += '<input type="hidden" name="amount" value="' + amount + '">'
                                @if($delivery)
                                let delivery_id = '{{ $delivery->id }}'
                                html += '<input type="hidden" name="delivery_id" value="' + delivery_id + '">'
                                @endif

                                $('.after_login_old_values').html(html)
                                $(this).hide()
                                $('#after_login_checkout_form').show()
                                $('.show_card_info').html(data.card_view)
                            } else {
                                $(this).closest('form').find('[name=email]').addClass('error is-invalid');
                                $('.invalid-feedback').text('Invalid credentials')
                            }
                        },
                        error: function (error) {
                            console.log(error)
                        },
                        async: true,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        timeout: 60000
                    });

                })

                $(document).on('submit', '#after_login_checkout_form', function (e) {
                    e.preventDefault()
                    let errors = 0;

                    const fieldArray = [
                        $(this).closest('form').find('[name=name]'),
                        $(this).closest('form').find('[name=email]'),
                        $(this).closest('form').find('[name=phone]')
                    ];

                    fieldArray.forEach(elem => {
                        errors += checkError(elem);
                    })

                    if (errors){
                        const firstErrorElement = $(this).closest('form').find('.error:first');
                        const ecHeaderElement = document.querySelector('.ec-header');
                        const ecHeaderHeight = ecHeaderElement.offsetHeight;
                        if (firstErrorElement.length) {
                            $('html, body').animate({
                                scrollTop: firstErrorElement[0].offsetTop - ecHeaderHeight - 50
                            }, 200);
                        }
                        return;
                    }

                    $('.checkout_step_2').removeClass('active')
                    $('.checkout_step_3').addClass('active')
                    $('.checkout_section_2').hide()
                    $('.checkout_section_delivery').show()
                    $('.checkout_step_2').siblings('.edit_filled_tab').removeClass('d-none');
                    $('.checkout_step_3').siblings('.edit_filled_tab').removeClass('d-none');

                    let html = ''
                    $(this).serializeArray().forEach(function (item) {
                        html += '<input type="hidden" name="' + item.name + '" value="' + item.value + '">'
                    });
                    html += '<input type="hidden" name="type" value="' + $('input[name=type]:checked').val() + '">'
                    let amount = '{{ $total }}'
                    html += '<input type="hidden" name="amount" value="' + amount + '">'
                    @if($delivery)
                    let delivery_id = '{{ $delivery->id }}'
                    html += '<input type="hidden" name="delivery_id" value="' + delivery_id + '">'
                    @endif

                    $('.place_order_form_old_values').html(html)

                })

                $(document).on('submit', '#register_checkout_form', function (e) {
                    e.preventDefault();
                    let errors = 0;

                    const fieldArray = [
                        $(this).closest('form').find('[name=name]'),
                        $(this).closest('form').find('[name=email]'),
                        $(this).closest('form').find('[name=phone]'),
                        $(this).closest('form').find('[name=password]'),
                        $(this).closest('form').find('[name=confirm_password]')
                    ];

                    fieldArray.forEach(elem => {
                        errors += checkError(elem);
                    })

                    if (errors){
                        const firstErrorElement = $(this).closest('form').find('.error:first');
                        const ecHeaderElement = document.querySelector('.ec-header');
                        const ecHeaderHeight = ecHeaderElement.offsetHeight;
                        if (firstErrorElement.length) {
                            $('html, body').animate({
                                scrollTop: firstErrorElement[0].offsetTop - ecHeaderHeight - 50
                            }, 200);
                        }
                        return;
                    }
                    let formData = new FormData(this)

                    $.ajax({
                        type: "POST",
                        url: "{{ route('order_register') }}",
                        success: (data) => {
                            $(this).append('<input type="hidden" name="user_id" value="' + data.user_id + '">')

                            $('.checkout_step').removeClass('active')
                            $('.checkout_step_3').addClass('active')
                            $('.checkout_section_2').hide()
                            $('.checkout_section_delivery').show()

                            let html = ''
                            $(this).serializeArray().forEach(function (item) {
                                html += '<input type="hidden" name="' + item.name + '" value="' + item.value + '">'
                            });
                            html += '<input type="hidden" name="type" value="' + $('input[name=type]:checked').val() + '">'
                            let amount = '{{ $total }}'
                            html += '<input type="hidden" name="amount" value="' + amount + '">'
                            @if($delivery)
                            let delivery_id = '{{ $delivery->id }}'
                            html += '<input type="hidden" name="delivery_id" value="' + delivery_id + '">'
                            @endif

                            $('.place_order_form_old_values').html(html);

                            $('.checkout_step_2').removeClass('active')
                            $('.checkout_step_3').addClass('active')
                            $('.checkout_section_2').hide()
                            $('.checkout_section_delivery').show()
                            $('.checkout_step_2').siblings('.edit_filled_tab').removeClass('d-none');
                            $('.checkout_step_3').siblings('.edit_filled_tab').removeClass('d-none');

                        },
                        error: function (error) {
                            // let html = ''
                            // Object.entries(error.responseJSON?.errors).forEach(([key, val]) => {
                            //     html += '<li>' + val[0] + '</li>'
                            // });
                            // $('.register_errors').html(html)
                            let errors = error.responseJSON.errors;

                            Object.entries(errors).forEach(([key, val]) => {
                                // Find the input field with the name equal to the key
                                let inputField = $('input[name="' + key + '"]');
                                if (inputField.length > 0) {
                                    // If input field found, update error message and add 'is-invalid' class
                                    inputField.addClass('error is-invalid');
                                    inputField.next('.invalid-feedback').text(val[0]).show(); // Update error message
                                }
                            });
                        },
                        async: true,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        timeout: 60000
                    });

                })

                $(document).on('click', '.delete_img', function () {
                    const imgId = $(this).data('img');
                    $.ajax({
                        url: "/delete-image/" + imgId,
                        type: 'DELETE',
                        success: () => {
                            $(this).parents('.upload_image_block').remove()
                        },
                        async: true
                    })
                })

                $(document).on('click', '.checkout_step_1_submit', function () {
                    let type = $('[name=type]:checked').val(),
                        form

                    if (type === 'Upload Print Ready Files') {
                        form = $('#upload_type_1_form')
                    } else if (type === 'Order Now Upload Later') {
                        form = $('#upload_type_2_form')
                    } else {
                        form = $('#upload_type_3_form')
                    }

                    let html = ''
                    form.serializeArray().forEach(function (item) {
                        html += '<input type="hidden" name="' + item.name + '" value="' + item.value + '">'
                    });
                    $('.step_two_old_values').html(html)
                })

                $(document).on('change', 'input[name=payment_type]', function () {
                    let val = $(this).val()
                    if (val === 'stripe') {
                        $('.stripe_inputs').css({
                            'display': 'flex',
                            'flex-direction': 'column'
                        });
                    }else if(val === 'terminal'){
                        $('.stripe_inputs').hide()
                    } else {
                        $('.stripe_inputs').hide()
                    }
                })

                $(document).on('submit', '#place_order_form', function (e) {
                    e.preventDefault();
                    let errors = 0;
                    let stripe_card_id;

                    let selectedCard = $('.credit-card.selected');
                    if (!selectedCard.length) {
                        const fieldArray = [
                            $('[name=card_no]'),
                            $('[name=exp_month]'),
                            $('[name=exp_year]'),
                            $('[name=cvc]')
                        ];

                        fieldArray.forEach(elem => {
                            if(elem){
                                errors += checkError(elem);
                            }
                        })
                    }else{
                        stripe_card_id = selectedCard.data('id')
                    }

                    const isVisible = $('.stripe_inputs').is(':visible');

                    if (errors && isVisible) {
                        e.preventDefault()
                        const firstErrorElement = $(this).closest('form').find('.error:first');
                        const ecHeaderElement = document.querySelector('.ec-header');
                        const ecHeaderHeight = ecHeaderElement.offsetHeight;
                        if (firstErrorElement.length) {
                            $('html, body').animate({
                                scrollTop: firstErrorElement[0].offsetTop - ecHeaderHeight - 50
                            }, 200);
                        }
                        return;
                    }

                    $("#ec-overlay").show();

                    let formData = new FormData(this)
                    if (stripe_card_id) {
                        formData.append('stripe_card_id', stripe_card_id);
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{ route('create_order') }}",
                        success: function (data) {
                            if (data.success) {
                                location.href = data.payment_url;
                            } else {
                                $('.sww').text(data.error)
                            }
                        },
                        complete: function(data) {
                            let response = data.responseJSON;
                            if (response && response.waiting) {
                                startPolling(response.order_id);
                                $("#ec-overlay").show();
                            }else{
                                $("#ec-overlay").fadeOut("slow");
                            }
                        },
                        async: true,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        timeout: 60000
                    });
                })
                function startPolling(orderId) {
                    const interval = 5000; // Poll every 5 seconds
                    const poll = setInterval(function() {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('check_order_status') }}",
                            data: { order_id: orderId },
                            success: function(response) {
                                if(response.status === 'completed' || response.status === 'canceled'){
                                    clearInterval(poll);
                                    $("#ec-overlay").fadeOut("slow");
                                    location.href = response.payment_url;
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                clearInterval(poll);
                                $("#ec-overlay").fadeOut("slow");
                            }
                        });
                    }, interval);
                }
                let first_time_open_shipping = true
                $(document).on('click', '.shipping_tab_item', function () {
                    if (first_time_open_shipping) {
                        first_time_open_shipping = false
                        $('.profile_address.default').click()
                    }
                    $('.delivery_type').val('shipping')
                })

                $(document).on('click', '.profile_address', function () {
                    $('.profile_address').removeClass('default')
                    $(this).addClass('default')
                    $('.address_id').val($(this).attr('data-id'))
                })

                $(document).on('click', '.pickup_tab_item', function () {
                    $('.delivery_type').val('pickup')
                })

                $(document).on('click', '.create_order_address', function () {
                    $('.delivery_logged_in').hide()
                    $('.order_new_address_form').css('display', 'flex')
                })

                $(document).on('blur','input[name="zip"]',function(e){
                    var zip = $(this).val();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('check_zip') }}",
                        data:{zip:zip},
                        success: function (data) {

                            if (data.status) {
                                var inputs = document.querySelectorAll('input[name="state"]');
                                inputs.forEach(function(input) {
                                    if(input.value == ''){
                                        input.value = data.state;
                                    }

                                });
                                var inputs = document.querySelectorAll('input[name="city"]');
                                inputs.forEach(function(input) {
                                    if(input.value == ''){
                                        input.value = data.city;
                                    }

                                });

                                var total_price = parseFloat($("#total_price").val());

                                var tax = total_price  * data.rate;

                                $("#tax_amount").html(tax);
                                $("#tax_rate").val(tax);
                                $(".total_cost").attr('data-total', total_price + tax);
                                var i = total_price + tax;

                                $('.total_cost').html('$'+i);
                            }
                        },
                        cache: true,
                    });
                })

                $(document).on('submit', '.order_new_address_form', function (e) {
                    e.preventDefault()
                    let formData = new FormData(this)

                    $.ajax({
                        type: "POST",
                        url: "{{ route('add_address') }}",
                        success: function (data) {
                            if (data.status) {
                                $('.profile_address').removeClass('default')
                                $(`<div class="col-md-6">
                                <div class="profile_address default" data-id="${data.address.id}">
                                    <p><b>Name:</b> ${data.address.name}</p>
                                <p><b>Email:</b>  ${data.address.email}</p>
                                <p><b>Phone:</b>  ${data.address.phone}</p>
                                <p><b>Address:</b>  ${data.address.address}</p>
                                <p><b>Unit/Apartment/Suite:</b>  ${data.address.unit}</p>
                                <p><b>City:</b>  ${data.address.city}</p>
                                <p><b>State:</b>  ${data.address.state}</p>
                                <p><b>ZIP:</b>  ${data.address.zip}</p>
                            </div>
                            </div>`).insertBefore('.checkout_add_address_block');
                                $('.address_id').val(data.address.id)
                                $('.order_new_address_form').hide()
                                $('.delivery_logged_in').show()
                                $('.order_new_address_form').trigger("reset")
                            }
                        },
                        async: true,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        timeout: 60000
                    });
                })

                $(document).on('keypress', '.card_no', function (e) {
                    if (e.keyCode >= 48 && e.keyCode <= 57 && this.value.length < 19) {
                        this.value = this.value.replace(/\W/g, '').replace(/(\d{4})/g, '$1 ').trim();
                    } else {
                        e.preventDefault();
                    }
                });
                $(document).on('blur', '.exp_month', function (e) {
                    this.value = this.value.replace(/^0+(?!\d)/g, '');
                    // Validate the month
                    const validMonthRegex = /^(0[0-9]|1[0-2])$/g;
                    if (!validMonthRegex.test(this.value)) {
                        this.value = '';
                    }
                });
                $(document).on('blur', '.exp_year', function (e) {

                    const currentYear = new Date().getFullYear();

                    // Parse the input value as an integer
                    const enteredYear = parseInt(this.value, 10);

                    if (isNaN(enteredYear) || enteredYear < currentYear) {
                        this.value = '';
                    }
                });

                $(document).on('blur', '.cvc', function (e) {
                    const cvvPattern = /^[0-9]{3,4}$/;
                    if (!cvvPattern.test(this.value)) {
                        this.value = '';
                    }
                });

                $(document).on('click', '.credit-card', function() {
                    // Check if the clicked card is already selected
                    if ($(this).hasClass('selected')) {
                        // Remove 'selected' class and hide the icon
                        $(this).removeClass('selected');
                        $(this).find('.credit-card-selected').addClass('hidden');
                    } else {
                        // Remove 'selected' class and hide the icon from all cards
                        $('.credit-card').removeClass('selected');
                        $('.credit-card .credit-card-selected').addClass('hidden');

                        // Add 'selected' class and show the icon on the clicked card
                        $(this).addClass('selected');
                        $(this).find('.credit-card-selected').removeClass('hidden');
                    }
                });
            });
        });
    </script>
@endpush
