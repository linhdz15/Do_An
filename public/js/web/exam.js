/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/modules/helpers.js":
/*!*****************************************!*\
  !*** ./resources/js/modules/helpers.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function contains(target, pattern) {
  var value = 0;
  pattern.forEach(function (word) {
    value = value + target.includes(word);
  });
  return value === 1;
}

var helperFunc = {
  titleToSlug: function titleToSlug() {
    var str = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
    var limit = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 70;
    // convert str to slug
    str = str.replace(/^\s+|\s+$/g, ''); // trim

    str = str.toLowerCase(); // remove accents, swap ñ for n, etc

    var from = "áàảạãăắằẳẵặâấầẩẫậäéèẻẽẹêếềểễệëíìỉĩịïóòỏõọôốồổỗộơớờởỡợöúùủũụưứừửữựüûýỳỷỹỵđñç·/_,:;";
    var to = "aaaaaaaaaaaaaaaaaaeeeeeeeeeeeeiiiiiioooooooooooooooooouuuuuuuuuuuuuyyyyydnc------";

    for (var i = 0, l = from.length; i < l; i++) {
      str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-') // collapse dashes
    .replace(/^-/, '') // remove hyphens from first str
    .replace(/[^-]-$/, ''); // remove hyphens from last str

    return limit < 0 ? str : str.substring(0, limit);
  },
  isMobile: function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
  },
  getMobileOperatingSystem: function getMobileOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;

    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
      return 'iOS';
    }

    if (/android/i.test(userAgent)) {
      return 'Android';
    }

    return 'unknown';
  },
  checkImageContent: function checkImageContent() {
    var content = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
    var blackList = ['.googleusercontent.', ';base64,'];
    return contains(content, blackList);
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (helperFunc);

/***/ }),

/***/ "./resources/js/modules/init-select2-selected-values.js":
/*!**************************************************************!*\
  !*** ./resources/js/modules/init-select2-selected-values.js ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "initSelect2SelectedValues": () => (/* binding */ initSelect2SelectedValues)
/* harmony export */ });
function initSelect2SelectedValues() {
  $('.js-select2-ajax').each(function () {
    var $select2 = $(this);
    var selectedValues = $select2.data('ajax-selected-values');

    if (!selectedValues || $select2.val() == selectedValues) {
      return;
    }

    var ajaxUrl = $select2.data('ajax-url');
    $.ajax({
      url: ajaxUrl,
      type: 'GET',
      data: {
        selectedValues: selectedValues
      }
    }).done(function (data) {
      if (!data || !data.results || !data.results.length) {
        return;
      }

      for (var index = 0; index < data.results.length; index++) {
        var result = data.results[index];
        var option = new Option(result.text, result.id, true, true);
        $select2.append(option);
      }

      $select2.trigger({
        type: 'select2:select'
      });
    });
  });
}

/***/ }),

/***/ "./resources/js/modules/select2-default-lang.js":
/*!******************************************************!*\
  !*** ./resources/js/modules/select2-default-lang.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "select2DefaultLang": () => (/* binding */ select2DefaultLang)
/* harmony export */ });
function select2DefaultLang($) {
  $.fn.select2.defaults.set('language', $('html').attr('lang') || 'en');
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!**********************************!*\
  !*** ./resources/js/web/exam.js ***!
  \**********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_select2_default_lang__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../modules/select2-default-lang */ "./resources/js/modules/select2-default-lang.js");
/* harmony import */ var _modules_init_select2_selected_values__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../modules/init-select2-selected-values */ "./resources/js/modules/init-select2-selected-values.js");
/* harmony import */ var _modules_helpers__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../modules/helpers */ "./resources/js/modules/helpers.js");



