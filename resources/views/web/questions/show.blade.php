@php
    $description = html_clean($question->content);
    $title = '[' . date('Y') . '] ' . ($question->title ?? str_limit($description, 150)) . '...';
@endphp

@section('seo_title', $title)
@section('not_name', true)
@section('seo_description', $description)
@section('og_title', $title)
@section('og_description', $description)
@section('og_type', 'article')

<x-web-layout>
    <div class="box-wrapper page-question">
        <div class="container">
            <div class="row main-qa">
                <div class="right-qa col-sm-12 col-md-7 col-lg-8 p-b-10">
                    <div class="bg-white br-5">
                        <div class="title-qa">
                            <div class="headline bg0 flex-wr-sb-c">
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

                            <h3 class="title-des">Câu hỏi:</h3>
                            <span class="question-info float-right">
                                <span><i class="fas fa-clock"></i> {{ date('d/m/Y', strtotime($question->created_at)) }}</span>
                                <span><i class="fas fa-eye"></i> {{ number_format($question->view) }}</span>
                                @if (Auth::check() && Auth::user()->canBeAdministrators())
                                    <span class="edit-qa">
                                        <a href="" target="_blank">Sửa nội dung</a>
                                    </span>
                                @endif
                            </span>

                            <h4 class="title-question overflow-x-el m-tb-20">{!! $question->content !!}</h4>

                            @if ($question->answers->count() > 0)
                                <div class="answers">
                                    @foreach($question->answers as $answer)
                                        <div class="answer-check radio">
                                            <label style="cursor: text;">
                                                {!! nl2br($answer->content) !!}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="title-exam">
                            <b style="font-size: 16px;">Câu hỏi trong đề:&nbsp;&nbsp;</b>
                            <a class="link-title_qa has-underline" href="{{ route('exam.show', [$course->slug, $curriculum->id]) }}">
                                {{ $course->title }}
                            </a>
                        </div>
                    </div>

                    <div class="bg-white border-simple m-t-10">
                        <div class="text-center">
                            <a class="tart_test btn-block" href="{{ route('exam.start', [$curriculum->id, $curriculum->slug]) }}">
                                <i class="fas fa-hand-point-right"></i>
                                Bắt Đầu Thi Thử
                            </a>
                        </div>
                    </div>

                    <div class="bg-white m-t-10 border-simple">
                        <div class="bs-callout bs-callout-danger">
                            <p>
                                <a href="https://www.facebook.com/groups/teen2004toanlyhoa" target="_blank">
                                   <img alt="" src="{{ asset('images/facebook-icon.svg') }}" class="exam-icon_qa">
                                    <span style="color: #000;">Nhóm học tập facebook miễn phí cho teen 2k4: </span>
                                    <b style="color:green;">fb.com/groups/hoctap2k4/</b>
                                </a>
                            </p>
                            <p>
                                <a class="link-title_qa" class="has-underline" href="https://m.me/377846149262767?ref=tieuhoc" target="_blank">
                                    <img alt="" src="{{ asset('images/hot.png') }}" class="exam-icon_qa">
                                    Đồng giá 250k 1 khóa học lớp 3-12 bất kỳ tại VietJack. Đăng ký ngay!
                                </a>
                            </p>
                            <p>
                                <a class="link-title_qa js-download_app" href="javascript:;">
                                    <img alt="" src="{{ asset('images/icon_vj_sm.png') }}" class="exam-icon_qa"> Thi online trên app VietJack. Tải ngay!
                                </a>
                            </p>
                        </div>
                        <div class="answer">
                            <h3 class="title-des"><span class="cl-900">{{ config('app.site_name') }}</span> Trả lời:</h3>
                            <div class="question m-t-10">
                                <div class="result">
                                    {!! $question->reason !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white m-t-10 border-simple">
                        <h3 class="title-des2">CÂU HỎI HOT CÙNG CHỦ ĐỀ</h3>
                    </div>

                    @foreach($curriculum->questions as $que)
                        <div class="bg-white m-t-10 border-simple">
                            <h3 class="title-des3">Câu {{ $loop->iteration }}:</h3>
                            <div class="item-qa">
                                <h4 style="cursor: pointer;" onclick="window.location.href = '{{ route('question.show', [$que->id, $que->slug]) }}'" class="title-question overflow-x-el m-tb-12">
                                    {!! $que->content !!}
                                </h4>
                                <div class="answers">
                                    @foreach($que->answers as $ans)
                                        <div class="answer-check radio">
                                            <label onclick="window.location.href = '{{ route('question.show', [$que->id, $que->slug]) }}'">
                                                <span class="cr"></span>
                                                {!! $ans->content !!}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="footer-list"></div>
                            <div class="question-info p-tb-15">
                                <span class="float-left">
                                    <a class="read-more" href="{{ route('question.show', [
                                        $que->id,
                                        $que->slug
                                    ]) }}">Xem đáp án »</a>
                                </span>
                                <span class="float-right">
                                    <span><i class="fas fa-clock"></i> {{ date('d/m/Y',strtotime($que->created_at)) }}</span>
                                    <span><i class="fas fa-eye"></i> {{ number_format($que->view) }}</span>
                                </span>
                            </div>
                        </div>
                    @endforeach

                    <div class="bg-white border-simple m-t-10">
                        <div class="text-center">
                            <a class="tart_test btn-block" href="{{ route('exam.show', [$course->slug, $curriculum->id]) }}">
                                Xem thêm các câu hỏi khác »
                            </a>
                        </div>
                    </div>
                </div>

                <div class="left-qa col-sm-12 col-md-5 col-lg-4 p-b-10">
                    @if ($relatedExams->count() > 0)
                        <div class="bg-white br-5 p-tb-12 p-rl-12">
                            <div class="relative p-rl-5">
                                <h3 class="f1-m-9 cl3 p-tb-5 text-uppercase">
                                    Đề thi liên quan
                                </h3>
                                @if ($course->grade && $course->subject)
                                    <span class="more-list d-block d-sm-none">
                                        <a href="{{ route('exam-by-grade-subject', [
                                            $course->grade->slug,
                                            $course->subject->slug
                                        ]) }}" class="dis-block f1-s-10 text-uppercase cl2 hov-cl10 trans-03">
                                            Xem thêm »
                                        </a>
                                    </span>
                                @endif
                            </div>
                            <div class="body-list">
                                <ul>
                                    @foreach($relatedExams as $exam)
                                        <li>
                                            <div class="icon-list">
                                                <img src="{{ asset('images/checked.png') }}">
                                            </div>
                                            <div class="title-item">
                                                <a href="{{ route('exam.show', $exam->slug) }}">{{ $exam->title }}</a>
                                            </div>
                                            <div class="info-item">
                                                <span>
                                                    <i class="fas fa-file-signature"></i>
                                                    <span>{{ $exam->curriculums_count }} đề</span>
                                                </span>
                                                <span>
                                                    <i class="far fa-clock"></i>
                                                    <span>{{ $exam->view }} lượt thi</span>
                                                </span>
                                                <a href="">Thi thử</a>
                                            </div>
                                        </li>
                                    @endforeach
                                    <li><br></li>
                                </ul>
                            </div>
                            <div class="footer-list"></div>
                            @if ($course->grade && $course->subject)
                                <span class="text-center d-none d-sm-block">
                                    <a href="{{ route('exam-by-grade-subject', [
                                        $course->grade->slug,
                                        $course->subject->slug
                                    ]) }}" class="dis-block f1-s-9 text-uppercase cl2 hov-cl10 trans-03 p-b-5 p-t-10">
                                        Xem thêm »
                                    </a>
                                </span>
                            @endif
                        </div>
                    @endif

                    <div class="m-t-15 text-center">
                        <a class="tart_test btn-block" href="https://hoidapvietjack.com/" target="_blank">
                            <i class="fas fa-question-circle"></i>
                            Hỏi bài
                        </a>
                    </div>

                    @if ($newQuestions->count() > 0)
                        <div class="m-t-15 bg-white br-5 p-tb-12 p-rl-12">
                            <div class="relative p-rl-5">
                                <h3 class="f1-m-9 cl3 p-tb-5 text-uppercase">
                                    Câu hỏi mới nhất
                                </h3>
                                @if ($course->grade && $course->subject)
                                    <span class="more-list d-block d-sm-none">
                                        <a href="{{ route('question.index', [
                                            'lop' => $course->grade->slug,
                                            'mon' => $course->subject->slug
                                        ]) }}" class="dis-block f1-s-10 text-uppercase cl2 hov-cl10 trans-03">
                                            Xem thêm »
                                        </a>
                                    </span>
                                @endif
                            </div>
                            <div class="body-list">
                                <ul>
                                    @foreach($newQuestions as $newQuestion)
                                        <li>
                                            <div class="icon-list">
                                                <img src="{{ asset('images/ask-question.png') }}">
                                            </div>
                                            <div class="title-item">
                                                <a href="{{ route('question.show', [$newQuestion->id, $newQuestion->slug]) }}">
                                                    {!! $newQuestion->content !!}
                                                </a>
                                            </div>
                                            <div class="info-item">
                                                <span>
                                                    <i class="far fa-eye"></i>
                                                    <span>{{ number_format($newQuestion->view) }}</span>
                                                </span>
                                                <span>
                                                    <i class="far fa-clock"></i>
                                                    <span>{{ date('d/m/Y', strtotime($newQuestion->created_at)) }}</span>
                                                </span>
                                                <a href="{{ route('question.show', [$newQuestion->id, $newQuestion->slug]) }}">Xem đáp án</a>
                                            </div>
                                        </li>
                                    @endforeach
                                    <li><br></li>
                                </ul>
                            </div>
                            <div class="footer-list"></div>
                            @if ($course->grade && $course->subject)
                                <span class="text-center d-none d-sm-block">
                                    <a href="{{ route('question.index', [
                                        'lop' => $course->grade->slug,
                                        'mon' => $course->subject->slug
                                    ]) }}" class="dis-block f1-s-9 text-uppercase cl2 hov-cl10 trans-03 p-b-5 p-t-10">
                                        Xem thêm »
                                    </a>
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
