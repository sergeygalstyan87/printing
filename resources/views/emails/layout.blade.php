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
    @yield('styles')
</head>
<body>
<div class="container">
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tbody>
        <tr>
            <td>
                <table width="570px" style="width:570px;font-family:Arial,Verdana,Helvetica,sans-serif;font-size:16px;color:#000" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td style="padding-top:16px">

                            <table width="100%" style="background-color:white;border:1px solid #a8a8a8;padding:16px" cellspacing="0" cellpadding="10" align="left">
                                <tbody><tr>
                                    <td colspan="5">
                                        <a href="{{route('home')}}" rel="tooltip" title="YansPrint" target="_blank">
                                            <img width="125" style="width:180px;height:40px" src="{{asset('/front/assets/images/logo/new_logo.png')}}">
                                        </a>
                                    </td>
                                </tr>
                                @yield('content')
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
{{--                                                <img src="{{asset('/front/assets/images/icons/social_icons/facebook.png')}}">--}}
                                                <img src="https://demo.yansprint.com/front/assets/images/icons/social_icons/facebook.png">
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
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
