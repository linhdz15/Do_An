@include('layouts.partials.notices')

@php ($isNew = !$course->exists)

{{ Form::open([
    'url' => $action,
    'method' => $isNew ? 'POST' : 'PUT',
    'enctype' => 'multipart/form-data',
    'class' => 'form-course',
    'autocomplete' => 'off',
]) }}
<div class="row">
    <div class="col-md-16">
        <div class="form-group required {{ has_error('title', $errors) }}">
            {{ Form::label('title', 'Tiêu đề') }}
            {{ Form::text('title', $course->title, ['id' => 'title-input', 'class' => 'form-control bg-white', 'required' => true, 'autofocus' => true, 'placeholder' => 'Tiêu đề']) }}
            <div class="form-control-feedback">{{ $errors->first('title') }}</div>
        </div>

        <div class="form-group required {{ has_error('slug', $errors) }}">
            {{ Form::label('slug', 'Slug (tối đa 100 ký tự)') }}
            {{ Form::text('slug', $course->slug, ['id' => 'slug-input', 'class' => 'form-control bg-white', 'required' => true, 'autofocus' => true, 'placeholder' => 'Slug', 'maxlength' => 100]) }}
            <div class="form-control-feedback">{{ $errors->first('slug') }}</div>
        </div>

        <div class="form-group {{ has_error('seo_title', $errors) }}">
            {!! Form::label('seo_title', 'SEO title') !!}
            {{ Form::text('seo_title', $course->seo_title, ['id' => 'seo_title-input', 'class' => 'form-control bg-white', 'placeholder' => 'SEO title']) }}
            <div class="form-control-feedback">{{ $errors->first('seo_title') }}</div>
        </div>

        <div class="form-group {{ has_error('seo_description', $errors) }}">
            {!! Form::label('seo_description', 'SEO description') !!}
            {!! Form::textarea('seo_description', $course->seo_description, [
                'class' => 'form-control bg-white',
                'placeholder' => 'SEO description',
                'rows' => 3
            ]) !!}
            <div class="form-control-feedback">{{ $errors->first('seo_description') }}</div>
        </div>

        <div class="form-group {{ has_error('seo_keywords', $errors) }}">
            {!! Form::label('seo_keywords', 'SEO keywords') !!}
            {{ Form::text('seo_keywords', $course->seo_keywords, ['class' => 'form-control bg-white', 'placeholder' => 'SEO keywords']) }}
            <div class="form-control-feedback">{{ $errors->first('seo_keywords') }}</div>
        </div>

        <div class="form-group {{ has_error('description', $errors) }}">
            {!! Form::label('description', 'Nội dung') !!}
            {!! Form::textarea('description', $course->description, [
                'class' => 'form-control editor-input',
                'placeholder' => 'Nội dung',
                'rows' => 3
            ]) !!}
            <div class="form-control-feedback">{{ $errors->first('description') }}</div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group required {{ has_error('grade_id', $errors) }}">
                    {!! Form::label('grade_id', 'Lớp') !!}
                    {{ Form::select('grade_id', [], null, [
                        'class' => 'form-control js-select2-ajax',
                        'id' => 'grades',
                        'data-placeholder' => 'Chọn lớp',
                        'data-ajax-url' => route('suggest.grades'),
                        'data-ajax-selected-values' => $course->grade_id,
                    ]) }}
                    <div class="form-control-feedback">{{ $errors->first('grade_id') }}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group required {{ has_error('subject_id', $errors) }}">
                    {!! Form::label('subject_id', 'Môn') !!}
                    {{ Form::select('subject_id', [], null, [
                        'class' => 'form-control js-select2-ajax',
                        'id' => 'subjects',
                        'data-placeholder' => 'Chọn môn',
                        'data-ajax-url' => route('suggest.subjects', ['all' => true]),
                        'data-ajax-selected-values' => $course->subject_id,
                    ]) }}
                    <div class="form-control-feedback">{{ $errors->first('subject_id') }}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group {{ has_error('chapter_id', $errors) }}">
                    {!! Form::label('chapter_id', 'Chương') !!}
                    {{ Form::select('chapter_id', [], null, [
                        'class' => 'form-control js-select2-ajax',
                        'id' => 'chapters',
                        'data-placeholder' => 'Chọn chương',
                        'data-ajax-url' => route('suggest.chapters'),
                        'data-ajax-selected-values' => $course->chapter_id,
                    ]) }}
                    <div class="form-control-feedback">{{ $errors->first('chapter_id') }}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group {{ has_error('lesson_id', $errors) }}">
                    {!! Form::label('lesson_id', 'Bài') !!}
                    {{ Form::select('lesson_id', [], null, [
                        'class' => 'form-control js-select2-ajax',
                        'id' => 'lessons',
                        'data-placeholder' => 'Chọn bài',
                        'data-ajax-url' => route('suggest.lessons'),
                        'data-ajax-selected-values' => $course->lesson_id,
                    ]) }}
                    <div class="form-control-feedback">{{ $errors->first('lesson_id') }}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group {{ has_error('editor_id', $errors) }}">
                    {!! Form::label('editor_id', 'Người nhập liệu') !!}
                    {{ Form::select('editor_id', [], null, [
                        'class' => 'form-control js-select2-ajax',
                        'id' => 'users',
                        'data-placeholder' => 'Chọn nhập liệu',
                        'data-ajax-url' => route('suggest.users', ['role' => App\Models\User::EDITOR]),
                        'data-ajax-selected-values' => $course->editor_id,
                    ]) }}
                    <div class="form-control-feedback">{{ $errors->first('editor_id') }}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group required {{ has_error('index', $errors) }}">
                    {{ Form::label('index', 'Thứ tự hiển thị') }}
                    {{ Form::text('index', $course->index ?? 0, ['class' => 'form-control bg-white', 'autofocus' => true, 'placeholder' => 'Thứ tự hiển thị',]) }}
                    <div class="form-control-feedback">{{ $errors->first('index') }}</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group {{ has_error('status', $errors) }}">
                    <label>Trạng thái</label>
                    <div>
                        {{ Form::checkbox('status', App\Models\Course::ACTIVE, ($course->status && $course->status == App\Models\Course::ACTIVE)) }}
                        {!! Form::label('status', 'Duyệt đề thi') !!}
                    </div>
                    <div class="form-control-feedback">{{ $errors->first('status') }}</div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <img id="image_preview" src="{{ $course->banner ? uploaded_image_url($course->banner) : asset('images/banner_default.jpg') }}" alt="Ảnh Baner" class="img-fluid">
            </div>
            <div class="col-md-4">
                <div class="form-group {{ has_error('banner', $errors) }}">
                    {!! Form::label('banner', 'Ảnh Baner') !!} <br>
                    <div>
                        <label class="custom-file mb-2">
                            <input type="file" id="image_file" class="custom-file-input" name="banner">
                            <span class="custom-file-control"></span>
                        </label>
                        <p id="image-message"></p>
                    </div>
                    <div class="form-control-feedback">{{ $errors->first('banner') }}</div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <div class="col-md-16 mt-3">
        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                {{ $isNew ? 'Tạo mới' : 'Cập nhật' }}
            </button>
            <a class="btn btn-danger pull-right" href="{{route('admin.courses.index')}}">Hủy</a>
        </div>
    </div>
</div>
{{ Form::close() }}
