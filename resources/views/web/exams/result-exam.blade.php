@php
    $title = 'Kết quả thi thử ' . $curriculum->title;
    $description = 'Dịch vụ thi thử online miễn phí số 1 dành cho học sinh THPT, THCS.';
@endphp

@section('seo_title', $title)
@section('seo_description', $description)
@section('og_title', $title)
@section('og_description', $description)
@section('og_type', 'object')

<x-web-layout>
    <div class="box-wrapper">
        <div class="container">
            <div class="headline bg0 flex-wr-sb-c m-tb-10">
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
                    <a href="{{ route('exam.show', [$course->slug, $curriculum->id]) }}" class="breadcrumb-item f1-s-3 active">
                        {{ $curriculum->title }}
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="test-result">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="jumbotron text-center">
                                    <h3 class="cl0 p-b-12 text-uppercase">
                                        Điểm số của bạn
                                    </h3>
                                    <p style="height: 70px; font-size: 70px;">{{ $test->testDetails->where('status', App\Models\TestDetail::CORRECT)->count() }}/{{ $curriculum->questions->count() }}</p>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div>
                                    <h2 class="name-exam f1-l-3 cl2 p-tb-10 respon2">
                                        {{ $curriculum->title }}
                                    </h2>
                                    <ul class="exam-infor">
                                        <li>
                                            <p><i class="far fa-calendar-check"></i> {{ $course->view }} lượt thi</p>
                                        </li>
                                        <li>
                                            <p><i class="far fa-question-circle"></i> {{ $curriculum->questions->count() }} câu hỏi</p>
                                        </li>
                                        <li>
                                            <p><i class="far fa-clock"></i> {{ $curriculum->time }} phút</p>
                                        </li>
                                    </ul>
                                    <a href="#" class="size-h-2 f1-m-1 cl8 hov-btn2 trans-03">
                                        ({{ $course->title }})
                                    </a>
                                    <div class="row m-t-10">
                                        <div class="col-md-6">
                                            <a href="{{ route('exam.start', [$curriculum->id, $curriculum->slug]) }}" class="btn-action">Thi lại <i class="fas fa-undo-alt"></i></a>
                                        </div>
                                        @if ($nextCurriculum)
                                            <div class="col-md-6">
                                                <a href="" class="btn-action">Bài tiếp theo <i class="fas fa-forward"></i></a>
                                            </div>
                                            <div class="col-md-12">
                                                <a href="#" class="size-h-2 f1-m-1 cl5 hov-btn2 trans-03">
                                                    <span class="cl8">Bài thi tiếp theo: </span>{{ $nextCurriculum->title }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-20">
                                @if (Agent::isMobile())
                                    <h3 class="f1-m-1 cl3 p-b-12 text-uppercase">
                                        Lịch sử làm bài
                                    </h3>
                                    <div class="number-container">
                                        @foreach($curriculum->questions as $key => $question)
                                            @php
                                                $testDetail = $test->testDetails->firstWhere('question_id', $question->id);
                                                $className = '';

                                                if ($testDetail) {
                                                    $className = $testDetail->status ==  App\Models\TestDetail::CORRECT ? 'true' : 'false';
                                                }
                                            @endphp

                                            <div class="number-item {{ $className }}" data-toggle="scroll" data-target="#question_{{ $question->id }}"><span>{{ ++$key }}</span></div>
                                        @endforeach
                                    </div>
                                @endif
                                <hr>
                                <div class="test-result-detail">
                                    @foreach($curriculum->questions as $key => $question)
                                        @php
                                            $testDetail = $test->testDetails->firstWhere('question_id', $question->id);
                                            $className = '';
                                            $txt = '';

                                            if ($testDetail) {
                                                if ($testDetail->status ==  App\Models\TestDetail::CORRECT) {
                                                    $className = 'true';
                                                    $txt = 'Chúc mừng! Bạn đã chọn đúng';
                                                } else {
                                                    $className = 'false';
                                                    $txt = 'Tiếc quá! Bạn đã chọn sai đáp án.';
                                                }
                                            } else {
                                                $txt = 'Bạn Chưa Chọn Câu Trả Lời';
                                            }

                                            if ($question->answers->count() == 0) {
                                                $txt = 'Câu Hỏi Tự Luận';
                                            }
                                        @endphp
                                        <div class="quiz-answer-item" id="question_{{ $question->id }}">
                                            <div class="question-header">
                                                <p class="number-question">Câu {{ ++$key }}: <span class="{{ $className }}">{{ $txt }}</span></p>
                                            </div>
                                            <div class="question-name">
                                                {!! $question->content !!}
                                            </div>
                                            <div class="question-answer-list row">
                                                @foreach($question->answers as $key => $answer)
                                                    <div class="answer-item col-12 d-flex {{ $answer->answer == App\Models\Answer::RIGHT ? 'correct' : '' }} {{ $testDetail && $testDetail->choose_answer_index == $key ? $className : '' }}">
                                                        {!! $answer->content !!}
                                                    </div>
                                                @endforeach
                                                <div class="col-12">
                                                    <h3 class="f1-s-10 cl3 p-tb-12 text-uppercase" style="color: #ff9700;">
                                                        Giải thích
                                                    </h3>
                                                    <div class="question-reason">
                                                        {!! $question->reason !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @if (!Agent::isMobile())
                        <h3 class="f1-m-1 cl3 p-b-12 text-uppercase">
                            Lịch sử làm bài
                        </h3>
                        <div class="number-container">
                            @foreach($curriculum->questions as $key => $question)
                                @php
                                    $testDetail = $test->testDetails->firstWhere('question_id', $question->id);
                                    $className = '';

                                    if ($testDetail) {
                                        $className = $testDetail->status ==  App\Models\TestDetail::CORRECT ? 'true' : 'false';
                                    }
                                @endphp

                                <div class="number-item {{ $className }}" data-toggle="scroll" data-target="#question_{{ $question->id }}"><span>{{ ++$key }}</span></div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
