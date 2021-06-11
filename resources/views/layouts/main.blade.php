<!doctype html>
<html  lang="ru">


<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/public/web_assets/images/favicon.ico">

    <!-- CSS
	============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/public/web_assets/css/vendor/bootstrap.min.css">

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="/public/web_assets/css/vendor/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="/public/web_assets/css/vendor/font-awesome.min.css">
    <link rel="stylesheet" href="/public/web_assets/css/vendor/themify-icons.css">
    <link rel="stylesheet" href="/public/web_assets/css/vendor/cryptocurrency-icons.css">
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">

    <!-- OWl  Carousel -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.css'>
    <!--  -->

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="/public/web_assets/css/plugins/plugins.css">

    <!-- Helper CSS -->
    <link rel="stylesheet" href="/public/web_assets/css/helper.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="/public/web_assets/css/style.css">


    @yield('styles')

</head>

<body>

<div class="main-wrapper">
    @yield('content')
</div>

<!-- JS
============================================ -->

<!-- Global Vendor, plugins & Activation JS -->
<script src="/public/web_assets/js/vendor/modernizr-3.6.0.min.js"></script>
<script src="/public/web_assets/js/vendor/jquery-3.3.1.min.js"></script>
<script src="/public/web_assets/js/vendor/popper.min.js"></script>
<script src="/public/web_assets/js/vendor/bootstrap.min.js"></script>
<!--Plugins JS-->
<script src="/public/web_assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/public/web_assets/js/plugins/tippy4.min.js.js"></script>
<!--Main JS-->
<script src="/public/web_assets/js/main.js"></script>
<script src="/public/web_assets/js/custom.js"></script>


@yield("scripts")

</body>

</html>
