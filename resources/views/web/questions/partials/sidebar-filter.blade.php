<div id="sidebar-filter">
    <div class="m-b-25 d-block d-md-none">
        <label for="sidebar-filter-checkbox" style="background-color: #201f1f; cursor: pointer;" class="sidebar-separator-title list-group-item d-flex align-items-center">
            <span>Lọc câu hỏi</span>
            <i class="fas fa-filter"></i>
        </label>
    </div>
    <input class="sidebar-filter-checkbox d-none" type="checkbox" id="sidebar-filter-checkbox">
    <div class="menu-sidebar-filter d-none d-md-block">
        <div class="sidebar-expanded m-b-10">
            <ul class="list-group">
                <li class="list-group-item sidebar-separator-title d-flex align-items-center">
                    <span>Sắp xếp</span>
                    <i class="fas fa-sort"></i>
                </li>
                <div class="sidebar-submenu">
                    {{ Form::open([
                        'method' => 'GET',
                        'class' => 'js-filter-sort',
                    ]) }}
                        <div class="form-group">
                            {{ Form::select('sort', ['newest' => 'Mới nhất', 'trending' => 'Xem nhiều nhất'], request('sort'), [
                                'class' => 'form-control select2',
                                'id' => 'sort',
                                'data-placeholder' => 'Sắp xếp',
                            ]) }}
                        </div>
                    {{ Form::close() }}
                </div>
            </ul>
        </div>
        <div class="sidebar-expanded m-b-10">
            <ul class="list-group">
                <li class="list-group-item sidebar-separator-title d-flex align-items-center">
                    <span>Toàn bộ Trắc nghiệm</span>
                    <i class="fas fa-bars"></i>
                </li>
                @foreach($menus['grades'] as $grade)
                    <a href="#submenu-{{ $grade['id'] }}" data-toggle="collapse" aria-expanded="{{ request('lop') == $grade['slug'] ? 'true' : 'false' }}" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span>{{ $grade['title'] }}</span>
                            <span class="submenu-icon ml-auto"></span>
                        </div>
                    </a>
                    <div id='submenu-{{ $grade['id'] }}' class="collapse sidebar-submenu {{ request('lop') == $grade['slug'] ? 'show' : '' }}">
                        @foreach($menus['subjects'][$grade['id']] as $subject)
                            <a href="{{ route('question.index', [
                                'lop' => $grade['slug'],
                                'mon' => $subject['slug']
                            ]) }}" class="list-group-item list-group-item-action {{ (request('lop') == $grade['slug'] && request('mon') == $subject['slug']) ? 'active' : '' }}">
                                @if (!empty($subject['icon']))
                                    <i class="{{ $subject['icon'] }} fs-13 m-r-5"></i>
                                @endif
                                <span>{{ $subject['title'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endforeach 
            </ul>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Collapse click
        $('[data-toggle=sidebar-colapse]').click(function() {
            SidebarCollapse();
        });

        function SidebarCollapse () {
            $('.menu-collapsed').toggleClass("d-none");
        }

        $('#sort').on('change', function() {
            let href = location.href;
            const value = $(this).val();
            const key = $(this).attr('name');
            
   
            location.href = updateQueryStringParameter(href, key, value);
        })

        function updateQueryStringParameter(uri, key, value) {
            let re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
            let separator = uri.indexOf('?') !== -1 ? "&" : "?";

            if (uri.match(re)) {
                return uri.replace(re, '$1' + key + "=" + value + '$2');
            } else {
                return uri + separator + key + "=" + value;
            }
        }
    </script>
@endpush
