<div class="sidenav">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h4>
                <a href=""><i class="fas fa-list-ul"></i> &nbsp; Mục lục</a>
            </h4>
            <div id="dismiss">
                <i class="fas fa-long-arrow-alt-left"></i>
            </div>
        </div>

        <ul class="list-unstyled scroll-box content-table">
            @foreach ($chapters as $chapter)
                <li>
                    <a style="font-weight: 500;" data-target="#sidebar_menu_{{ $chapter->id }}" data-toggle="collapse" aria-expanded="{{ $course->chapter_id == $chapter->id ? 'true' : 'false' }}">{{ $chapter->title }}</a>
                    <ul class="list-unstyled collapse {{ $course->chapter_id == $chapter->id ? 'show' : '' }}" id="sidebar_menu_{{ $chapter->id }}">
                        @forelse($chapter->lessons as $lesson)
                            @if ($lesson->courses->count() > 0)
                                <li>
                                    <a style="font-size: 16px; margin-left: 35px;" data-target="#sidebar_sub_menu_{{ $lesson->id }}" data-toggle="collapse" aria-expanded="{{ $course->lesson_id == $lesson->id ? 'true' : 'false' }}">{{ $lesson->title }}</a>
                                    <ul class="list-unstyled collapse {{ $course->lesson_id == $lesson->id ? 'show' : '' }}" id="sidebar_sub_menu_{{ $lesson->id }}">
                                        @foreach($lesson->courses as $sidebarCourse)
                                            <li>
                                                <a style="font-size: 15px; margin-left: 45px;" class="leaf-node {{ active_link('thi-online/' . $sidebarCourse->slug . '/*') }}" href="{{ route('exam.show', ['slug' => $sidebarCourse->slug]) }}" title="{{ $sidebarCourse->title }}">{{ $sidebarCourse->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @empty
                            @foreach($chapter->courses as $sidebarCourse)
                                <li>
                                    <a style="font-size: 15px; margin-left: 35px;" class="leaf-node {{ active_link('thi-online/' . $sidebarCourse->slug . '/*') }}" href="{{ route('exam.show', ['slug' => $sidebarCourse->slug]) }}" title="{{ $sidebarCourse->title }}">{{ $sidebarCourse->title }}</a>
                                </li>
                            @endforeach
                        @endforelse
                    </ul>
                </li>
            @endforeach
        </ul>
    </nav>
</div>

@push('scripts')
    <script>
        const sidebar = $('.scroll-box');
        const elem = $('.scroll-box li').find('a.active');

        const elementScrollToTop = function () {
            if (typeof elem.offset() !== 'undefined') {
                window.scrollTo(0, 0);
                sidebar.animate({
                    scrollTop: (elem.offset().top - '175')
                }, {
                    duration: 'medium',
                    easing: 'swing'
                });
            }
        };

        $(window).on('load', elementScrollToTop);
    </script>
@endpush
