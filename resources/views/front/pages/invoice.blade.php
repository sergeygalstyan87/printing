<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Invoice</title>

    <style>
        @page {
            margin: 0
        }
        html {
            margin: 0;
            padding: 0
        }
        body {
            margin: 0;
            padding: 0;
            background-position: center;
            background-size: 100% 100%;
            font-family:'Lato', sans-serif;
        }
        .invoice-box {
            width: calc(100% - 60px);
            height: calc(100vh - 60px);
            padding: 30px 30px 0;
            font-size: 16px;
            line-height: 24px;
            font-family:'Lato', sans-serif;
            color: #555
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left
        }
        .invoice_text {
            font-size: 80px;
            line-height: 80px;
            font-weight: 600;
            text-transform: uppercase;
            color: #036;
            padding: 0 !important
        }
        table .company_info td {
            padding: 30px 5px
        }
        .invoice_heading {
            font-size: 16px;
            line-height: 32px;
            text-transform: uppercase;
            font-weight: bold;
            font-family: inherit;
            /*color: #036*/
        }
        table td {
            padding: 10px 5px
        }
        .total_info td {
            padding: 0;
        }
        .top p {
            margin: 2px 0 0;
            font-size: 14px
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right
        }
        .invoice-box table tr.top table td.title {
            font-size: 13px;
            line-height: 15px;
            color: #333
        }
        .invoice-box table tr.information table td {
            padding: 40px 0;
        }
        .invoice-box table tr.heading td {
            background: #0b3366;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
            line-height: 15px;
            text-transform: uppercase;
            font-weight: bold;
            color: #fff;
            font-family: inherit;
            padding-bottom: 8px;
            padding-top: 8px;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee
        }
        .invoice-box table tr.item:last-child td {
            border-bottom: none
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-size: 24px;
            line-height: 32px;
            text-transform: uppercase;
            font-weight: bold;
            color: #036
        }
        .tax {
            text-align: right;
            width: 40%
        }
        .text_info_block {
            text-align: center;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            margin: 150px auto 20px;
        }
        .text_info_block p {
            margin: 0;
            padding: 0;
            font-size: 10px;
            line-height: 1.2
        }
        .vertical_center{
            padding: 8px 5px;
            line-height: 15px;
            background-color: #0b3366;
            color : white;
            text-align: left;
        }
    </style>
</head>

