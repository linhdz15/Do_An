@php
    $title = 'Trang ' . $questions->currentPage() . ' - ' . $questions->total() . ' câu hỏi miễn phí có lời giải chi tiết';
    $description = 'Ngân hàng câu hỏi miễn phí tất cả các môn Toán, Ngữ văn, Tiếng anh, Vật lý, Hóa học, Sinh học, Lịch sử, Địa lý, Giáo dục công dân...';
@endphp


@section('seo_title', $title)
@section('seo_description', $description)
@section('og_title', $title)
@section('og_description', $description)
@section('og_type', 'object')

@extends('layouts.web')
@section('content')
<div id="main-content">
    <div class="container p-t-30">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3 p-b-10">
                @include('web.questions.partials.sidebar-filter')
            </div>
            <div class="col-sm-12 col-md-8 col-lg-9 p-b-10 bg-white">
                <div class="ques-list">
                    <div class="ques-header">
                        <h4 class="f1-m-7 cl3 p-tb-12 text-uppercase">
                            Danh sách câu hỏi
                        </h4>
                        <p class="m-tb-10 cl9">
                            Có {{ $questions->total() }} câu hỏi trên {{ $questions->lastPage() }} trang
                        </p>
                    </div>
                    <div class="ques-body">
                        @foreach($questions as $question)
                            <div class="ques-item">
                                <div class="ques-item-title overflow-x-el">
                                    <a class="cl3 fs-18" href="{{ route('question.show', [
                                        $question->id,
                                        $question->slug
                                    ]) }}">
                                        {!! $question->content !!}
                                    </a>
                                </div>
                                <div class="ques-item-wrapper">
                                    <div class="ques-item-left">
                                        <div class="ques-item-meta cl-red fs-14 m-tb-10">
                                            {{ time_elapsed_string($question->created_at) }}
                                        </div>
                                        <div class="ques-item-tags">
                                            @if (!empty($question->curriculum->course->subject))
                                                <a class="m-r-15" href="">
                                                    <span class="badge badge-danger fs-13 p-tb-5 p-rl-10">
                                                        {{ $question->curriculum->course->subject->title }}
                                                    </span>
                                                </a>
                                            @endif
                                            @if (!empty($question->curriculum->course->grade))
                                                <a class="m-r-15" href="">
                                                    <span class="badge badge-success fs-13 p-tb-5 p-rl-10">
                                                        {{ $question->curriculum->course->grade->title }}
                                                    </span>
                                                </a>
                                            @endif
                                            <a href="">
                                                <span class="badge badge-info fs-13 p-tb-5 p-rl-10">
                                                    {{ $question->curriculum->course->title }}
                                                </span>
                                            </a>
                                        </div>
                                        <div class="ques-item-more m-t-5">
                                            <a href="">Xem chi tiết »</a>
                                            <a href=""><i class="fab fa-facebook-f"></i> Chia sẻ</a>
                                        </div>
                                    </div>
                                    <div class="ques-item-right">
                                        <div class="ques-item-view">{{ number_format($question->view) }}</div>
                                        <p class="text-center fs-14">lượt xem</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="ques-footer">
                        @if ($questions->hasPages())
                            {{ $questions->links('web.components.pagination') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
