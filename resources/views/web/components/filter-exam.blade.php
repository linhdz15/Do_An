<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="bg0 filter-exam m-tb-20">
                <div class="filter-box">
                    {{ Form::open([
                        'url' => route('search'),
                        'method' => 'GET',
                        'class' => 'js-filter-exam',
                    ]) }}
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::select(
                                                'grade',
                                                !empty($grade) ? [$grade->slug => $grade->title]  : [],
                                                $grade->slug ?? null,
                                                [
                                                    'class' => 'form-control select2',
                                                    'id' => 'grades',
                                                    'data-placeholder' => 'Chọn lớp',
                                                    'data-ajax-url' => route('suggest.grades'),
                                                ]
                                            ) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::select(
                                                'subject',
                                                !empty($subject) ? [$subject->slug => $subject->title]  : [],
                                                $subject->slug ?? null,
                                                [
                                                    'class' => 'form-control select2',
                                                    'id' => 'subjects',
                                                    'data-placeholder' => 'Chọn môn',
                                                    'data-ajax-url' => route('suggest.subjects'),
                                                ]
                                            ) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::select(
                                        'chapter',
                                        !empty($chapter) ? [$chapter->slug => $chapter->title]  : [],
                                        $chapter->slug ?? null,
                                        [
                                            'class' => 'form-control select2',
                                            'id' => 'chapters',
                                            'data-placeholder' => 'Chọn chương',
                                            'data-ajax-url' => route('suggest.chapters'),
                                        ]
                                    ) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::select(
                                        'lesson',
                                        !empty($lesson) ? [$lesson->slug => $lesson->title]  : [],
                                        $lesson->slug ?? null,
                                        [
                                            'class' => 'form-control select2',
                                            'id' => 'lessons',
                                            'data-placeholder' => 'Chọn bài',
                                            'data-ajax-url' => route('suggest.lessons'),
                                        ]
                                    ) }}
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group text-center">
                                        <button title="Tìm kiếm" type="submit" class="btn btn-info js-submit_filter" style="padding: 6px 7px; border-radius: 2px; outline: 0;"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
