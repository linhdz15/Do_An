import { select2DefaultLang } from '../modules/select2-default-lang';
import { initSelect2SelectedValues } from '../modules/init-select2-selected-values';
import helperFunc from '../modules/helpers';

window.helperFunc = helperFunc

$(function() {
    select2DefaultLang($);
    initSelect2SelectedValues();

    $('#grades').select2({
        minimumInputLength: 0,
        width: '100%',
        allowClear: true,
        ajax: {
            data: function(params) {
                var query = {
                    q: params.term,
                    page: params.page,
                };

                return query;
            },
            processResults: function (data, params) {
                return {
                    results: $.map(data.results, function (item) {
                        return {
                            id: item.slug,
                            text: item.text,
                        }
                    }),
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true,
        },
        escapeMarkup: function (markup) {
            return markup;
        },
    });

    $('#subjects').select2({
        minimumInputLength: 0,
        width: '100%',
        allowClear: true,
        ajax: {
            delay: 150,
            data: function(params) {
                var query = {
                    q: params.term,
                    page: params.page,
                    grade_slug: $('#grades').val(),
                };

                return query;
            },
            processResults: function (data, params) {
                return {
                    results: $.map(data.results, function (item) {
                        return {
                            id: item.slug,
                            text: item.text,
                        }
                    }),
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true,
        },
        escapeMarkup: function (markup) {
            return markup;
        },
    });

    $('#chapters').select2({
        minimumInputLength: 0,
        width: '100%',
        allowClear: true,
        ajax: {
            delay: 150,
            data: function(params) {
                var query = {
                    q: params.term,
                    page: params.page,
                    grade_slug: $('#grades').val(),
                    subject_slug: $('#subjects').val(),
                };

                return query;
            },
            processResults: function (data, params) {
                return {
                    results: $.map(data.results, function (item) {
                        return {
                            id: item.slug,
                            text: item.text,
                        }
                    }),
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
    });

    $('#lessons').select2({
        minimumInputLength: 0,
        width: '100%',
        allowClear: true,
        ajax: {
            delay: 150,
            data: function(params) {
                var query = {
                    q: params.term,
                    page: params.page,
                    chapter_slug: $('#chapters').val(),
                };

                return query;
            },
            processResults: function (data, params) {
                return {
                    results: $.map(data.results, function (item) {
                        return {
                            id: item.slug,
                            text: item.text,
                        }
                    }),
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
    });

    $('#grades').on('change', function() {
        $('#subjects').val(null).trigger('change');
    });

    $('#subjects').on('change', function() {
        $('#chapters').val(null).trigger('change');
    });

    $('#chapters').on('change', function() {
        $('#lessons').val(null).trigger('change');
    });

    $('#subjects').on('select2:open', function() {
        if (!$('#grades').val() || $('#grades').val() == 0) {
            toastr.options.positionClass = 'toast-top-center';
            toastr.error('Bạn vui lòng chọn một lớp bạn quan tâm.');
            $(this).select2('close');

            return;
        }
    });

    $('#chapters').on('select2:open', function() {
        if (!$('#grades').val() || !$('#subjects').val() || $('#subjects').val() == 0) {
            toastr.options.positionClass = 'toast-top-center';
            toastr.error('Bạn vui lòng chọn một môn bạn quan tâm.');
            $(this).select2('close');

            return;
        }
    });

    $('#lessons').on('select2:open', function() {
        if (!$('#chapters').val() || $('#chapters').val() == 0) {
            toastr.options.positionClass = 'toast-top-center';
            toastr.error('Bạn vui lòng chọn một chương bạn quan tâm.');
            $(this).select2('close');

            return;
        }
    });

    $('.js-submit_filter').on('click', function(e) {
        e.preventDefault();
        const $wrapper = $(this);
        const $form = $wrapper.closest('.js-filter-exam');

        if ($form.find('#grades').val()) {
            $form.submit();
        } else {
            toastr.options.positionClass = 'toast-top-center';
            toastr.error('Hãy chọn một lớp bạn quan tâm để tìm kiếm các bộ đề.');

            return;
        }
    });

    $('#sort').select2({
        minimumInputLength: 0,
        width: '100%',
    });

    resizeContentTable();

    $('#dismiss, .sidebar-overlay').on('click', function() {
        $('.sidenav').removeClass('active');
        $('.sidebar-overlay').fadeOut();
    });

    $('#sidebarCollapse').on('click', function() {
        $('ul.content-table').css({
            'max-height': 'calc(100vh)',
        });
        $('.sidenav').addClass('active');
        $('.sidebar-overlay').fadeIn();
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });

    /*--------------------- Scroll to -------------------*/
    $(document).on('click', '[data-toggle="scroll"]', function(e) {
        if (typeof e != 'undefined' && typeof e.preventDefault == 'function') {
            e.preventDefault();
        }

        var $this = $(this),
            $target = $($this.data('target'));
        if ($target.length > 0) {
            var $point = $target.offset().top - 100,
                $duration = 800;
            if ($this.data('duration')) {
                $duration = $this.data('duration');
            }
            scrollTo($point, $duration);
        }
    });

    function scrollTo($point, $duration) {
        if (typeof $duration == 'undefined') {
            $duration = 800;
        }

        $('body,html').animate({
            scrollTop: $point
        }, $duration);
    }
    /*--------------------- Scroll to -------------------*/


    const URL_IOS = '';
    const URL_ANDROID = '';

    $('.js-download_app').on('click', function(event) {
        event.preventDefault();

        const systemType = window.helperFunc.getMobileOperatingSystem();

        if (systemType == 'iOS') {
            window.open(URL_IOS, '_blank');
        } else {
            window.open(URL_ANDROID, '_blank');
        }
    })

    $('.show-more').on('click', function () {
        $('.qas').css('max-height', 'initial');
        $(this).remove();
    })
});

$(window).bind('resize', function() {
    resizeContentTable();
});

$(window).scroll(function() {
    var heightHeader = $('header').height();
    var heightFooter = $('footer').height();
    var heightSidenav = $('.sidenav').height();
    var heightContentTable = $('.sidenav .content-table').height();

    if ($(window).scrollTop() > heightHeader) {
        $('#sidebar').css({ 'position': 'fixed', 'top': '0px', 'width': '300px' });
    } else {
        $('#sidebar').css({ 'position': 'static' });
        $('.sidenav').css({ 'bottom': 'auto' });
    }

    if (($(window).scrollTop() + $(window).height()) > ($(document).height() - 200)) {
        $('#sidebar, .sidenav').css({
            'position': 'absolute',
            'top': 'auto',
            'width': '300px',
            'bottom': '0px'
        });
    }
});

function resizeContentTable() {
    var h = window.innerHeight;
    var calculatecontsize = h - $('header').height();

    $('.sidenav').css({ "height": calculatecontsize + "px" });
}
