@extends('layouts.web-simple')

@php
    $title = $curriculum->title;
    $description = 'Hệ thống sẽ giúp bạn xác định chính xác kiến thức bị hổng để tập trung đào sâu, từ cơ bản đến nâng cao, có hướng dẫn giải chi tiết bao gồm tất các môn Toán, Ngữ văn, Tiếng anh, Vật lý, Hóa học, Sinh học, Lịch sử, Địa lý, Giáo dục công dân...';
@endphp

@section('seo_title', $title)
@section('seo_description', $description)
@section('og_title', $title)
@section('og_description', $description)
@section('og_type', 'object')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/web/start-exam.css') }}" type="text/css">
@endpush

@push('scripts')
    <script src="{{ mix('js/web/start-exam.js') }}" type="text/javascript"></script>
@endpush


@section('content')
    <main id="app">
        <div class="wrapper">
            @if ($exams->count() > 0)
                <!-- Sidebar  -->
                <nav id="sidebar-wrapper">
                    <div class="sidebar-header">
                        <h3 class="f1-m-1 text-uppercase">
                            Danh sách đề thi
                        </a>
                    </div>

                    <ul class="list-unstyled components">
                        @foreach($exams as $exam)
                            <li class="{{ $exam->id == $curriculum->id ? 'active' : '' }}">
                                <a class="leave-site" href="{{ route('exam.start', [$exam->id, $exam->slug]) }}">{{ $exam->title }}</a>
                            </li>
                        @endforeach
                    </ul>

                    <ul class="list-unstyled action-more">
                        <li>
                            <a href="{{ route('home') }}" class="download leave-site"><i class="fas fa-home"></i></a>
                        </li>
                        <li>
                            <a href="{{ route('exam.show', [$curriculum->course->slug, $curriculum->id]) }}" class="article leave-site">Back</a>
                        </li>
                    </ul>
                </nav>
            @endif

            <!-- Page Content  -->
            <div id="content">
                <nav class="navbar navbar-fixed fixed-top" style="padding: 0;">
                    <div style="width: 100%; display: flex; padding: 7px 10px; background-image: linear-gradient(90deg, #ff9700, #ed7237, #ff950c); color: #fff; align-items: center;">
                        <div class="" style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                            <button type="button" id="sidebarCollapse" class="btn btn-link text-white">
                                <i class="fas fa-align-left"></i>
                            </button>
                            <span class="timer-clock"><i class="far fa-clock"></i> <span id="timer">00:00:00</span></span>
                            <a class="submit-test" id="submit-test" data-action="{{ route('test.submit', $test) }}">
                                <i class="far fa-paper-plane"></i>
                                <span>NỘP BÀI</span>
                            </a>
                            <a class="leave-site exit-exam" href="{{ route('exam.show', [$curriculum->course->slug, $curriculum->id]) }}">
                                <i class="fa fa-sign-out-alt"></i>
                                <span>Thoát</span>
                            </a>
                        </div>
                    </div>
                    <div class="scroll-slider scroll-off">
                        <span class="scroll-overlay"><i class="fas fa-caret-left float-left"></i></span>
                        <span class="scroll-overlay"><i class="fas fa-caret-right float-right"></i></span>
                        <div class="scroll-on">
                          <ul>
                            @foreach ($curriculum->questions as $key => $question)
                                <li class="number-question" number-question="{{$key + 1}}" question-id="{{ $question->id }}" total-number="{{ $curriculum->questions->count() }}">{{ $key + 1 }}</li>
                            @endforeach
                          </ul>
                        </div>
                    </div>
                </nav>

                <nav class="navbar navbar-fixed fixed-bottom">
                    <button type="button" class="btn btn-danger mx-auto" id="previous-question">Câu trước</button>
                    <button
                        type="button"
                        class="btn btn-primary mx-auto d-none"
                        id="submit-question"
                        data-action="{{ route('test.sendanswer', $test) }}"
                    >Trả lời</button>
                    <button type="button" class="btn btn-info mx-auto" id="next-question">Câu tiếp theo</button>
                </nav>

                <div class="content-body">
                    <div class="quiz-wrapper bg-white rounded">
                        @foreach ($curriculum->questions as $key => $question)
                            <div class="quiz quiz-content d-none" quiz-index="{{ $key + 1 }}" quiz-id="{{ $question->id }}">
                                <input value="{{ $question->id }}" class="d-none" name="question_id" />
                                <p class="text-label">Câu {{ $key + 1 }}</p>
                                <div class="question-title">
                                    {!! $question->content !!}
                                </div>
                                {{-- <h4 class="m-t-15 text-justify h5 font-weight-bold overflow-x-el"></h4> --}}
                                <div class="options py-3">
                                    @forelse($question->answers as $index => $anwser)
                                        <div class="rounded option m-b-10">
                                            <input class="anwser" id="anwser_{{ $anwser->id }}" type="radio" name="anwser_id" value="{{ $index }}" />
                                            <label for="anwser_{{ $anwser->id }}">
                                                {!! $anwser->content !!}
                                            </label>
                                        </div>
                                    @empty
                                        <button type="button" class="btn btn-info btn-sm show-anwser">Xem đáp án</button>
                                    @endforelse
                                </div>
                                <div class="reason js-reason-{{ $question->id }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
