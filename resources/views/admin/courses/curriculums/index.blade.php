<x-admin-layout>
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-11 col-sm-12 page-title">
                <h3><i class="fa fa-sitemap "></i> Đề thi</h3>
                <p>Cập nhật đề thi</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                @include('admin.courses.partials.sidebar')
            </div>
            <div class="col-sm-13">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Chương trình học</h5>
                    </div>
                    <div class="card-body">
                        <div id="curriculums" data-courseid="{{ $course->id }}" data-userid="{{ Auth::id() }}" data-hasrole="{{ Auth::user()->canBeAdministrators() }}" data-isadmin="{{ Auth::user()->isAdmin() }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
