<div class="card">
    <div class="card-header">
        <h5 class="card-title">Cập nhật</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="sidebar-course-nav">
            <ul class="nav flex-column" id="side-menu">
                <li class="nav-item {{ active_link(config('app.prefix_admin_url') . '/courses/*/edit') }}">
                    <a class="nav-link" href="{{ route('admin.courses.edit', $course) }}">
                        Trang hiển thị
                    </a>
                </li>
                <li class="nav-item {{ active_link(config('app.prefix_admin_url') . '*/curriculums') }}">
                    <a class="nav-link" href="{{ route('admin.curriculums.index', $course) }}">
                        Chương trình học
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.courses.index') }}">
                        Back
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
