<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <title>Request Approved</title>
    <style>
        .social_media a{
            display: inline-block;
        }
        .social_media div{
            padding:5px;width:20px;height:20px;background-color: #dcdcdc;border-radius: 50%;display: grid; place-items: center;border: 1px solid #eee;
        }
        .social_media img{
            width: 75%;height: 75%;margin: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <table width="570" style="width:570px;font-family:Arial,Verdana,Helvetica,sans-serif;font-size:16px;color:#000;background:#fff" border="0" cellpadding="0" cellspacing="0">
        <tbody><tr>
            <td>

                <table id="m_1870541167626481773m_3800133798147443376header" style="padding:16px;padding-top:4px;padding-bottom:0px" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td rowspan="2" style="width:115px;padding:5px 20px 0 0;vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif">
                            <a href="{{route('home')}}" rel="tooltip" title="YansPrint" target="_blank">
                                <img style="border:0;width:200px" alt="YansPrint" src="{{asset('/front/assets/images/logo/new_logo.png')}}">
                            </a>
                        </td>
                        <td style="text-align:right;padding:5px 0;border-bottom:0px solid rgb(204,204,204);white-space:nowrap;vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif">
                        </td>
                        <td style="width:100%;text-align:right;padding:5px 0;border-bottom:0px solid rgb(204,204,204);white-space:nowrap;vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif">
                        </td>
                        <td style="text-align:right;padding:5px 0;border-bottom:0px solid rgb(204,204,204);white-space:nowrap;vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif;min-width:180px">
                            <span style="text-decoration:none;color:rgb(204,204,204);font-size:15px;font-family:Arial,sans-serif">&nbsp;|&nbsp;</span>
                            <a href="{{route('profile.index')}}" style="border-right:0px solid rgb(204,204,204);margin-right:0px;padding-right:0px;text-decoration:none;color:#3474d4;font:12px/16px Arial,sans-serif" target="_blank">
                                Your Account
                            </a>
                            <span style="text-decoration:none;color:rgb(204,204,204);font-size:15px;font-family:Arial,sans-serif">&nbsp;|&nbsp;</span>
                            <a href="{{route('home')}}" style="border:0;margin:0;padding:0;border-right:0px solid rgb(204,204,204);margin-right:0px;padding-right:10px;text-decoration:none;color:#3474d4;font:12px/16px Arial,sans-serif" target="_blank">Yansprint.com</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:right;padding:7px 0 5px 0;vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif">
                        </td>
                    </tr>
                    </tbody>
                </table>


                <table width="100%" cellspacing="0" cellpadding="10" align="left">

                    <tbody><tr>
                        <td style="padding:0;border-collapse:collapse;border-spacing:0">


                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%;max-width:100%;border-color:transparent;border-collapse:collapse;border-spacing:0;width:100%;border-color:transparent;background:#fff;border-top:1px solid #6d6e71">
                                <tbody>
                                <tr>
                                    <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0">

                                        <table style="width:100%;max-width:100%;border-color:transparent;border-collapse:collapse;border-spacing:0">
                                            <tbody>

                                            <tr>
                                                <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;padding:20px 30px 0;padding:16px 16px 0;padding-top:20px;padding-bottom:10px">
                                                    <table style="width:100%;max-width:100%;border-color:transparent;border-collapse:collapse;border-spacing:0">
                                                        <tbody>
                                                        <tr>
                                                            <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;padding:0 0;text-align:left;vertical-align:top">

                                                                <table style="width:100%;max-width:100%;border-color:transparent;border-collapse:collapse;border-spacing:0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="text-align:center;width:450px;max-width:450px">
                                                                            <h5 style="font-size:20px;margin-top:4px;margin-bottom:8px;color:#6d6e71">
                                                                                Items on Order #{{$order->est_number}} are ready for pickup!
                                                                            </h5>


                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align:center">
                                                                            <img style="border:0;width:300px;margin-top:10px" width="400" alt="yansprint" src="{{asset('/front/assets/images/emails/track_pickedup.png')}}">
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

                                            <tr>
                                                <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;padding:20px 10px 0;padding:16px 16px 0">
                                                    <table style="width:100%;max-width:100%;border-color:transparent;border-collapse:collapse;border-spacing:0">
                                                        <tbody>
                                                        <tr>
                                                            <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;padding:0 0 20px;text-align:left;vertical-align:top;text-align:left">
                                                                <table style="width:100%;max-width:100%;border-color:transparent;border-collapse:collapse;border-spacing:0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;vertical-align:top;text-align:left;width:55%;padding:0 10px 0 0">
                                                                            <table style="width:100%;max-width:100%;border-color:transparent;border-collapse:collapse;border-spacing:0">
                                                                                <tbody>

                                                                                <tr>
                                                                                    <td style="font-size:14px;width:185px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;vertical-align:top;text-align:left;padding:0 0 10px;font-weight:bold">
                                                                                        Order
                                                                                        Number:
                                                                                    </td>

                                                                                    <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;vertical-align:top;text-align:left;padding:0 0 10px">
                                                                                        <a href="{{route('profile.orders')}}" style="color:#3474d4;border:none;outline:none" target="_blank">{{$order->est_number}}</a>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size:14px;width:185px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;vertical-align:top;text-align:left;padding:0 0 10px;font-weight:bold">
                                                                                        Date
                                                                                        Ordered:
                                                                                    </td>

                                                                                    <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;vertical-align:top;text-align:left;padding:0 0 10px">
                                                                                        {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('dddd, MMMM Do') }}
                                                                                    </td>
                                                                                </tr>


                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td>
                                                                            <table style="width:100%;max-width:100%;border-color:transparent;border-collapse:collapse;border-spacing:0">
                                                                                <tbody>

                                                                                <tr>
                                                                                    <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;vertical-align:top;text-align:left;padding:0 0 10px;font-weight:bold">
                                                                                        PickUp Address:
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;vertical-align:top;text-align:left;padding:0 0 10px">
                                                                                        <span> Yans Creative Team, Inc. DBA Yans Print.</span><br>
                                                                                        <span>14701 Arminta St Ste A Panorama City,</span><br>
                                                                                        <span>CA 91402</span><br>
                                                                                        <span>Mon - Fri 10AM - 4PM</span><br>
                                                                                        <span>Saturday 10AM - 3PM</span><br>
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
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding:6px 16px 0px 16px">
                                                    <table style="width:100%;max-width:100%;border-color:transparent;border-collapse:collapse;border-spacing:0;margin-top:6px">
                                                        <tbody><tr>
                                                            <td style="padding-bottom:0px;padding-left:0px">
                                                                <table style="width:100%;max-width:100%;border-color:#e5e5e5;border-collapse:collapse;border-spacing:0">
                                                                    <tbody><tr>
                                                                        <td style="width:120px;padding-bottom:0px;color:white;border-top-right-radius:5px;text-transform:uppercase;border-top-left-radius:5px;padding-top:3px;text-align:center;padding-bottom:3px;background-color:#6d6e71;text-transform:uppercase">
                                                                            <span style="margin-left:0px;font-size:14px">
                                                                                Picked Up
                                                                            </span>
                                                                        </td>
                                                                        <td style="padding-bottom:0px">
                                                                        </td>
                                                                    </tr>
                                                                    </tbody></table>
                                                            </td>
                                                        </tr>
                                                        </tbody></table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;padding:0 16px">
                                                    <table style="border:1px solid gainsboro;border-top:0;width:100%;max-width:100%;border-collapse:collapse;border-spacing:0">
                                                        <thead>
                                                        <tr style="border-bottom:2px solid #ededed;border-top:2px solid #ededed">
                                                            <th style="background:white;font-size:12px;font-weight:bold;padding:5px 15px;vertical-align:middle;text-align:left;border-bottom:1px solid gainsboro">
                                                                Item
                                                            </th>
                                                            <th style="background:white;font-size:12px;font-weight:bold;padding:5px 15px;vertical-align:middle;text-align:center;border-bottom:1px solid gainsboro">
                                                                Quantity
                                                            </th>
                                                            <th style="background:white;font-size:12px;font-weight:bold;padding:5px 15px;vertical-align:middle;text-align:right;border-bottom:1px solid gainsboro">
                                                                Price
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        <tr>
                                                            <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;vertical-align:top;padding:15px 0 15px 15px;text-align:left;background-color:white">

                                                                <div style="display:inline-block;zoom:1;vertical-align:top;font-size:16px">

                                                                    <a href="" title="{{$order->product->title}}" style="color:rgb(0,57,83);border:none;outline:none;display:block;padding:0 15px 0 0;text-decoration:none" target="_blank">
                                                                        <img src="{{ asset('storage/content/' . $order->product->images[0]) }}" alt="{{$order->product->title}}" width="50" style="border:0;line-height:100%;outline:none;text-decoration:none;max-width:100%">
                                                                    </a>
                                                                </div>

                                                                <div style="display:inline-block;zoom:1;vertical-align:top;max-width:260px">
                                                                    <a href="{{route('product', $order->product->slug)}}" title="{{$order->product->title}}" style="color:#3474d4;border:none;outline:none;color:rgb(31,31,31)!important;text-decoration:none" target="_blank">
                                                                        <span style="color:#3474d4!important;text-decoration:underline;text-decoration:underline;font-size:14px">{{ $order->product->title }}</span><br>
                                                                        @foreach($details['types'] as $key=>$val)
                                                                            <span>
                                                                                {{$val}},
                                                                            </span>
                                                                        @endforeach
                                                                        <br>
                                                                    </a>
                                                                </div>

                                                            </td>
                                                            <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;vertical-align:top;padding:15px;text-align:center;background-color:white">
                                                                {{ $order->qty }}
                                                            </td>
                                                            <td style="font-size:14px;line-height:20px;color:rgb(31,31,31);border-collapse:collapse;border-spacing:0;vertical-align:top;padding:15px;text-align:right;background-color:white">
                                                                ${{ number_format($order->original_amount, 2) }}
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

                        </td>
                    </tr>
                    </tbody></table>

                <table cellspacing="0" cellpadding="0" align="center" bgcolor="#fff" style="border-collapse:collapse;border-spacing:0px;background-color:#fff;width:680px">
                    <tbody>
                    <tr style="padding-bottom:16px">
                        <td colspan="5" align="center" style="padding-top:32px">
                            <a href="{{route('home')}}" rel="tooltip" title="YansPrint" target="_blank" >
                                <img width="100" style="width:180px;height:40px" src="{{asset('/front/assets/images/logo/new_logo.png')}}">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center" style="padding-bottom:0px">
                            <p style="color:#6d6e71">Stay updated on Yans Print, see customer projects, tutorials, vendor events, and more through our socials!</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center" style="padding-top:0px" class="social_media">
                            <a style="color:none;text-decoration:none" href="https://www.facebook.com/yansprintLA" rel="tooltip" title="Facebook" target="_blank">
                                <div>
                                    <img src="{{asset('/front/assets/images/icons/social_icons/facebook.png')}}">
                                </div>
                            </a>
                            <a style="color:none;text-decoration:none" href="https://www.youtube.com/@yansprint6804" rel="tooltip" title="YouTube" target="_blank">
                                <div>
                                    <img src="{{asset('/front/assets/images/icons/social_icons/youtube.png')}}">
                                </div>
                            </a>
                            <a style="color:none;text-decoration:none" href="https://www.instagram.com/yans_print/" rel="tooltip" title="Instagram" target="_blank">
                                <div>
                                    <img src="{{asset('/front/assets/images/icons/social_icons/instagram.png')}}">
                                </div>
                            </a>
                            <a style="color:none;text-decoration:none" href="https://www.etsy.com/shop/YansPrint?ref=seller-platform-mcnav" rel="tooltip" title="Etsy" target="_blank">
                                <div>
                                    <img src="{{asset('/front/assets/images/icons/social_icons/etsy.png')}}">
                                </div>
                            </a>
                        </td>
                    </tr>
                    </tbody></table>

                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tbody><tr>
                        <td colspan="5" align="center" style="color:#6d6e71;font-size:12px;padding-top:16px">
                            &copy; Yans Creative Team, Inc. DBA Yans Print. All rights reserved. 14701 Arminta St Ste A Panorama City, CA 91402
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center" style="padding:24px 0">
                            <a style="margin:8px;color:#3474d4" href="{{route('terms')}}" target="_blank">Terms &amp; Conditions</a>
                            <a style="margin:8px;color:#3474d4" href="{{route('policy')}}" target="_blank">Privacy Policy</a>
                        </td>
                    </tr>
                    </tbody></table>
            </td></tr></tbody></table>
</div>
</body>
</html>






