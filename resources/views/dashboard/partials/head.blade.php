<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Yansprint | Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/vendor/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/metismenu/dist/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/switchery-npm/index.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/icons/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/icons/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/icons/dripicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/icons/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/common/main.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/layouts/vertical/core/main.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/layouts/vertical/menu-type/default.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/layouts/vertical/themes/theme-a.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.1.1/ckeditor5.css" />
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.1.1/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.1.1/"
            }
        }
    </script>
    <script type="module" src="{{ URL::asset('vendor/ckeditor5.js') }}"></script>

    @laravelViewsStyles
</head>
