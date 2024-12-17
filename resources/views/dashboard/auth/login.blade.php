<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yansprint | Sign In</title>
    <!-- ================== GOOGLE FONTS ==================-->
    <link href="https://fonts.googleapis.com/css?family=Source Sans Pro:300,400,500" rel="stylesheet">
    <!-- ======================= GLOBAL VENDOR STYLES ========================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/vendor/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/metismenu/dist/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/switchery-npm/index.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}">
    <!-- ======================= LINE AWESOME ICONS ===========================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/icons/line-awesome.min.css') }}">
    <!-- ======================= DRIP ICONS ===================================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/icons/dripicons.min.css') }}">
    <!-- ======================= MATERIAL DESIGN ICONIC FONTS =================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/icons/material-design-iconic-font.min.css') }}">
    <!-- ======================= GLOBAL COMMON STYLES ============================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/common/main.bundle.css') }}">
    <!-- ======================= LAYOUT TYPE ===========================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/layouts/vertical/core/main.css') }}">
    <!-- ======================= MENU TYPE ===========================================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/layouts/vertical/menu-type/default.css') }}">
    <!-- ======================= THEME COLOR STYLES ===========================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/layouts/vertical/themes/theme-a.css') }}">
</head>

<body>
<div class="container">
    <form class="sign-in-form" action="{{ route('dashboard_login') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-body">
                <a href="{{ route('dashboard.index') }}" class="brand text-center d-block m-b-20">
                    <img src="{{ asset('/front/assets/images/logo/logo.svg') }}" alt="Yansprint Logo" width="150"/>
                </a>
                <h5 class="sign-in-heading text-center m-b-20">Sign in to your account</h5>
                <div class="form-group">
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert" style="display: block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert" style="display: block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="checkbox m-b-10 m-t-20">
                    <div class="custom-control custom-checkbox checkbox-primary form-check">
                        <input type="checkbox" class="custom-control-input" id="stateCheck1" checked="">
                        <label class="custom-control-label" for="stateCheck1">	Remember me</label>
                    </div>
{{--                    <a href="auth.forgot-password.html" class="float-right">Forgot Password?</a>--}}
                </div>
                <button class="btn btn-primary btn-rounded btn-floating btn-lg btn-block" type="submit">Sign In</button>
            </div>

        </div>
    </form>
</div>

<!-- ================== GLOBAL VENDOR SCRIPTS ==================-->
<script src="{{ asset('admin/assets/vendor/modernizr/modernizr.custom.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js-storage/js.storage.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js-cookie/src/js.cookie.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/pace/pace.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/metismenu/dist/metisMenu.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/switchery-npm/index.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<!-- ================== GLOBAL APP SCRIPTS ==================-->
<script src="{{ asset('admin/assets/js/global/app.js') }}"></script>

</body>

</html>
