<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta property="og:locale" content="vi_VN" />
    <meta http-equiv="content-language" content="vi" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @hasSection('seo_title')
        @hasSection('not_name')
    <title>@yield('seo_title')</title>
            @else
    <title>@yield('seo_title') - {{ config('app.name', 'ThiOnline') }}</title>
            @endif
        @else
    <title>{{ config('app.name', 'ThiOnline') }}</title>
    @endif
    <meta name="robots" content="index, follow"/>
    <meta name="description" content="@yield('seo_description', config('app.description'))" />
    <meta name="keywords" content="@yield('seo_keywords', config('app.keywords'))" />
    <link rel="icon" href="{{ asset(config('web.favicon')) }}" />
    <link rel="canonical" href="{{ url()->current() }}" reflang="vi-vn" />
    <meta property="og:title" content="@yield('og_title')" />
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="@yield('og_image', asset('images/banner_default.jpg'))" />
    <meta property="og:description" content="@yield('og_description')" />
    <meta property="og:site_name" content="{{ config('app.name', 'ThiOnline') }}" />
    <meta property="fb:app_id" content="{{ config('app.fb_app_id', '') }}" />
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/web/main.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('libs/select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ mix('css/web/exam.css') }}" type="text/css">
    @stack('styles')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QRSBGLTE3N"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-QRSBGLTE3N');

        window.fbAsyncInit = function() {
            FB.init({
                appId            : '{{ config('app.fb_app_id', '') }}',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v6.0'
            });
        };
    </script>
    <script async defer src="https://connect.facebook.net/vi_VN/sdk.js"></script>
</head>

<body>
    <div id="fb-root"></div>

    @yield('content')

    <script src="{{ mix('js/web/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libs/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ mix('js/web/exam.js') }}" type="text/javascript"></script>
    <script type="text/x-mathjax-config">
        MathJax.Hub.Config({
            showProcessingMessages: true,
            messageStyle: "none",
            showMathMenu: false,
            tex2jax: {
              inlineMath: [ ['$','$'], ["\\(","\\)"], ["\\[","\\]"] ],
              displayMath: [ ['$$','$$'] ],
              processEscapes: true
            },
            "HTML-CSS": {
                scale: 350
            }
        });
    </script>
    <script async src="{{ asset('libs/MathJax-2.7.5/MathJax.js') }}?config=TeX-MML-AM_CHTML"></script>
    <script>
        @if (session()->has('message'))
            toastr.success('{{ session('message') }}');
        @endif
        @if (session()->has('error'))
            toastr.error('{{ session('error') }}');
        @endif
        @if (session()->has('warning'))
            toastr.warning('{{ session('error') }}');
        @endif
    </script>
</body>

</html>
