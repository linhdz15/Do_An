
<header>
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <div class="topbar">
            <div class="content-topbar container h-100">
                <div class="left-topbar">
                    <span class="left-topbar-item flex-wr-s-c">
                        <span class="m-r-8">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                        <span>
                            {{ getCurWeekDay() }}
                        </span>
                    </span>
                </div>
                <div class="right-topbar">
                    <div class="dropdown">
                        <a href="" class="left-topbar-item" data-toggle="modal" data-target="#loginModal">
                            <i class="far fa-edit"></i> Register
                        </a>
                        <a href="" class="left-topbar-item" data-toggle="modal" data-target="#loginModal">
                            <i class="fas fa-sign-in-alt"></i> Log in
                        </a>
                        <a target="_blank" class="branch-item" href="https://www.facebook.com/hoc.cung.vietjack">
                            <span class="fab fa-facebook-f"></span>
                        </a>
                        <a target="_blank" class="branch-item" href="https://www.youtube.com/c/HọccùngVietJack/featured">
                            <span class="fab fa-youtube"></span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <a href="#"><img src="{{url('images/logo.png')}}" alt="IMG-LOGO"></a>
            </div>
            <input id="search-mobile" type="checkbox" class="d-none">
            <div class="form-search ml-auto form-search-mobile">
                <form class="form-inline" method="get">
                    <a href="javascript:void(0)" class="btn-search"><i class="fas fa-search"></i></a>
                    <input autocomplete="off" class="form-control mr-sm-2" type="text" placeholder="Bạn muốn tìm gì?" name="keyword" aria-label="Search" value="">
                    <label class="cancel" for="search-mobile"><i class="fas fa-window-close"></i></label>
                </form>
            </div>
            <label class="btn-search-mobile" for="search-mobile">
                <i class="fas fa-search"></i>
            </label>
            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze m-r--8">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>
        <!-- Menu Mobile -->
        <div class="menu-mobile">
            <ul class="topbar-mobile">
                <li class="left-topbar">
                    <span class="left-topbar-item flex-wr-s-c">
                        <span class="m-r-8">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                        <span>
                            {{ getCurWeekDay() }}
                        </span>
                    </span>
                            <a href="" class="left-topbar-item" data-toggle="modal" data-target="#loginModal">
                                <i class="far fa-edit"></i> Register
                            </a>

                            <a href="" class="left-topbar-item" data-toggle="modal" data-target="#loginModal">
                                <i class="fas fa-sign-in-alt"></i> Log in
                            </a>
                </li>
                <li class="right-topbar text-center">
                    <a target="_blank" href="https://www.facebook.com/hoc.cung.vietjack">
                        <span class="fab fa-facebook-f"></span>
                    </a>
                    <a target="_blank" href="https://www.youtube.com/c/HọccùngVietJack/featured">
                        <span class="fab fa-youtube"></span>
                    </a>
                </li>
            </ul>
            <ul class="main-menu-m">
                <li>
                    <a href="{{route('home')}}">Home</a>
                </li>
                @if (count($menus['grades']) > 0)
                    <li>
                        <a href="">Thi Online</a>
                        <ul class="sub-menu-m" id="grade-menu-m">
                            @foreach($menus['grades'] as $grade)
                                <li><a href="#">{{ $grade['title'] }}</a></li>
                            @endforeach
                            <span class="arrow-main-menu-m">
                            <i class="fas fa-caret-right"></i>
                            </span>
                        </ul>
                    </li>
                @endif
                
                <li>
                    <a href="{{ route('question.index') }}">Thư Viện</a>
                </li>
            </ul>
        </div>
        <!--  -->
        <div class="wrap-logo container">
            <!-- Logo desktop -->
            <div class="logo">
                <a href=""><img src="{{url('images/logo.png')}}" alt="LOGO"></a>
            </div>
            <div class="form-search ml-auto form-search-desktop">
                <form class="form-inline" method="get">
                    <a href="javascript:void(0)" class="btn-search"><span class="fas fa-search"></span></a>
                    <input autocomplete="off" class="form-control mr-sm-2" type="text" placeholder="Bạn muốn tìm gì?" name="keyword" aria-label="Search" value="">
                    <span class="cancel"><i class="fas fa-window-close"></i></span>
                </form>
            </div>
        </div>
        <!--  -->
        <div class="wrap-main-nav">
            <div class="main-nav">
                <!-- Menu desktop -->
                <nav class="menu-desktop">
                    <a class="logo-stick" href="{{route('home')}}">
                        <img src="{{url('images/logo_white.png')}}" alt="LOGO">
                    </a>
                    <ul class="main-menu">
                        <li>
                            <a href="/"><i class="fas fa-home"></i></a>
                        </li>
                        @if (count($menus['grades']) > 0)
                        <li class="mega-menu-item">
                            <a href="">Thi Online</a>
                            @if (count($menus['grades']) > 0)
                                <div class="sub-mega-menu">
                                    <div class="nav flex-column nav-pills" role="tablist">
                                        @foreach($menus['grades'] as $grade)
                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="pill" href="#grade-{{ $grade['id'] }}" role="tab">{{ $grade['title'] }}</a>
                                        @endforeach
                                    </div>
                                    <div class="tab-content">
                                        @foreach($menus['grades'] as $grade)
                                            <div class="tab-pane show {{ $loop->first ? 'active' : '' }}" id="grade-{{ $grade['id'] }}" role="tabpanel">
                                                <div class="row">
                                                    @foreach($menus['subjects'][$grade['id']] as $subject)
                                                        <div class="col-3">
                                                            <div class="p-t-10">
                                                                <h5 class="p-b-5">
                                                                    <a href="{{ route('exam-by-grade-subject', [$grade['slug'], $subject['slug']]) }}" class="f1-s-5 cl3 hov-cl10 trans-03">
                                                                        @if (!empty($subject['icon']))
                                                                            <i class="{{ $subject['icon'] }} fs-13 m-r-5"></i>
                                                                        @endif
                                                                        {{ $subject['title'] }}
                                                                    </a>
                                                                </h5>
                                                                <span class="cl8">
                                                                    <a href="#" class="f1-s-6 cl8 hov-cl10 trans-03">
                                                                        {{ $subject['exam_count'] }} đề
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <ul class="sub-menu">
                                    @foreach($menus['grades'] as $grade)
                                        <li><a href="{{ route('exam-by-grade', $grade['slug']) }}">{{ $grade['title'] }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                        @endif
                        <li>
                            <a href="{{ route('question.index') }}">Thư Viện</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
