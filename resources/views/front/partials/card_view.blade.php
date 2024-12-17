@if($cards)

<link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/payment.css') }}">

<section class="ec-page-content ec-vendor-uploads ec-user-account mb-2">
    <div class="row">
        <div class="ec-shop-rightside col-12">
            <div class="ec-vendor-setting-card">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ec-vendor-block-profile">
                            <div class="row">
                                <div class="col-12 flex-wrap d-flex align-items-center justify-content-start gap-3">
                                    @if(count($cards))
                                        @foreach($cards as $card)
                                            <!-- Visa - selectable -->
                                            <div class="credit-card {{$card['brand']}} selectable {{$card['default_card'] ? 'selected' : ''}}"
                                                 data-id="{{$card['id']}}">
                                                <div class="credit-card-selected {{$card['default_card'] ? '' : 'hidden'}}">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                                <div class="credit-card-last4">
                                                    {{$card['last4']}}
                                                </div>
                                                <div class="credit-card-expiry">
                                                    {{$card['exp_month']}}/{{$card['exp_year']}}
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif