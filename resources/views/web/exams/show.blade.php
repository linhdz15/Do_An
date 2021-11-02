@php
    $title = $curriculum->questions_count . ' câu hỏi trắc nghiệm thuộc ' . $curriculum->title;
    $description = 'Đề thi kiểm tra ' . ($course->subject->title ?? ' ') . ' - ' . ($course->grade->title ?? ' ') . ' - ' . $title;
@endphp

@section('seo_title', $title)
@section('seo_description', $description)
@section('og_title', $title)
@section('og_description', $description)
@section('og_type', 'object')

@extends('layouts.exam')
@section('content')
<div class="box-wrapper container-fluid">
    <div class="content-wrapper {{ $chapters->count() > 0 ? '' : 'unsidebar'}}">
        @if ($chapters->count() > 0)
            @include('web.exams.partials.sidebar')

            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn btn-content-table">
                <i class="fas fa-list-ul"></i>
                <span>Mục lục</span>
            </button>
        @endif
        <div id="main-content" class="exam-preview">
            <div class="content-header bg-white">
                <div class="container">
                    <div class="headline bg0 flex-wr-sb-c p-t-10">
                        <div class="f2-s-1 p-r-30 m-tb-6">
                            <a href="{{ route('home') }}" class="breadcrumb-item f1-s-3 cl-900">
                                Trang chủ 
                            </a>
                            @if ($course->grade)
                                <a href="{{ route('exam-by-grade', $course->grade->slug) }}" class="breadcrumb-item f1-s-3 cl-900">
                                    {{ $course->grade->title }} 
                                </a>

                                @if ($course->subject)
                                    <a href="{{ route('exam-by-grade-subject', [
                                        $course->grade->slug,
                                        $course->subject->slug
                                    ]) }}" class="breadcrumb-item f1-s-3 cl-900">
                                        {{ $course->subject->title }} 
                                    </a>
                                @endif
                            @endif
                            <span class="breadcrumb-item f1-s-3 active">
                                {{ $course->title }}
                            </span>
                        </div>
                    </div>
                    <h2 class="name-exam f1-l-3 cl2 p-b-20 p-t-10 respon2">
                        <span>Thi Online {{ $course->title }}</span>
                    </h2>
                </div>
                <div class="bt-1 bb-1">
                    <div class="container">
                        <ul class="tab-exam">
                            @php
                                $examNumber = 0;
                            @endphp

                            @foreach($course->examCurriculums as $exam)
                                @php
                                    $examNumber++;
                                @endphp

                                <li class="{{ $curriculum->id ==  $exam->id ? 'active' : '' }}">
                                    <a title="{{ $exam->title }}" href="{{ route('exam.show', [$course->slug, $exam->id]) }}">Đề số {{ $examNumber }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="f1-l-4 cl3 p-tb-12 name-sub-exam">
                                {{ $curriculum->title }}
                            </h4>
                            <ul class="exam-infor">
                                <li>
                                    <p><i class="far fa-calendar-check"></i> {{ $course->view }} lượt thi</p>
                                </li>
                                <li>
                                    <p><i class="far fa-question-circle"></i> {{ $curriculum->questions_count }} câu hỏi</p>
                                </li>
                                <li>
                                    <p><i class="far fa-clock"></i> {{ $curriculum->time }} phút</p>
                                </li>
                                @if (Auth::check() && Auth::user()->canBeAdministrators())
                                    <li>
                                        <p><i class="far fa-calendar-alt"></i> {{ $curriculum->created_at }}</p>
                                    </li>
                                @endif
                            </ul>
                            <div class="p-tb-12">
                                @if (auth()->check())
                                    <a href="{{ route('exam.start', [$curriculum->id, $curriculum->slug]) }}" class="start_exam">
                                @else
                                    <a href="javascript:;" class="start_exam" data-toggle="modal" data-target="#loginModal">
                                @endif
                                    <i class="fas fa-stopwatch"></i> BẮT ĐẦU LÀM BÀI
                                </a>
                            </div>
                            <div>
                                <h3 class="f1-m-14 cl3 p-t-5 text-uppercase">
                                    Danh sách câu hỏi
                                </h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="qas" style="{{ !Agent::isMobile() ? 'max-height: initial;' : '' }}">
                                            @if ($curriculum && $curriculum->questions->count() > 0)
                                                <div class="p-t-12">
                                                    @foreach($curriculum->questions as $key => $question)
                                                        <div class="quiz-answer-item">
                                                            <a href="{{ route('question.show', [
                                                                $question->id,
                                                                $question->slug
                                                            ]) }}" class="question">
                                                                <p class="number-question">Câu {{ $key + 1 }}:</p>
                                                                <div class="title-question overflow-x-el p-t-12">{!! $question->content !!}</div>
                                                            </a>
                                                            <div class="answers" style="margin-top: -10px;">
                                                                @foreach($question->answers as $answer)
                                                                    @if (auth()->check())
                                                                        <div class="answer-check radio" onclick="window.location.href = '{{ route('question.show', [
                                                                                $question->id,
                                                                                $question->slug
                                                                            ]) }}'">
                                                                    @else
                                                                        <div class="answer-check radio" data-toggle="modal" data-target="#exam-modal_notice" >
                                                                    @endif
                                                                        <label>
                                                                            <span class="cr"></span>
                                                                            {!! $answer->content !!}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="m-t-20">
                                                                <a data-toggle="collapse" data-target="#reason_{{ $question->id }}" class="enterExam">
                                                                    <img class="smilling-white" width="18px" src="{{ asset('images/smiling.svg') }}"> Xem đáp án
                                                                </a>
                                                                <div id="reason_{{ $question->id }}" class="collapse reason p-t-17">
                                                                    {!! $question->reason !!}
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="p-tb-10">Đang cập nhật ...</p>
                                            @endif
                                            
                                            @if (auth()->check())
                                                <a href="{{ route('exam.start', [$curriculum->id, $curriculum->slug]) }}" class="view-more-exam">
                                            @else
                                                <a href="javascript:;" class="view-more-exam" data-toggle="modal" data-target="#loginModal">
                                            @endif
                                                <i class="far fa-hand-point-right"></i> Bắt đầu thi ngay
                                            </a>
                                            <br><br>
                                        </div>
                                        @if (Agent::isMobile())
                                            <p class="show-more">
                                                <a href="javascript:;" class="readmore">Xem thêm</a>
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <div class="quiz-answer-item" style="padding: 15px; margin-bottom: 20px;">
                                            @php
                                                $otherCurriculum = $course->examCurriculums->where('id', '<>', $curriculum->id)->take(10);
                                            @endphp

                                            @if ($otherCurriculum->count() > 0)
                                                <h3 class="f1-m-14 cl3 p-b-10 text-uppercase">
                                                    Bài thi liên quan
                                                </h3>
                                                <ul class="exam-related">
                                                    @foreach($otherCurriculum as $curriculum)
                                                        <li>
                                                            <a href="{{ route('exam.show', [$course->slug, $curriculum->id]) }}" title="{{ $curriculum->title }}">
                                                                <i class="far fa-check-circle" style="color: #00b41e;"></i> {{ $curriculum->title }}
                                                            </a>
                                                            <ul class="exam-infor">
                                                                <li>
                                                                    <p><i class="far fa-question-circle"></i> {{ $curriculum->questions_count }} câu hỏi</p>
                                                                </li>
                                                                <li>
                                                                    <p><i class="far fa-clock"></i> {{ $curriculum->time }} phút</p>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                            @php
                                                $chapterCur = $chapters->where('id', $course->chapter_id)->first();
                                            @endphp

                                            @if ($chapterCur)
                                                @php
                                                    $allCourses =  $chapterCur->lessons
                                                        ->pluck('courses')
                                                        ->flatten();
                                                @endphp

                                                @if ($allCourses->where('lesson_id', $course->lesson_id)->count() > 0)
                                                    <hr>
                                                    <h3 class="f1-m-14 cl3 p-b-10 text-uppercase">
                                                        Có thể bạn quan tâm
                                                    </h3>
                                                    <ul class="exam-related">
                                                        @foreach ($allCourses->where('lesson_id', $course->lesson_id)->where('id', '<>', $course->id)->take(10) as $otherCourse)
                                                            <li>
                                                                <a href="{{ route('exam.show', $otherCourse->slug) }}" title="{{ $otherCourse->title }}">
                                                                    <i class="far fa-hand-point-right" style="color: red;"></i> {{ $otherCourse->title }}
                                                                </a>
                                                                <span class="view-counter">({{ $otherCourse->view }} lượt thi)</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif

                                                @if ($allCourses->where('lesson_id', '<>', $course->lesson_id)->count() > 0)
                                                    <hr>
                                                    <h3 class="f1-m-14 cl3 p-b-10 text-uppercase">
                                                        Các bài thi hot trong chương
                                                    </h3>
                                                    <ul class="exam-related">
                                                        @foreach ($allCourses->where('lesson_id', '<>', $course->lesson_id)->sortByDesc('view')->take(10) as $otherCourse)
                                                            <li>
                                                                <a href="{{ route('exam.show', $otherCourse->slug) }}" title="{{ $otherCourse->title }}">
                                                                    <i class="far fa-calendar-check" style="color: #900;"></i> {{ $otherCourse->title }}
                                                                </a>
                                                                <span class="view-counter">({{ $otherCourse->view }} lượt thi)</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar-overlay"></div>
</div>
@endsection
