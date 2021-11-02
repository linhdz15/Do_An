@foreach ($chapters as $chapter)
    @if ($chapter->lessons->count() > 0 || $chapter->courses->count() > 0)
        <div class="bg0 chapter-item">
            <a class="url-root" href="" title="{{ $chapter->title }}">
                {{ $chapter->title }}
            </a>
            <ul class="list-style-none lesson-wrapper">
                @forelse ($chapter->lessons as $lesson)
                    @if ($lesson->courses->count() > 0)
                        <li class="exam-item">
                            <div class="is_free invisible"></div>
                            <div class="block-content-exam-item">
                                <p class="test">
                                    <a class="url-root" data-target="#courses_of_lesson_{{ $lesson->id }}" data-toggle="collapse" aria-expanded="{{ empty($isChunk) && $loop->parent->first && $loop->first ? 'true' : 'false' }}" title="{{ $lesson->title }}">
                                        {{ $lesson->title }}
                                    </a>
                                </p>
                                <ul class="list-style-none lesson-wrapper collapse {{ empty($isChunk) && $loop->parent->first && $loop->first ? 'show' : '' }}" id="courses_of_lesson_{{ $lesson->id }}">
                                    @foreach ($lesson->courses as $course)
                                        <li class="exam-item last-item">
                                            <div class="is_free visible">
                                            </div>
                                            <div class="block-content-exam-item">
                                                <p class="test m-b-10">
                                                    <a class="url-root" href="{{ route('exam.show', $course->slug) }}" title="{{ $course->title }}">
                                                        <i class="fas fa-check-circle fs-14" style="color: red;"></i> {{ $course->title }}
                                                    </a>
                                                </p>
                                                <div class="fs-14 m-l-5">
                                                    <span>
                                                        <i class="far fa-file-alt"></i> {{ $course->exam_count }} bộ đề
                                                    </span>
                                                    <span class="vertict-line"></span>
                                                    <span>
                                                        <a class="color-green" href="{{ route('exam.show', $course->slug) }}">
                                                            <i class="far fa-hand-point-right"></i> Vào thi!
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                @empty
                    @if ($chapter->courses->count() > 0)
                        <li class="exam-item">
                            <div class="is_free invisible"></div>
                            <div class="block-content-exam-item">
                                <p class="test">
                                    <a class="url-root" data-target="#courses_of_season_{{ $chapter->id }}" data-toggle="collapse" aria-expanded="true" title="Danh sách các đề thi hay nhất có đáp án">
                                        Danh sách các đề thi hay nhất có đáp án
                                    </a>
                                </p>
                                <ul class="list-style-none lesson-wrapper collapse show" id="courses_of_season_{{ $chapter->id }}">
                                    @foreach ($chapter->courses as $course)
                                        <li class="exam-item last-item">
                                            <div class="is_free visible">
                                            </div>
                                            <div class="block-content-exam-item">
                                                <p class="test m-b-10">
                                                    <a class="url-root" href="{{ route('exam.show', $course->slug) }}" title="{{ $course->title }}">
                                                        <i class="fas fa-check-circle fs-14" style="color: red;"></i> {{ $course->title }}
                                                    </a>
                                                </p>
                                                <div class="fs-14 m-l-5">
                                                    <span>
                                                        <i class="far fa-file-alt"></i> {{ $course->exam_count }} bộ đề
                                                    </span>
                                                    <span class="vertict-line"></span>
                                                    <span>
                                                        <a class="color-green" href="{{ route('exam.show', $course->slug) }}">
                                                            <i class="far fa-hand-point-right"></i> Vào thi!
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                @endforelse
            </ul>
        </div>
    @endif
@endforeach
