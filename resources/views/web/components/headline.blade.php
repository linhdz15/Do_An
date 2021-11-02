@if ($examTrendings->count() > 0)
    <div class="container">
        <div class="flex-wr-sb-c p-rl-20 p-t-20 f2-s-1">
            <span class="text-uppercase cl2 p-r-8">
                Bài thi Hot:
            </span>
            <marquee id="exam-trending" class="trending" width="80%" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                @foreach($examTrendings as $examTrending)
                    <span class="trending-item">
                        <span class="dis-inline-block">
                            <a href="#" class="f1-s-2 cl3 hov-cl10 trans-03">
                                <i class="far fa-newspaper"></i>&nbsp;&nbsp;
                                <span class="exam-title">
                                    {{ $examTrending->title }}
                                    @if (!empty($examTrending->course->subject))
                                        - Môn {{ $examTrending->course->subject->title }}
                                    @endif
                                    @if (!empty($examTrending->course->grade))
                                        - {{ $examTrending->course->grade->title }}
                                    @endif
                                </span>
                                <span class="d-none exam-view">{{ $examTrending->view }}</span>
                            </a>
                        </span>
                        @if (!$loop->last)
                            <span class="cl9">&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;</span>
                        @endif
                    </span>
                @endforeach
            </marquee>
        </div>
    </div>
@endif




