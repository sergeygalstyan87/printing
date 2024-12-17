@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">
@endpush

@section('content')

    <section class="section ec-ser-spe-section">
        <div class="col-md-12 p-0">
            <div class="img_banner_block w-100">
                <img src="{{ asset('front/assets/images/about-images/banner.jpg') }}" alt="" class="about_banner w-100">
            </div>
        </div>
    </section>
    <!-- Ec About Us page -->
    <section class="ec-page-content section-space-p about_section">
        <div class="container">

            <div class="row mb-10">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-title">About Us</h2>
                    </div>
                </div>
                <div class="ec-common-wrapper">
                    <div class="row">
                        <div>
                            <h5 class="ec-about-title text-center">The success of our customers is our main goal, and the
                                driving
                                force behind everything we do.</h5>
                            <div class="ec-cms-block-inner w-90">
                                <p>
                                    We specialize in providing customized printing services, producing magazines,
                                    catalogues, labels, packaging, printing on textiles and much more. Our online shop
                                    is the largest web-to-print operation in USA. We offer our clients quick and easy
                                    access to the best printing solutions and a huge product catalogue.
                                </p>

                                <p>
                                    Over the years we have become a well-oiled machine, able to offer our customers a
                                    high-quality service with delivery in as little as 24 hours. Each of our products
                                    can be personalized, giving users extraordinary freedom to customize their order.
                                </p>

                                <p>
                                    We are all humans here too, and not automated robots, which means that we can check
                                    your files for you before printing. Our aim is to get you printing right first time,
                                    and not to have to play a trial and error game before getting the hang of it! We
                                    view all files before printing, and if we can see an error, we will not print,
                                    rather repair it or send it back to you to perform the amendments. This saves you
                                    both time and money.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-10">
                <div class="ec-common-wrapper">
                    <div class="row column_reverse">
                        <div class="col-md-6 ec-cms-block ec-abcms-block text-center">
                            <div class="ec-cms-block-inner ">
                                <img class="a-img" src="{{ asset('front/assets/images/about-images/workers.jpg') }}"
                                     alt="about">
                            </div>
                        </div>
                        <div class="col-md-6 ec-cms-block ec-abcms-block text-center">
                            <div class="row">
                                <h5 class="ec-about-title text-start">
                                    The quality of our work is our best calling card
                                </h5>
                                <div class="ec-cms-block-inner w-100">
                                    <p>
                                        Our catalogue meets our customers’ every need. Our Research & Development
                                        department is constantly looking for new solutions to ensure our customers
                                        can find the best way to show off their business, whatever it is.
                                    </p>

                                    <p>
                                        We can tackle requests of any type, from small to large format items, from
                                        printing on paper to printing on wood, aluminum or PVC, and from packaging
                                        to materials for trade fairs.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-10">
                <div class="ec-common-wrapper">
                    <div class="row">
                        <div class="col-md-6 ec-cms-block ec-abcms-block text-center">
                            <div class="row">
                                <h5 class="ec-about-title text-start">
                                    We believe that together technology and people can achieve great things.
                                </h5>
                                <div class="ec-cms-block-inner w-100">
                                    <p>
                                        Our manufacturing department is equipped with innovative and constantly
                                        evolving machinery. We currently have over 50 production systems, and this
                                        number continues to rise. In addition, we work with some of the biggest
                                        companies in the world to design new technologies tailored to our
                                        requirements.
                                    </p>

                                    <p>
                                        <b>YansPrint</b> has equipment dedicated to the most advanced printing
                                        technologies
                                        and specific machines for a vast range of finishing processes, from binding
                                        and cutting to laminating and creasing.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ec-cms-block ec-abcms-block text-center">
                            <div class="ec-cms-block-inner ">
                                <img class="a-img" src="{{ asset('front/assets/images/about-images/about.jpg') }}"
                                     alt="about">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-10">
                <div class="ec-common-wrapper">
                    <div class="row column_reverse">
                        <div class="col-md-6 ec-cms-block ec-abcms-block text-center">
                            <div class="ec-cms-block-inner ">
                                <img class="a-img" src="{{ asset('front/assets/images/about-images/support.jpg') }}"
                                     alt="about">
                            </div>
                        </div>
                        <div class="col-md-6 ec-cms-block ec-abcms-block text-center">
                            <div class="row">
                                <h5 class="ec-about-title text-start">
                                    We support our customers in their challenges and we are always there if they
                                    need help.
                                </h5>
                                <div class="ec-cms-block-inner w-100">
                                    <p>
                                        We always put our customers first. We base our decisions on their requests
                                        and needs, and our website is built around their advice and designed to make
                                        their purchasing experience unique and hassle-free. In our online shop
                                        customers can view our range, select the products that interest them, go
                                        directly to the guided, free-of-charge ordering process and place their
                                        order by uploading the print file.
                                    </p>
                                </div>
                            </div>
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