window.helperFunc = _modules_helpers__WEBPACK_IMPORTED_MODULE_2__.default;
$(function () {
  (0,_modules_select2_default_lang__WEBPACK_IMPORTED_MODULE_0__.select2DefaultLang)($);
  (0,_modules_init_select2_selected_values__WEBPACK_IMPORTED_MODULE_1__.initSelect2SelectedValues)();
  $('#grades').select2({
    minimumInputLength: 0,
    width: '100%',
    allowClear: true,
    ajax: {
      data: function data(params) {
        var query = {
          q: params.term,
          page: params.page
        };
        return query;
      },
      processResults: function processResults(data, params) {
        return {
          results: $.map(data.results, function (item) {
            return {
              id: item.slug,
              text: item.text
            };
          }),
          pagination: {
            more: data.pagination.more
          }
        };
      },
      cache: true
    },
    escapeMarkup: function escapeMarkup(markup) {
      return markup;
    }
  });
  $('#subjects').select2({
    minimumInputLength: 0,
    width: '100%',
    allowClear: true,
    ajax: {
      delay: 150,
      data: function data(params) {
        var query = {
          q: params.term,
          page: params.page,
          grade_slug: $('#grades').val()
        };
        return query;
      },
      processResults: function processResults(data, params) {
        return {
          results: $.map(data.results, function (item) {
            return {
              id: item.slug,
              text: item.text
            };
          }),
          pagination: {
            more: data.pagination.more
          }
        };
      },
      cache: true
    },
    escapeMarkup: function escapeMarkup(markup) {
      return markup;
    }
  });
  $('#chapters').select2({
    minimumInputLength: 0,
    width: '100%',
    allowClear: true,
    ajax: {
      delay: 150,
      data: function data(params) {
        var query = {
          q: params.term,
          page: params.page,
          grade_slug: $('#grades').val(),
          subject_slug: $('#subjects').val()
        };
        return query;
      },
      processResults: function processResults(data, params) {
        return {
          results: $.map(data.results, function (item) {
            return {
              id: item.slug,
              text: item.text
            };
          }),
          pagination: {
            more: data.pagination.more
          }
        };
      },
      cache: true
    },
    escapeMarkup: function escapeMarkup(markup) {
      return markup;
    }
  });
  $('#lessons').select2({
    minimumInputLength: 0,
    width: '100%',
    allowClear: true,
    ajax: {
      delay: 150,
      data: function data(params) {
        var query = {
          q: params.term,
          page: params.page,
          chapter_slug: $('#chapters').val()
        };
        return query;
      },
      processResults: function processResults(data, params) {
        return {
          results: $.map(data.results, function (item) {
            return {
              id: item.slug,
              text: item.text
            };
          }),
          pagination: {
            more: data.pagination.more
          }
        };
      },
      cache: true
    },
    escapeMarkup: function escapeMarkup(markup) {
      return markup;
    }
  });
  $('#grades').on('change', function () {
    $('#subjects').val(null).trigger('change');
  });
  $('#subjects').on('change', function () {
    $('#chapters').val(null).trigger('change');
  });
  $('#chapters').on('change', function () {
    $('#lessons').val(null).trigger('change');
  });
  $('#subjects').on('select2:open', function () {
    if (!$('#grades').val() || $('#grades').val() == 0) {
      toastr.options.positionClass = 'toast-top-center';
      toastr.error('Bạn vui lòng chọn một lớp bạn quan tâm.');
      $(this).select2('close');
      return;
    }
  });
  $('#chapters').on('select2:open', function () {
    if (!$('#grades').val() || !$('#subjects').val() || $('#subjects').val() == 0) {
      toastr.options.positionClass = 'toast-top-center';
      toastr.error('Bạn vui lòng chọn một môn bạn quan tâm.');
      $(this).select2('close');
      return;
    }
  });
  $('#lessons').on('select2:open', function () {
    if (!$('#chapters').val() || $('#chapters').val() == 0) {
      toastr.options.positionClass = 'toast-top-center';
      toastr.error('Bạn vui lòng chọn một chương bạn quan tâm.');
      $(this).select2('close');
      return;
    }
  });
  $('.js-submit_filter').on('click', function (e) {
    e.preventDefault();
    var $wrapper = $(this);
    var $form = $wrapper.closest('.js-filter-exam');

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
    width: '100%'
  });
  resizeContentTable();
  $('#dismiss, .sidebar-overlay').on('click', function () {
    $('.sidenav').removeClass('active');
    $('.sidebar-overlay').fadeOut();
  });
  $('#sidebarCollapse').on('click', function () {
    $('ul.content-table').css({
      'max-height': 'calc(100vh)'
    });
    $('.sidenav').addClass('active');
    $('.sidebar-overlay').fadeIn();
    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
  });
  /*--------------------- Scroll to -------------------*/

  $(document).on('click', '[data-toggle="scroll"]', function (e) {
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


  var URL_IOS = 'https://apps.apple.com/us/app/vietjack/id1490262941';
  var URL_ANDROID = 'https://play.google.com/store/apps/details?id=com.jsmile.android.vietjack';
  $('.js-download_app').on('click', function (event) {
    event.preventDefault();
    var systemType = window.helperFunc.getMobileOperatingSystem();

    if (systemType == 'iOS') {
      window.open(URL_IOS, '_blank');
    } else {
      window.open(URL_ANDROID, '_blank');
    }
  });
  $('.show-more').on('click', function () {
    $('.qas').css('max-height', 'initial');
    $(this).remove();
  });
});
$(window).bind('resize', function () {
  resizeContentTable();
});
$(window).scroll(function () {
  var heightHeader = $('header').height();
  var heightFooter = $('footer').height();
  var heightSidenav = $('.sidenav').height();
  var heightContentTable = $('.sidenav .content-table').height();

  if ($(window).scrollTop() > heightHeader) {
    $('#sidebar').css({
      'position': 'fixed',
      'top': '0px',
      'width': '300px'
    });
  } else {
    $('#sidebar').css({
      'position': 'static'
    });
    $('.sidenav').css({
      'bottom': 'auto'
    });
  }

  if ($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
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
  $('.sidenav').css({
    "height": calculatecontsize + "px"
  });
}
})();

/******/ })()
;