<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Invoice</title>

    <style>
        @page{margin:0}
        html{margin:0;padding:0}
        body{margin:0;padding:0;background-position:center;background-size:100% 100%}
        .invoice-box{width:calc(100% - 60px);height:calc(100vh - 60px);padding:30px 30px 0;font-size:16px;line-height:24px;font-family:'Lato', sans-serif;;color:#555}
        .invoice-box table{width:100%;line-height:inherit;text-align:left}
        .invoice_text{font-size:80px;line-height:80px;font-weight:600;text-transform:uppercase;color:#036;padding:0!important}
        table .company_info td{padding:30px 5px}
        .invoice_heading{font-size:24px;line-height:32px;text-transform:uppercase;font-weight:600;color:#036}
        table td{padding:5px}
        .invoice-box table tr td:nth-child(2){text-align:right}
        .invoice-box table tr.top table td.title{font-size:13px;line-height:15px;color:#333}
        .invoice-box table tr.information table td{padding:80px 0 40px}
        .invoice-box table tr.heading td{background:#eee;border-bottom:1px solid #ddd;font-size:16px;line-height:18px;text-transform:uppercase;font-weight:600;color:#036}
        .invoice-box table tr.details td{padding-bottom:20px}
        .invoice-box table tr.item td{border-bottom:1px solid #eee}
        .invoice-box table tr.item.last td{border-bottom:none}
        .invoice-box table tr.total td:nth-child(2){border-top:2px solid #eee;font-size:24px;line-height:32px;text-transform:uppercase;font-weight:600;color:#036}
    </style>
</head>

<body style="background-image: url('{{ asset('/front/assets/images/invoice/invoice.svg') }}')">
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">YANS PARTNERS INC DBA YANS PRINT</b><br/>
                                14701 Arminta St Ste A<br/>
                                Panorama City, CA, 91402<br/>
                                (323) 886-6860<br/>
                                sales@yansprint.com<br/>
                                www.yansprint.com
                            </td>
                            <td class="invoice_text">
                                <img src="{{ asset('/front/assets/images/logo/logo-8.png') }}"
                                     style="width: 100%; max-width: 250px"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="">
                                <span class="invoice_heading">Bill To</span>
                                <p style="font-size:12px;line-height:15px">
                                    {{ $item->company }}<br/>
                                    {{ $item->first_name }} {{ $item->last_name }}<br/>
                                    {{$item->unit.' '.$item->address}}<br/>
                                    {{$item->city.', '.$item->state.', '.$item->zip}}<br/>
                                    {{$item->phone}}<br/>
                                    {{$item->email}}
                                </p>

   </td>

   <td>
       <div>
           <span class="invoice_heading">Invoice #</span> E{{ $item->id + 100000 }}
                                </div>
                                <div>
                                    <span class="invoice_heading">INVOICE DATE</span> {{ $item->created_at->format('d-m-Y') }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td width="20px" style="text-align: center;">QTY</td>
                <td width="200px" style="text-align: center;">Description</td>
                <td width="30px" style="text-align: right;">Unit price</td>
                <td width="30px" style="text-align: right;">Amount</td>
            </tr>

            <tr class="item">
                <td style="text-align: center;">{{ $details['quantity'] }}</td>
                <td style="text-align: left;">
                    {{ $item->product->title }}
                    <ul >
                        @foreach($details['types'] as $key=>$val)
                            <li>
                                <b>{{$key}}:</b>
                                {{$val}}
                            </li>
                        @endforeach
                    </ul>

                </td>

                <td style="text-align: right;">
                    ${{ number_format(($item->original_amount / $details['quantity']),3) }}
                </td>
                <td style="text-align: right;">${{ $item->original_amount }}</td>
            </tr>
            <tr class="tax">
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;">Tax: ${{ $item->tax }}</td>
            </tr>
            @if($item->delivery_type == 'shipping')
            <tr class="tax">
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;">Shipping: ${{ $item->shipping_price }}</td>
            </tr>
            @endif
            <tr class="tax">
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right; font-size: 18px;">Total: ${{ $item->amount }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
