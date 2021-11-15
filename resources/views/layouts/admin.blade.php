<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fontawesome icon CSS -->
        <link rel="stylesheet" href="{{ asset('adminux/vendor/font-awesome-4.7.0/css/font-awesome.min.css') }}" type="text/css">
        <!-- select2 -->
        <link rel="stylesheet" href="{{ asset('adminux/vendor/select2/dist/css/select2.min.css') }}" type="text/css">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('adminux/vendor/bootstrap4beta/css/bootstrap.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('adminux/css/dark_blue_adminux.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ mix('css/admin/main.css') }}" type="text/css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        @stack('styles')
    </head>
    <body class="horizontal-menu">
        <!-- Page Loader -->
        <div class="loader_wrapper inner align-items-center text-center">
            <div class="load7 load-wrapper">
                <div class="loading_img"></div>
                <div class="loader"> Loading... </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- Page Loader Ends -->
        @include('admin.components.header')
        @include('admin.components.sidebar')
        <div class="wrapper-content">
            {{ $slot }}
            @include('admin.components.footer')
        </div>
        @stack('modals')
        <!-- Scripts -->
        <script src="{{ asset('adminux/js/jquery-2.1.1.min.js') }}" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="{{ asset('adminux/vendor/bootstrap4beta/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <!--Cookie js for theme chooser and applying it -->
        <script src="{{ asset('adminux/vendor/cookie/jquery.cookie.js') }}"  type="text/javascript"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="{{ asset('adminux/js/ie10-viewport-bug-workaround.js') }}"></script>
        <!-- Circular chart progress js -->
        <script src="{{ asset('adminux/vendor/cicular_progress/circle-progress.min.js') }}" type="text/javascript"></script>
        <!--sparklines js-->
        <script src="{{ asset('adminux/vendor/sparklines/jquery.sparkline.min.js') }}" type="text/javascript"></script>
        <!-- select2 -->
        <script src="{{ asset('adminux/vendor/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>
        <!-- custome template js -->
        <script src="{{ asset('adminux/js/adminux.js') }}" type="text/javascript"></script>
        <script src="{{ mix('js/admin/main.js') }}" type="text/javascript"></script>

        
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script type="text/x-mathjax-config">
            MathJax.Hub.Config({
                showMathMenu: false,
                "HTML-CSS": {
                    scale: 350
                },
                tex2jax: {
                    inlineMath: [
                        ['$','$'],
                        ['\\(','\\)']
                    ]
                }
            });
        </script>
        <script type="text/javascript" async src="{{ asset('libs/MathJax-2.7.5/MathJax.js') }}?config=TeX-MML-AM_CHTML"></script>

        @stack('scripts')
    </body>
</html>
