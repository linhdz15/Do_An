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
                        <h5 class="card-title">Hiển thị</h5>
                    </div>
                    <div class="card-body">
                        @include('admin.courses.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
