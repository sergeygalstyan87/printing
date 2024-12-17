@extends('emails.layout')
@section('content')
    <tr>
        <td colspan="5">
            <h2 style="margin:0;padding:0;color:#6d6e71">Dear {{ $order->user ? $order->user->first_name.' '.$order->user->last_name : $order->first_name.' '.$order->last_name}},</h2>
        </td>
    </tr>
    <tr style="padding-bottom:16px">
        <td colspan="5" style="padding-left:16px">
            <div align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td style="font-size:14px">
                                                    <div>
                                                        <div>
                                                            Thank you for placing an order with Yans Print!
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td style="font-size:12px">
                                                    <div>
                                                        <div>
                                                            <p>Click here <a style="color: #ff5c75;font-weight: bold" target="_blank" href="{{ config('app.url') }}pay-order/{{$order->invoice_number}}">Pay</a> for order confirmation </p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td style="border:1px solid #dfdfdf;padding:15px 10px 0px 10px" valign="top" width="50%" height="160" bgcolor="#F5F5F5">


                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                        <tr>
                                                            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:bold;color:#5b656d;line-height:17px;text-align:center" colspan="2">
                                                                <div>
                                                                    Order Details                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Merchandise Total</td>

                                                            <td>${{number_format($order->original_amount, 2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tax</td>

                                                            <td>${{number_format($order->tax, 2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Shipping</td>
                                                            <td>${{number_format($order->shipping_price, 2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total:</td>

                                                            <td>${{number_format($order->amount, 2)}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px dashed gainsboro;margin-top:13px">
                                                        <tbody>
                                                        <tr>
                                                            <td style="FONT-SIZE:11px;FONT-FAMILY:Arial,Helvetica,sans-serif;FONT-WEIGHT:bold;COLOR:#5b656d;PADDING-BOTTOM:5px;TEXT-ALIGN:center;LINE-HEIGHT:14px;BACKGROUND-COLOR:white">
                                                                <div>***Applied Discounts***</div>

                                                                <span style="text-align:left;display:block;width:100%">- Web Exclusive: Free Shipping on orders over $200!!</span>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                                </td>
                                                <td style="line-height:0">
                                                    &nbsp;
                                                </td>
                                                <td style="border:1px solid #dfdfdf;padding:15px 10px 0px 10px" valign="top" width="50%" height="160" bgcolor="#F5F5F5">
                                                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:bold;color:#5b656d;line-height:17px;text-align:left">
                                                                <div>Shipping Details</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight:bold;color:#5b656d;padding-bottom:6px">
                                                                @if($order->address)
                                                                <address style="margin-bottom:0px;padding-bottom:0px;padding-top:0px">
                                                                    {{$order->first_name}} {{$order->last_name}}
                                                                    <br>
                                                                    {{$order->unit}} {{$order->address}}<br>{{$order->city}}, {{$order->state}} {{$order->zip}}
                                                                </address>
                                                                @endif
                                                                <div>
                                                                    <span style="font-size:12px">Phone: {{$order->phone}}</span>
                                                                </div>
                                                                <div></div>
                                                                <div style="border-top:1px solid #dfdfdf;padding-top:5px;margin-top:5px;word-break:break-word"><a href="mailto:{{$order->email}}" target="_blank" style="color: #3474d4">{{$order->email}}</a></div>
                                                            </td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellspacing="0" cellpadding="0" style="border:1px solid #dfdfdf;margin-top:10px;width:100%">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <table style="width:100%">
                                                        <thead>
                                                        <tr>
                                                            <th style="text-align:left;width:65%;border:1px solid #dfdfdf" bgcolor="#F5F5F5">
                                                                Estimated Ready for Shipping/Pickup: {{isset($order->delivery->days) ? $order->delivery->days : ""}} business days</th>
                                                            <th style="text-align:right;white-space:nowrap;width:50%;border:1px solid #dfdfdf" bgcolor="#F5F5F5">Local Delivery</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="2">
                                                                <table style="width:100%;border-collapse: collapse;">
                                                                    <thead>
                                                                    <tr>
                                                                        <th width="35%" style="border:1px solid #dfdfdf">Product</th>
                                                                        <th width="45%" style="border:1px solid #dfdfdf">Description</th>
                                                                        <th width="10%" style="border:1px solid #dfdfdf;padding: 0 5px">Quantity</th>
                                                                        <th width="10%" style="border:1px solid #dfdfdf">Price</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="border:1px solid #dfdfdf">
                                                                            <table style="width:100%">
                                                                                <tbody><tr>
                                                                                    <td width="80%" style="width:80%;white-space:nowrap;border:0px">
                                                                                        <a href="{{route('product', $order->product->slug)}}" target="_blank" style="color: #3474d4">
                                                                                            {{ $order->product->title }}
                                                                                        </a>
                                                                                    </td>
                                                                                    <td width="20%" style="width:20%;border:0px;text-align:right">
                                                                                        <table width="50" style="width:50px" cellpadding="0" cellspacing="0" border="0">
                                                                                            <tbody><tr>
                                                                                                <td style="border:0px">
                                                                                                    <img width="50" style="max-width:100%;height:auto" src="{{ asset('storage/content/' . $order->product->images[0]) }}">
                                                                                                </td>
                                                                                            </tr>
                                                                                            </tbody></table>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody></table>
                                                                        </td>

                                                                        <td style="border:1px solid #dfdfdf">
                                                                            @foreach($details['types'] as $key=>$val)
                                                                                <span>
                                                                                    {{$val}},
                                                                                </span>
                                                                            @endforeach</td>
                                                                        <td style="border:1px solid #dfdfdf">{{ $order->qty }}</td>
                                                                        <td style="border:1px solid #dfdfdf">${{ number_format($order->original_amount, 2) }}</td>
                                                                    </tr>
                                                                    </tbody>

                                                                </table>

                                                            </td>
                                                        </tr>
                                                        </tbody>

                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:30px">
                                            <tbody>

                                            <tr>
                                                <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000;font-weight:bold;padding:10px;text-align:center">
                                                    <img style="width: 640px" alt="yansprint" src="{{asset('/front/assets/images/emails/place_order.jpg')}}">
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
@endsection
