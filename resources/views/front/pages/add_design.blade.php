@extends('front.layouts.main')

@section('content')
    <section class="single_product_section ec-page-content section-space-p section-space-pt" style="padding-top: 0;">
        <div class="container">
            <div id="design-iframe-container">
                <iframe src="{{$iframe_url}}" width="100%" height="850" style="border: none;"></iframe>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('front/assets/js/main.js') }}"></script>

@endpush