@php
    $title = 'Hơn 2000 câu trắc nghiệm ' . ($subject->title ?? ' ') . ' - ' . ($grade->title ?? ' ') .  ' miễn phí với đầy đủ các dạng bài tập, đề thi từ cơ bản đến nâng cao có đáp án và lời giải chi tiết';
    $description = 'Hệ thống bài kiểm tra, đề thi trắc nghiệm miễn phí được thiết kế bám theo cấu trúc chương trình học giúp học sinh rèn luyện, kiểm tra kiến thức tất cả các môn theo mỗi bài, chương, ...';

    if (!empty($chapter)) {
        $title = "Tổng hợp các đề thi $chapter->title - $subject->title $grade->title hay nhất có đáp án và lời giải chi tiết";
    }

    if (!empty($lesson)) {
        $totalExam = $exams->total() ?: 'Tổng hợp';
        $title = "$totalExam bộ đề thi $lesson->title - $subject->title $grade->title có đáp án và lời giải chi tiết";
    }
@endphp

@section('seo_title', $title)
@section('seo_description', $description)

@section('og_title', $title)
@section('og_description', $description)

@section('og_type', 'object')

<x-web-layout>
    <div class="main-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include('web.components.filter-exam')
                </div>
                <div class="col-md-12">
                    <div class="bg0 main-subject m-b-20">
                        <div class="main-subject__list">
                            @foreach($subjects as $sub)
                                <a href="{{ route('exam-by-grade-subject', [$grade, $sub]) }}" class="subject-item {{ $sub->id == $subject->id ? 'active' : '' }}">
                                    <span class="item-wrapper">
                                        <img src="{{ asset(config('web.subjects.' . $sub->slug . '.icon')) }}" class="subject-item__image mr-2">
                                        <span class="subject-item__name {{ $sub->slug }}">{{ $sub->title }}</span>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="list-exam m-b-20">
                        <h3 class="title-exam text-uppercase">Luyện bài tập - đề thi môn {{ $subject->title . ' ' . $grade->title }} </h3>
                        <div class="exams-content">
                            <div class="row">
                                @if (!empty($chapters))
                                    @php
                                        $midNumber = intval($chapters->count() / 2);
                                        $chaptersChunk = $midNumber > 0 ? $chapters->splice($midNumber) : collect([]);
                                        $colClass = $chaptersChunk->isEmpty() ? 'col-lg-12' : 'col-lg-6';
                                    @endphp

                                    <div class="col-12 col-md-12 {{ $colClass }}">
                                        @include('web.exams.partials.tree-exams-list', ['chapters' => $chapters])
                                    </div>

                                    @if ($chaptersChunk->isNotEmpty())
                                        <div class="col-12 col-md-12 {{ $colClass }}">
                                            @include('web.exams.partials.tree-exams-list', ['chapters' => $chaptersChunk, 'isChunk' => true])
                                        </div>
                                    @endif
                                @elseif (!empty($exams))
                                    <div class="col-12 col-md-12 col-lg-12">
                                        @include('web.exams.partials.exams-list')
                                    </div>
                                @else
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="bg0 p-rl-20 p-tb-20">
                                            <p>
                                                Đang cập nhật ...
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
