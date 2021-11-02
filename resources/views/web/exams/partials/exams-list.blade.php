<div class="bg0 chapter-item">
    @php
        $txt = '';

        if (!empty($chapter)) {
            $txt .= $chapter->title;
        }

        if (!empty($lesson)) {
            $txt .= ' - ' . $lesson->title;
        }
    @endphp
    <a class="url-root" title="Tổng hợp các đề thi hay nhất có đáp án" @if($txt) style="text-transform: initial; font-size: 16px;" @endif>
        Tổng hợp các đề thi hay nhất có đáp án {{ $txt ? ' trong ' . $txt : '' }}
    </a>
    <ul class="list-style-none lesson-wrapper">
        @foreach ($exams as $exam)
            <li class="exam-item last-item">
                <div class="is_free visible">
                </div>
                <div class="block-content-exam-item">
                    <p class="test m-b-10">
                        <a class="url-root" href="{{ route('exam.show', $exam->slug) }}" title="{{ $exam->title }}" style="margin-left: 0;">
                            <i class="fas fa-check-circle fs-14" style="color: red;"></i> {{ $exam->title }}
                        </a>
                    </p>
                </div>
            </li>
        @endforeach
    </ul>
    @if ($exams->hasPages())
        {{ $exams->links('web.components.pagination') }}
    @endif
</div>
