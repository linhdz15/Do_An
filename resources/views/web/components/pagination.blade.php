@if ($paginator->hasPages())
    <div class="flex-wr-c-c m-rl--7 p-b-20">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7 pagi-disabled">
                <i class="fa fa-angle-left"></i>
            </a>
            {{-- <li class="page-item">
                <a class="page-link disabled"> <i class="fa fa-angle-left"></i></a>
            </li> --}}
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7">
                <i class="fa fa-angle-left"></i>
            </a>
            {{-- <li class="page-item">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link"> <i class="fa fa-angle-left"></i></a>
            </li> --}}
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7 pagi-disabled">{{ $element }}</a>
                {{-- <li class="page-item">
                    <a class="page-link disabled">{{ $element }}</a>
                </li> --}}
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7 pagi-active">{{ $page }}</a>
                        {{-- <li class="page-item" aria-current="page">
                            <a class="page-link active">{{ $page }}</a>
                        </li> --}}
                    @else
                        <a href="{{ $url }}" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7">{{ $page }}</a>
                        {{-- <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li> --}}
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7">
                <i class="fa fa-angle-right"></i>
            </a>
            {{-- <li class="page-item">
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link"> <i class="fa fa-angle-right"></i></a>
            </li> --}}
        @else
            <a class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7 pagi-disabled">
                <i class="fa fa-angle-right"></i>
            </a>
            {{-- <li class="page-item">
                <a class="page-link disabled"> <i class="fa fa-angle-right"></i></a>
            </li> --}}
        @endif
    </div>
@endif
