<div class="sidebar-left">
    <ul class="nav  in" id="side-menu">
        <li class="nav-item "> <a href="{{ route('admin.dashboard') }}" class="menudropdown nav-link {{ active_link('admin.dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="nav-item"> <a href="javascript:void(0)" class="menudropdown nav-link {{ active_link([
            config('app.prefix_admin_url') . '/grades',
            config('app.prefix_admin_url') . '/grades/*',
            config('app.prefix_admin_url') . '/subjects',
            config('app.prefix_admin_url') . '/subjects/*',
            config('app.prefix_admin_url') . '/chapters',
            config('app.prefix_admin_url') . '/chapters/*',
            config('app.prefix_admin_url') . '/lessons',
            config('app.prefix_admin_url') . '/lessons/*',
            config('app.prefix_admin_url') . '/users',
            config('app.prefix_admin_url') . '/users/*',
        ]) }}">Quản lý chung<i class="fa fa-angle-down "></i></a>
            <ul class="nav flex-column nav-second-level">
                @can('edit', App\Models\Grade::class)
                    <li class="in nav-item"><a href="{{ route('admin.grades.index') }}" class="nav-link ">Lớp học</a></li>
                @endcan
                @can('edit', App\Models\Subject::class)
                    <li class="in nav-item"><a href="{{ route('admin.subjects.index') }}" class="nav-link ">Môn học</a></li>
                @endcan
                <li class="in nav-item"><a href="{{ route('admin.chapters.index') }}" class="nav-link ">Chương</a></li>
                <li class="in nav-item"><a href="{{ route('admin.lessons.index') }}" class="nav-link ">Bài học</a></li>
                @can('view', App\Models\User::class)
                    <li class="in nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link ">Người dùng</a></li>
                @endcan
            </ul>
            <!-- /.nav-second-level -->
        </li>
        <li class="nav-item"> <a href="javascript:void(0)" class="menudropdown nav-link {{ active_link([
            config('app.prefix_admin_url') . '/courses',
            config('app.prefix_admin_url') . '/courses/*',
        ]) }}">Quản trị bộ đề thi <i class="fa fa-angle-down "></i></a>
            <ul class="nav flex-column nav-second-level">
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.courses.index') }}">Danh sách đề thi</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.courses.create') }}">Thêm đề mới</a></li>
            </ul>
            <!-- /.nav-second-level -->
        </li>
        @can('question-statistics')
        <li class="nav-item"> <a href="javascript:void(0)" class="menudropdown nav-link">Thống kê <i class="fa fa-angle-down "></i></a>
            <ul class="nav flex-column nav-second-level">
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.statistics')}}">Thống kê câu hỏi</a></li>
            </ul>
            <!-- /.nav-second-level -->
        </li>
        @endcan
        <li class="nav-item"> <a href="javascript:void(0)" class="menudropdown nav-link">Settings <i class="fa fa-angle-down "></i></a>
            <ul class="nav flex-column nav-second-level">
                <li class="nav-item"><a class="nav-link" href="">Page setting</a></li>
            </ul>
            <!-- /.nav-second-level -->
        </li>
    </ul>
</div>