<body style="background-image: url('{{ asset('/front/assets/images/invoice/invoice.svg') }}')">
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="4">
                <table style="width: unset;">
                    <tr>
                        <td class="invoice_text" style="vertical-align: middle;text-align:right;">
                            <img src="{{ asset('/front/assets/images/logo/logo_for_invoice.png') }}"
                                 style="width: 130px;margin: 0 25px 0 40px"/>
                        </td>
                        <td class="title" style="text-align: left">
                            {{--                            <p><b>YANS PARTNERS INC DBA YANS PRINT</b></p>--}}
                            <p><b>Yans Creative Team, Inc. DBA Yans Print</b></p>
                            <p>14701 Arminta St Ste A</p>
                            <p>Panorama City, CA 91402</p>
                            <p>(323) 886-6860</p>
                            <p>sales@yansprint.com</p>
                            <p>www.yansprint.com</p>
                        </td>

                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="4" style="padding: 0;">
                <table style="border-spacing: 0;">
                    <tr>
                        <td class="" style="vertical-align: bottom">
                            <span class="invoice_heading" style="margin-left: 40px">Bill To</span>
                            <p style="font-size:12px;line-height:15px;margin-left: 40px">
                                @if($item->company)
                                    {{ $item->company }}<br/>
                                @endif
                                @if($item->first_name)
                                        {{ $item->first_name }} {{$item->last_name}}<br/>
                                @endif
                                @if($item->delivery_type == 'shipping')
                                    {{$item->unit.' '.$item->address}}<br/>
                                    {{$item->city.', '.$item->state.', '.$item->zip}}<br/>
                                @endif
                                @if($item->phone)
                                    {{ $item->phone }}<br/>
                                @endif
                                @if($item->email)
                                    {{ $item->email }}
                                @endif
                            </p>
                            <div style="padding: 5px; background-color: #0b3366;margin-right: 25px;"></div>

                        </td>

                        <td style="vertical-align: bottom;text-align: right;width: 200px">
                            <div class="vertical_center" style="margin-bottom: 15px;font-size: 20px;line-height: 20px">
                                <b class="invoice_heading1">Invoice #</b> {{ $item->invoice_number }}

                            </div>
                            <div class="vertical_center">
                                <b class="invoice_heading1">DATE</b> {{ $item->created_at->format('n/j/Y') }}
                            </div>
                            @if($item->delivery_id)
                                <div class="vertical_center" style="margin-top: 15px">
                                    <b class="invoice_heading1">DUE DATE</b> {{ $newDate->format('n/j/Y') }}
                                </div>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td width="200px" style="text-align: left;border-right: 1px solid white;padding-left: 40px">ACTIVITY</td>
            <td width="20px" style="text-align: right;border-right: 1px solid white">QTY</td>
            <td width="30px" style="text-align: right;border-right: 1px solid white">Rate</td>
            <td width="30px" style="text-align: center;">Amount</td>
        </tr>

        <tr class="item">
            <td style="text-align: left;padding-left: 40px">
                <b>{{ $item->product->title }}</b>
                <ul style="line-height: 15px; font-size: 13px;">
                    @foreach($details['types'] as $key=>$val)
                        <li>
                            <b>{{$key}}:</b>
                            {{$val}}
                        </li>
                    @endforeach
                </ul>

            </td>
            <td style="text-align: right;">{{ $details['quantity'] }}</td>
            <td style="text-align: right;">
                ${{ number_format(($item->original_amount / $details['quantity']),2) }}
            </td>
            <td style="text-align: center;padding-left: 25px;">${{ number_format($item->original_amount, 2) }}</td>
        </tr>
            <td style="text-align: center;vertical-align: bottom">
                @if($item->status == 'completed')
                    <img style="width: 150px" src="{{ asset('/front/assets/images/emails/paid_stamp.png') }}">
                @endif
            </td>
            <td colspan="3">
                <table class="total_info">
                    <tr class="tax" style="text-align: right;width: 35%">
                        <td style="text-align: left;">SUBTOTAL</td>
                        <td style="text-align: right;padding-right: 40px">
                            <span style="font-weight: bold">${{explode('.', number_format($item->original_amount,2))[0]}}</span>.{{explode('.', number_format($item->original_amount,2))[1] }}</td>
                    </tr>
                    @if($item->coupon_id)
                        <tr class="coupon" style="text-align: right;width: 35%">
                            <td style="text-align: left; color: #ed3237">Discount ({{$details['coupon']['percent'].'%'}})</td>
                            <td style="text-align: right;font-weight: bold;padding-right: 40px"></td>
                        </tr>
                    @endif
                    <tr class="tax" style="text-align: right;width: 35%">
                        @php
                            use Illuminate\Support\Facades\DB;
                            if($item->delivery_type === 'shipping'){
                                $rate = DB::table('zip_codes')
                                ->where('zip', $item->zip)
                                ->value('rate');
                            }else{
                                $rate = DB::table('zip_codes')
                                ->where('zip', '91402')
                                ->value('rate');
                            }

                            $rateMultiplied = number_format($rate * 100, 1);
                        @endphp
                        <td style="text-align: left;">TAX (<span style="font-weight: bold">{{$rateMultiplied}}</span>%)</td>
                        <td style="text-align: right;padding-right: 40px">
                            <span style="font-weight: bold">${{explode('.', number_format($item->tax,2))[0]}}</span>.{{explode('.', number_format($item->tax,2))[1] }}</td>
                    </tr>
                    @if($item->delivery_type == 'shipping')
                        <tr class="tax" style="text-align: right;width: 35%">
                            <td style="text-align: left;">SHIPPING</td>
                            <td style="text-align: right;padding-right: 40px">
                                <span style="font-weight: bold">${{explode('.', number_format($item->shipping_price,2))[0]}}</span>.{{explode('.', number_format($item->shipping_price,2))[1] }}</td>
                        </tr>
                    @endif
                    <tr class="tax" style="text-align: right;width: 35%">
                        <td style="text-align: left;">TOTAL</td>
                        <td style="text-align: right;padding-right: 40px">
                            <span style="font-weight: bold">${{explode('.', number_format($item->amount,2))[0]}}</span>.{{explode('.', number_format($item->amount,2))[1] }}</td>
                    </tr>
                    <tr >
                        <td style="height: 15px"></td>
                    </tr>
                    <tr class="tax"
                        style="color:#fff;font-size: 16px;background-color: #0b3366;text-align: right;width: 35%;">
                        <td style="text-align: left;padding: 8px 5px;line-height: 15px">TOTAL DUE</td>
                        <td style="text-align: right;padding: 8px 40px 8px 5px;font-weight: bold;line-height: 15px"> ${{ number_format($item->amount,2) }}</td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>
    <div class="text_info_block">
        <p>Initial 50% deposit is required to start the project for projects over $1000. Remaining project balance needs
            to be paid prior to installation/pick up.</p>
        <p>For permitted projects, City fees will be added to the final invoice and they will be billed at cost.</p>
        <p>In case of cancellations, service fees will apply based on the amount of work performed to date.</p>
    </div>
</div>
</body>
</html>
