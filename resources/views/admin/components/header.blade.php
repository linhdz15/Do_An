<!-- Page Loader Ends -->
<header class="navbar-fixed">
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-faded">
        <div class="sidebar-left"> <a class="navbar-brand imglogo" href="{{ route('admin.dashboard') }}"></a>
            <button class="btn btn-link icon-header mr-sm-2 pull-right menu-collapse"><span class="fa fa-bars"></span></button>
        </div>
        <form class="form-inline mr-sm-2  pull-left search-header hidden-md-down">
            <input class="form-control " type="text" placeholder="Search" id="search_header">
            <button class="btn btn-link icon-header " type="submit"><span class="fa fa-search"></span></button>
        </form>
        <div class="d-flex mr-auto"> &nbsp;</div>
        <ul class="navbar-nav content-right">
            <li class="align-self-center hidden-md-down"> <a href="/" class="btn btn-sm btn-primary mr-2" target="_blank"><span class="fa fa-home"></span> Trang chủ</a> </li>
            <li class="v-devider"></li>
        </ul>
        <div class="sidebar-right pull-right ">
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item">
                    <button class="btn-link btn userprofile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="userpic">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                            @endif
                        </span>
                        <span class="text">{{ Auth::user()->name }}</span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('profile.show') }}">{{ __('Profile') }}</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">{{ __('Setting') }}</a>
                    </div>
                </li>
                <li>
                    <form method="POST" action="{{ route('custom.logout') }}">
                        @csrf
                        <a href="{{ route('custom.logout') }}" class="btn btn-link icon-header" onclick="event.preventDefault();
                            this.closest('form').submit();"><span class="fa fa-sign-out"></span></a>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>
