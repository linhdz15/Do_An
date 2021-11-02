<x-admin-layout>
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-11 col-sm-12 page-title">
                <h3><i class="fa fa-sitemap "></i> Đề thi</h3>
                <p>Tạo đề thi mới</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-16">
                <div class="card">
                    <div class="card-body">
                        @include('admin.courses.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
