<!DOCTYPE html>
<html lang="vi">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta property="og:locale" content="vi_VN" />
    <meta http-equiv="content-language" content="vi" />
    <meta name="csrf-token" content="tjSJbUKOSIn1TOuFDi0bgtuD4C1agTD6WWYWYAcO">
    <title>Trang web thi online miễn phí nhiều người truy cập nhất Việt Nam</title>
	<meta name="robots" content="index, follow"/>
    <meta name="description" content="Hệ thống bài kiểm tra, đề thi trắc nghiệm được thiết kế bám theo cấu trúc chương trình trong sách giáo khoa hiện hành giúp học sinh rèn luyện, kiểm tra kiến thức của mình theo mỗi bài, chương, .." />
    <meta name="keywords" content="đề thi thử, thư viện đề thi, ngân hàng câu hỏi, bài kiểm tra, thi trắc nghiệm miễn phí, Toán, Lý, Hóa, Sinh, Tiếng Anh, Sử, Địa, GDCD" />
    <link rel="icon" href="images/favicon.ico" />
    <link rel="canonical" href="index.html" reflang="vi-vn" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="index.html" />
    <meta property="og:image" content="images/banner_default.jpg" />
    <meta property="og:description" content="" />
    <meta property="og:site_name" content="Trang web thi online miễn phí nhiều người truy cập nhất Việt Nam" />
    <meta property="fb:app_id" content="142520407857771" />
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/web/main.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('libs/select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ mix('css/web/exam.css') }}" type="text/css">
        <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QRSBGLTE3N"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-QRSBGLTE3N');

        window.fbAsyncInit = function() {
            FB.init({
                appId            : '190377152734477',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v12.0'
            });
        };
    </script>
    <script async defer src="https://connect.facebook.net/vi_VN/sdk.js"></script>
</head>

<body>

	@include('web.components.header')
    <main id="app">
        <div class="main-page">
            @include('web.components.headline')
            @include('web.components.filter-exam')
            @yield('content')
        </div>
    </main>
	@include('web.components.footer')
	


	<!-- include js files -->
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
    </script>
</body>
</html>
