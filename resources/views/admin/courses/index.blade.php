<x-admin-layout>
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-11 col-sm-12 page-title">
                <h3><i class="fa fa-sitemap "></i> Đề thi</h3>
                <p>Danh sách đề thi</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-16">
                <form method="get">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-4 col-md-4">
                                    <label>Tên</label>
                                    {{ Form::text('title', request('title'), ['class' => 'form-control bg-white']) }}
                                </div>
                                <div class="col-lg-4 col-md-4 mb-2">
                                    <label>Status</label>
                                    {{ Form::select('status', [
                                        null => 'Toàn bộ',
                                        App\Models\Course::ACTIVE => 'Đã Duyệt',
                                        App\Models\Course::DISABLE => 'Chưa duyệt',
                                    ], request('status'), [
                                        'class' => 'form-control bg-white',
                                    ]) }}
                                </div>
                                <div class="col-lg-4 col-md-4 mb-2">
                                    <label>Lớp</label>
                                    {{ Form::select('grade_id', [], null, [
                                        'class' => 'form-control js-select2-ajax',
                                        'id' => 'grades',
                                        'data-placeholder' => 'Chọn lớp',
                                        'data-ajax-url' => route('suggest.grades'),
                                        'data-ajax-selected-values' => request('grade_id'),
                                    ]) }}
                                </div>
                                <div class="col-lg-4 col-md-4 mb-2">
                                    <label>Môn học</label>
                                    {{ Form::select('subject_id', [], null, [
                                        'class' => 'form-control js-select2-ajax',
                                        'id' => 'subjects',
                                        'data-placeholder' => 'Chọn môn',
                                        'data-ajax-url' => route('suggest.subjects'),
                                        'data-ajax-selected-values' => request('subject_id'),
                                    ]) }}
                                </div>
                                <div class="col-lg-4 col-md-4 mb-2">
                                    <label>Chọn chương</label>
                                    {{ Form::select('chapter_id', [], null, [
                                        'class' => 'form-control js-select2-ajax',
                                        'id' => 'chapters',
                                        'data-placeholder' => 'Chọn chương',
                                        'data-ajax-url' => route('suggest.chapters'),
                                        'data-ajax-selected-values' => request('chapter_id'),
                                    ]) }}
                                </div>
                                <div class="col-lg-4 col-md-4 mb-2">
                                    <label>Chọn bài</label>
                                    {{ Form::select('lesson_id', [], null, [
                                        'class' => 'form-control js-select2-ajax',
                                        'id' => 'lessons',
                                        'data-placeholder' => 'Chọn bài',
                                        'data-ajax-url' => route('suggest.lessons'),
                                        'data-ajax-selected-values' => request('chapter_id'),
                                    ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <span class="btn btn-info"> <a style="color:#fff" href="{{ route('admin.courses.index') }}">Làm lại</a> </span>
                            <button type="submit" class="btn btn-success pull-right">Lọc</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-16">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Danh sách đề thi
                            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary pull-right">
                                <i class="fa fa-plus" aria-hidden="true"></i> Thêm đề thi mới
                            </a>
                        </h5>
                    </div>
                    <div class="card-body">
                        @include('layouts.partials.notices')

                        <div class="table-responsive" style="width: 100%; overflow-x: auto;">
                            <table class="table table-bordered" id="#">
                                <thead>
                                    <tr>
                                        <th width="100">Baner</th>
                                        <th width="300">Tên</th>
                                        <th width="250">Thông tin</th>
                                        <th width="120">Status</th>
                                        <th width="120"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('images/banner_default.jpg') }}" alt="{{ $course->name }}" width="100">
                                            </td>
                                            <td>
                                                <h6>
                                                    <a href="{{ route('exam.show', ['slug' => $course->slug]) }}" 
                                                        style="color: #fff; text-decoration: none;" target="_blank">{{ $course->title }}</a>
                                                </h6>
                                                <p><small>- Nhập liệu:</small> {{ $course->editor->email ?? '__' }}</p>
                                            </td>
                                            <td>
                                                <p><small>- Lớp:</small> {{ $course->grade->title ?? '__' }}</p>
                                                <p><small>- Môn:</small> {{ $course->subject->title ?? '__' }}</p>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input class="js-change-status" type="checkbox" {{ $course->status ? 'checked' : '' }} data-action={{ action('Admin\CourseController@changeStatus', $course) }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="center">
                                                @can('edit', $course)
                                                    <div class="d-flex">
                                                        <a href="{{ route('admin.curriculums.index', $course) }}" class="btn btn-link btn-sm" style="color: #fff">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        {{ Form::open([
                                                            'url' => route('admin.courses.destroy', $course),
                                                            'method' => 'DELETE',
                                                        ]) }}
                                                            <button class="btn btn-link btn-sm js-form-delete" data-message="{{ __('Are you sure to delete?') }}" style="color: #fff">
                                                                <i class="fa fa-trash-o "></i>
                                                            </button>
                                                        {{ Form::close() }}
                                                    </div>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="container">
                            <nav aria-label="..." class="align-self-center">
                                {{ $courses->appends($_GET)->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
