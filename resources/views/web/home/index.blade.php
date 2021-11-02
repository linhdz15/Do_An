
@extends('layouts.web')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="row m-t-15">
            @foreach($grades as $grade)
                <div class="col-lg-6 col-md-12">
                    <div class="info-box">
                        <a href="#" title="{{ config('web.grades.' . $grade->slug . '.description') ?? '' }}">
                            <div class="info-box-body">
                                <div class="info-box-icon" style="background-color: {{ config('web.grades.' . $grade->slug . '.background') }};">
                                    {{ config('web.grades.' . $grade->slug . '.icon_text') }}
                                </div>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ $grade->title }}</span>
                                    <p class="info-box-des">{{ config('web.grades.' . $grade->slug . '.description') ?? '' }}</p>
                                    <span class="info-box-number">{{ $grade->exam_count }} bộ đề</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection