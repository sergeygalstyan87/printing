@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('front/assets/css/order_history.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

@endpush

@section('content')
    @php
        $is_requests = str_contains(url()->current(), 'requests');
    @endphp

    <section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p order_history">
        <div class="container">
            <div class="row">
                <!-- Sidebar Area Start -->
                <div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Category Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-vendor-block">
                                @include('front.partials.profile.navigation')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ec-shop-rightside col-lg-9 col-md-12">
                    <div class="ec-vendor-dashboard-card">
                        <div class="ec-vendor-card-header">
                            <h5>Order History</h5>
                        </div>
                        <div class="ec-vendor-card-body">
                            <div class="ec-vendor-card-table">
                                <table class="table ec-table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Order N</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Product</th>
                                        @if($is_requests)
                                            <th scope="col">Process</th>
                                        @endif
                                        <th scope="col">Handling</th>
                                        <th scope="col">Order Status</th>
                                        @if($is_requests)
                                            <th scope="col">Action</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($orders))
                                        @foreach($orders as $order)
                                            <tr class="order_info">
                                                <th scope="row" class="invoice">
                                                    <span
                                                        class="view_invoice text-danger"
                                                        data-id = "{{$order->id}}"
                                                        data-invoice="{{ $order->invoice_path }}"
                                                    >{{ $order->invoice_number }}</span>
                                                    <span class="date" style="padding: 0 !important;">{{ $order->created_at->format('M d, Y') }}</span>
                                                </th>
                                                <td class="price">
                                                    <span>${{ $order->amount }}</span>
                                                    @switch($order->status)
                                                        @case('customRequest')
                                                            <span style="display: flex" class="status text-warning">
                                                                <i class="fa-solid fa-circle"></i> Waiting</span>
                                                            @break
                                                        @case('pending')
                                                            <span style="display: flex" class="status text-warning">
                                                                <i class="fa-solid fa-circle"></i> Pending</span>
                                                            @break
                                                        @case('completed')
                                                            <span style="display: flex" class="status text-success">
                                                                <i class="fa-solid fa-circle"></i> Paid</span>
                                                            @break
                                                        @case('canceled')
                                                            <span style="display: flex" class="status text-danger">
                                                                <i class="fa-solid fa-circle"></i> Canceled</span>
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <div style="display:flex;align-items: flex-start">
                                                        <img class="prod-img"
                                                             src="{{ asset('storage/content/' . $order->product->images[0]) }}"
                                                             alt="{{ $order->product->title }}">
                                                        <div style="margin-left: 10px;">
                                                            <span class="text-danger">{{ $order->est_number }}</span>
                                                             <span>{{ $order->product->title }}</span>
                                                            <span>Qty: x{{ $order->qty }}</span>
                                                        </div>

                                                    </div>
                                                </td>
                                                @if($is_requests)
                                                    <td>
                                                            @if($order->status === 'preOrder')
                                                                <span>
                                                                    Ready to pay
                                                                </span>
                                                            @elseif($order->status !== 'completed')
                                                                <span>
                                                                    Waiting for approve
                                                                </span>
                                                            @else
                                                                <span>
                                                                    Printing and delivering
                                                                </span>
                                                            @endif
                                                    </td>
                                                @endif
                                                <td><span>{{ strtoupper($order->delivery_type) }}</span></td>

                                                <td>
                                                    @switch($order->delivery_status)
                                                        @case('0')
                                                        @case('5')
                                                            <span style="display: flex" class="status text-primary">
                                                                <i class="fa-solid fa-circle"></i> Design and Prepress</span>
                                                            @break
                                                        @case('1')
                                                            <span style="display: flex" class="status text-primary">
                                                                <i class="fa-solid fa-circle"></i> Production</span>
                                                            @break
                                                        @case('2')
                                                            <span style="display: flex" class="status text-primary">
                                                                <i class="fa-solid fa-circle"></i> Ready</span>
                                                            @break
                                                        @case('3')
                                                        @case('4')
                                                            <span style="display: flex" class="status text-primary">
                                                                <i class="fa-solid fa-circle"></i> Completed</span>
                                                            @break
                                                    @endswitch
                                                </td>
                                                @if($is_requests)
                                                    <td class="align-middle text-nowrap">
                                                        @if(isset($order->invoice_sent) && $order->status !== 'completed')
                                                            <a class="btn btn-primary" href="{{route('pay-order', ['invoice' => $order->invoice_number])}}">
                                                                Go to pay
                                                            </a>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr class="order_more_details">
                                                <td colspan="2">
                                                    <div class="order_more_details_block">
                                                        <img class="prod_img_detail"
                                                             src="{{ asset('storage/content/' . $order->product->images[0]) }}"
                                                             alt="{{ $order->product->title }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="order_more_details_block product_info_detail">
                                                        <p>Product Info</p>
                                                        <div>
                                                             @php $attrs = json_decode($order->attrs, true);  @endphp
                                                            @foreach($attrs['types'] as $key => $value)
                                                                <p><span class="attr_key">{{$key}}:</span>    {{$value}}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                                @if($is_requests)
                                                    <td></td>
                                                @endif
                                                <td>
                                                    <div class="order_more_details_block product_info_detail">
                                                        <p>Handling</p>
                                                        <div>
                                                            @if($order->delivery_type == 'pickup')
                                                                <p>
                                                                    <span class="attr_key">Yans Print</span><br>
                                                                    <span class="attr_key">14701 Arminta St Ste A Panorama City, CA 91402</span><br>
                                                                </p>
                                                            @else
                                                                <p>
                                                                    <span class="attr_key">{{$order->unit}} {{$order->address}}</span><br>
                                                                    <span class="attr_key">{{$order->state}} {{$order->zip}}</span><br>
                                                                    @if($order->user_id)
                                                                        <span class="attr_key">{{$order->user->phone}}</span><br>
                                                                    @else
                                                                        <span class="attr_key">{{$order->phone}}</span><br>
                                                                    @endif
                                                                </p>
                                                            @endif
                                                            <p>
                                                                <span class="attr_key">Price: &nbsp; </span><span> ${{$order->original_amount}}</span><br>
                                                                <span>Total: &nbsp;</span><span> ${{$order->amount}}</span><br>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="">
                                                    <div class="order_more_details_block">
                                                        <div class="order-status">
                                                            <div class="status-line"></div>
                                                            <div class="status-step">
                                                                <div class="circle  in_progress"></div>
                                                                <span>Prepress</span>
                                                            </div>

                                                            <div class="status-step">
                                                                <div class="circle {{$order->delivery_status >= 1 ? 'in_progress' : ''}}"></div>
                                                                <span>Production</span>
                                                            </div>

                                                            <div class="status-step">
                                                                <div class="circle  {{$order->delivery_status >= 2 ? 'in_progress' : ''}}"></div>
                                                                <span>Ready</span>
                                                            </div>

                                                            <div class="status-step">
                                                                <div class="circle
                                                                {{in_array($order->delivery_status, [3, 4]) || $order->delivery_status >= 3 ? 'in_progress' : ''}}"
                                                                ></div>
                                                                <span>Complete</span>
                                                            </div>
                                                        </div>
                                                    </div>
{{--                                                    <div class="order_more_details_block">--}}
{{--                                                        <div class="track_number">--}}
{{--                                                            @if($order->track_number && $order->track_number_link)--}}
{{--                                                                <div class="label">{{ $order->track_number }}</div>--}}
{{--                                                                <div class="copy-text">--}}
{{--                                                                    <input type="text" class="text"--}}
{{--                                                                           value="{{ $order->track_number_link }}"/>--}}
{{--                                                                    <button><i class="fa fa-clone"></i></button>--}}
{{--                                                                </div>--}}
{{--                                                            @endif--}}
{{--                                                        </div>--}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="invoice_modal">
        <style>
            .invoice-box {
                width: 300px;
                height: 85%;
                padding: 60px 0 0;
                font-size: 16px;
                line-height: 24px;
                font-family: 'Lato', sans-serif;;
                color: #555
            }

            .invoice-box table {
                width: 100%;
                line-height: inherit;
                text-align: left
            }

            .invoice_text {
                font-size: 60px;
                line-height: 60px;
                font-weight: 600;
                text-transform: uppercase;
                color: #036;
                padding: 0 !important
            }

            table .company_info td {
                padding: 30px 5px
            }

            .invoice_heading {
                font-size: 24px;
                line-height: 32px;
                text-transform: uppercase;
                font-weight: 600;
                color: #036
            }

            table td {
                padding: 5px
            }

            .invoice-box table tr td:nth-child(2) {
                text-align: right
            }

            .invoice-box table tr.top table td.title {
                font-size: 45px;
                line-height: 45px;
                color: #333
            }

            .invoice-box table tr.information table td {
                padding-bottom: 40px
            }

            .invoice-box table tr.heading td {
                background: #eee;
                border-bottom: 1px solid #ddd;
                font-size: 24px;
                line-height: 32px;
                text-transform: uppercase;
                font-weight: 600;
                color: #036
            }

            .invoice-box table tr.details td {
                padding-bottom: 20px
            }

            .invoice-box table tr.item td {
                border-bottom: 1px solid #eee
            }

            .invoice-box table tr.item.last td {
                border-bottom: none
            }

            .invoice-box table tr.total td:nth-child(2) {
                border-top: 2px solid #eee;
                font-size: 24px;
                line-height: 32px;
                text-transform: uppercase;
                font-weight: 600;
                color: #036
            }
        </style>
        <div class="invoice_header">
            <a href="javascript:void(0)" target="_blank" class="download_invoice">Download</a>
            <button class="close_invoice">Close</button>
        </div>
        <div class="invoice-box">
            <iframe src="" height="100%"></iframe>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('front/assets/js/demo-8.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.order_info', function (e) {
                e.stopPropagation()
                let order_info = $(this).next()
                if (order_info.hasClass('active')) {
                    order_info.removeClass('active')
                    order_info.find('.order_more_details_block').css('height', 0)
                    order_info.find('.order_more_details_block').css('padding', 0)
                } else {
                    order_info.find('.order_more_details_block').css('height', '100%')
                    order_info.find('.order_more_details_block').css('padding', '10px 5px')
                    order_info.addClass('active')
                }
            })

            $(document).on('click', '.view_invoice', function (e) {
                e.stopPropagation();
                $("#ec-overlay").show();

                let id = $(this).attr('data-id'),
                    path = $(this).attr('data-invoice')

                $.ajax({
                    type: "GET",
                    url: "/invoice/"+id+"?path=1",
                    success: function (data) {
                      var s = "data:application/pdf;base64,"+data;
                      $(".invoice-box iframe").attr('src',s);
                        $('.download_invoice').attr('href', '/invoice/'+id)
                        $('.invoice_modal').toggleClass('active')
                    },
                    complete: function() {
                        $("#ec-overlay").fadeOut("slow");
                    },

                    cache: true,
                    contentType: false,
                    processData: false,
                });



            });

            $(document).on('click', '.close_invoice', function () {
                $('.invoice_modal').toggleClass('active')
            })
        })
        let copyText = document.querySelector(".copy-text");
        copyText.querySelector("button").addEventListener("click", function () {
            let input = copyText.querySelector("input.text");
            input.select();
            document.execCommand("copy");
            copyText.classList.add("active");
            window.getSelection().removeAllRanges();
            setTimeout(function () {
                copyText.classList.remove("active");
            }, 2500);
        });
    </script>
@endpush
