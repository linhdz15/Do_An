require('../common');
import { select2DefaultLang } from '../modules/select2-default-lang';
import { initSelect2SelectedValues } from '../modules/init-select2-selected-values';
import helperFunc from '../modules/helpers';

window.helperFunc = helperFunc;

$(function() {
    select2DefaultLang($);
    initSelect2SelectedValues();

    initDeleteButton();

    $('.js-change-status').on('change', function() {
        axios({
            method: 'POST',
            url: $(this).data('action'),
            params: {
                status: this.checked
            },
        })
    });

    $('#title-input').keyup(function() {
        $('#slug-input').val(window.helperFunc.titleToSlug($(this).val(), $('#slug-input').attr('maxlength')));
        $('#seo_title-input').val($(this).val());
    })

    $('.input-selected-2').select2({
        minimumInputLength: 0,
        width: '100%',
    });

    $('#grades').select2({
        minimumInputLength: 0,
        width: '100%',
        allowClear: true,
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
                    grade_id: $('#grades').val(),
                };

                return query;
            },
            cache: true,
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
                    grade_id: $('#grades').val(),
                    subject_id: $('#subjects').val(),
                };

                return query;
            },
            cache: true,
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
                    chapter_id: $('#chapters').val(),
                };

                return query;
            },
            cache: true,
        },
    });

    $('#grades, #subjects').on('change', function() {
        $('#chapters').val(null).trigger('change');
    });

    $('#chapters').on('change', function() {
        $('#lessons').val(null).trigger('change');
    });

    $('#subjects').on('select2:open', function() {
        if (!$('#grades').val() || $('#grades').val() == 0) {
            alert('Bạn vui lòng chọn lớp!');
            $(this).select2('close');

            return;
        }
    });

    $('#chapters').on('select2:open', function() {
        if (!$('#grades').val() || !$('#subjects').val() || $('#subjects').val() == 0) {
            alert('Bạn vui lòng chọn lớp và môn.');
            $(this).select2('close');

            return;
        }
    });

    $('#lessons').on('select2:open', function() {
        if (!$('#chapters').val() || $('#chapters').val() == 0) {
            alert('Bạn vui lòng chọn một chương trước.');
            $(this).select2('close');

            return;
        }
    });

    $('#users').select2({
        minimumInputLength: 0,
        width: '100%',
        allowClear: true,
    });

    $('#image_file').change(function() {
        var val = $(this).val().toLowerCase(),
            regex = new RegExp("(.*?)\.(jpg|jpeg|gif|png)$");

        if (!(regex.test(val))) {
            $(this).val('');
            alert('Xin hãy chọn đúng định dạng ảnh (jpg|jpeg|gif|png)');
        } else {
            var fr = new FileReader;
            var f = 0;
            fr.onload = function(e) { // file is loaded
                var img = new Image;

                img.onload = function() {
                    if (img.height >= 120 && img.width >= 230) {
                        $('#image_preview').attr('src', e.target.result);
                        let temp = val.split("\\");
                        $('#image-message').html('Đã chọn Ảnh ' + temp[temp.length - 1] + ', bấm Lưu lại để đăng');
                    } else {
                        $(this).val('');
                        alert('Chiều cao tối thiểu 120px, chiều rộng tối thiểu 230px');
                    }
                };

                img.src = fr.result; // is the data URL because called with readAsDataURL
            };

            fr.readAsDataURL(this.files[0]);
        }
    });

    $('input[name="dates"]').daterangepicker({
        locale: {
            format: 'YYYY/MM/DD'
        }
    });
});

// remove FREE TRIAL EXPIRED foreground MathType
function loaded(selector, callback) {
    //trigger after page load.
    $(function() {
        callback($(selector));
    });
    //trigger after page update eg ajax event or jquery insert.
    $(document).on('DOMNodeInserted', selector, function() {
        callback($(this));
    });
}

loaded('.wrs_modal_dialogContainer', function(el) {
    // some action
    el.find('.wrs_tickContainer').remove();
});

function initDeleteButton() {
    $('.table').on('click', '.js-form-delete', function(event) {
        event.preventDefault();
        const $button = $(this);

        Swal.fire({
            title: 'Are you sure?',
            text: 'Confirm',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $button
                    .parents('form')
                    .first()
                    .submit();

                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        })
    });
}


/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('../components/index');
