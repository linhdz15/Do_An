/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/js/web/start-exam.js ***!
  \****************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function () {
  $('#sidebarCollapse').on('click', function () {
    $('#sidebar-wrapper, #content, .navbar-fixed').toggleClass('active');
    $('.collapse.in').toggleClass('in');
    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
  });
  timerClock();
  var numberQuestion = getHash();
  var totalQuestion = $('.number-question').length;
  showQuiz(numberQuestion);
  $(window).on('hashchange', function () {
    var hash = getHash();
    numberQuestion = hash > totalQuestion ? totalQuestion : hash;
    showQuiz(numberQuestion);
  }); // JS needed ONLY for click stuff
  // Presentation/scrolling/snapping can be done using only CSS

  var scrollBox = document.querySelector('.scroll-on');
  var overlays = document.querySelectorAll('.scroll-overlay');
  var leftOverlay = Array.from(overlays).find(function (item) {
    return item.nextElementSibling && item.nextElementSibling.className === 'scroll-overlay';
  });
  var rightOverlay = Array.from(overlays).find(function (item) {
    return item.previousElementSibling && item.previousElementSibling.className === 'scroll-overlay';
  });
  var scrollItem = document.querySelector('.scroll-slider ul');
  var panelItems = document.querySelectorAll('.scroll-slider li');

  var disableActives = function disableActives(itemList) {
    itemList.forEach(function (item) {
      item.classList.remove('active');
    });
  };

  var onItemClick = function onItemClick(_ref) {
    var target = _ref.target;
    target.scrollIntoView({
      behavior: 'smooth',
      block: 'nearest',
      inline: 'center'
    });

    if (!target.classList.contains('active')) {
      disableActives(panelItems);
      target.classList.add('active');
      window.location.hash = 'cau_' + parseInt(target.getAttribute('number-question'));
    }
  };

  panelItems.forEach(function (item) {
    item.addEventListener('click', onItemClick);
  }); // Show/Hide scroll overlays

  function debounce(func, wait, immediate) {
    var timeout;
    return function () {
      var context = this,
          args = arguments;

      var later = function later() {
        timeout = null;
        if (!immediate) func.apply(context, args);
      };

      var callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) func.apply(context, args);
    };
  }

  var leftOverlayVisibility = function leftOverlayVisibility(visible) {
    leftOverlay.style.opacity = visible ? 1 : 0;
  };

  var rightOverlayVisibility = function rightOverlayVisibility(visible) {
    rightOverlay.style.opacity = visible ? 1 : 0;
  };

  var controlOverlays = function controlOverlays() {
    if (scrollBox.scrollLeft === 0) {
      leftOverlayVisibility(false);
    } else {
      leftOverlayVisibility(true);
    }

    if (scrollBox.scrollLeft === scrollItem.scrollWidth - scrollBox.clientWidth) {
      rightOverlayVisibility(false);
    } else {
      rightOverlayVisibility(true);
    }
  };

  controlOverlays();
  scrollBox.addEventListener('scroll', debounce(controlOverlays, 50));
  $('#next-question').click(function () {
    numberQuestion++;

    if (numberQuestion > totalQuestion) {
      numberQuestion = totalQuestion;
      submitTest();
    }

    handleButtonControll(numberQuestion);
    showQuiz(numberQuestion);
    $(".number-question[number-question='".concat(numberQuestion, "']")).trigger('click');
  });
  $('#previous-question').click(function () {
    numberQuestion--;

    if (numberQuestion < 1) {
      numberQuestion = 1;
    }

    handleButtonControll(numberQuestion);
    showQuiz(numberQuestion);
    $(".number-question[number-question='".concat(numberQuestion, "']")).trigger('click');
  });
  $('.quiz:not(".done") .anwser').on('click', function () {
    $('#previous-question, #next-question').addClass('d-none');
    $('#submit-question').removeClass('d-none');
  });
  $('#submit-question').on('click', function () {
    var quiz = $(".quiz[quiz-index=".concat(numberQuestion, "]"));
    var quiz_id = quiz.attr('quiz-id');
    var choose_answer_index = $('.anwser:checked').val() || null;
    quiz.find('.options').append('<div class="overlay-anwsers"></div>');
    axios({
      method: 'POST',
      url: $(this).data('action'),
      data: {
        question_id: quiz_id,
        choose_answer_index: choose_answer_index
      }
    }).then(function (res) {
      if (res.status == 200) {
        $(".js-reason-".concat(res.data.question.id)).html(renderReason(res.data.question.reason, res.data.status));
        $('.anwser:checked').siblings('label').append(renderIconMark(res.data.status)).css('background', res.data.status == 1 ? '#effbee' : '#f9dbdb');
        quiz.find(".anwser[value='".concat(res.data.right_answer, "']")).siblings('label').append(renderIconMark(1));
        quiz.addClass('done');
        quiz.find('.options .anwser').remove(); // remove input radio

        $(".number-question[question-id=".concat(res.data.question.id, "]")).addClass(res.data.status == 1 ? 'correct' : 'failed');
        toastr.options.timeOut = 1000;

        if (res.data.status == 1) {// toastr.success('Tuyệt vời! Tiếp tục phát huy nhé.');
        } else {
          toastr.error('Tiếc quá! Bạn đã chọn sai đáp án.');
        }

        $(".js-reason-".concat(res.data.question.id))[0].scrollIntoView({
          behavior: 'smooth',
          block: 'center'
        });
        MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
      }
    })["catch"](function (error) {
      Swal.fire({
        icon: 'error',
        title: 'Error...',
        text: 'Đã xảy ra sự cố, vui lòng thử lại hoặc tải lại trang!'
      });
    })["finally"](function () {
      $('#previous-question, #next-question').removeClass('d-none');
      $('#submit-question').addClass('d-none');
    });
  });
  $('.show-anwser').on('click', function () {
    $('.anwser').prop('checked', false);
    $('#submit-question').trigger('click');
  });
  $('#submit-test').on('click', function () {
    submitTest();
  });
  $('.leave-site').on('click', function (e) {
    e.preventDefault();
    var redirectTo = $(this).attr('href');
    submitTest(redirectTo);
  });
});

function renderReason(reason, status) {
  return "\n        <p class=\"reason-label\">Gi\u1EA3i Th\xEDch</p>\n        <div class=\"p-l-20 m-t-15 ".concat(status == 1 ? 'bl-green' : 'bl-red', "\">\n            ").concat(reason, "\n        </div>\n    ");
}

function renderIconMark(status) {
  return "\n        <span class=\"".concat(status == 1 ? 'checkmark' : 'crossmark', "\"></span>\n    ");
}

function handleButtonControll(numberQuestion) {
  $('#previous-question, #next-question').attr('disabled', false);

  if (numberQuestion == 1) {
    $('#previous-question').attr('disabled', true);
  }
}

function showQuiz(numberQuestion) {
  $('.number-question').removeClass('active');
  $("[number-question=".concat(numberQuestion, "]")).addClass('active');
  window.location.hash = 'cau_' + parseInt(numberQuestion); // document.getElementById(`number-question-direction-${numberQuestion}`).scrollIntoView();

  $('.quiz-content').addClass('d-none');
  $("[quiz-index=".concat(numberQuestion, "]")).removeClass('d-none');
  $('#previous-question, #next-question').removeClass('d-none');
  $('#submit-question').addClass('d-none');
}

function timerClock() {
  var countDownDate = new Date().getTime(); // Update the count down every 1 second

  var x = setInterval(function () {
    // Get todays date and time
    var now = new Date().getTime(); // Find the distance between now and the count down date

    var distance = now - countDownDate; // Time calculations for days, hours, minutes and seconds

    var hours = Math.floor(distance % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
    var minutes = Math.floor(distance % (1000 * 60 * 60) / (1000 * 60));
    var seconds = Math.floor(distance % (1000 * 60) / 1000); // Display the result in the element with id="demo"

    document.getElementById('timer').innerHTML = (hours < 10 ? '0' + hours : hours) + ':' + (minutes < 10 ? '0' + minutes : minutes) + ':' + (seconds < 10 ? '0' + seconds : seconds); // If the count down is finished, write some text
  }, 1000);
}

;

function getHash() {
  var hash = parseInt(document.location.hash.split('#cau_')[1]);
  return hash && Number.isInteger(hash) ? Math.abs(hash) : 1;
}

function submitTest() {
  var _Swal$fire;

  var redirectTo = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
  var questionNotDoing = '';
  $('.number-question:not(".correct, .failed")').each(function () {
    questionNotDoing += $(this).text() + ', ';
  });
  var des = questionNotDoing == '' ? 'Bạn đã sẵn sàng nộp bài!' : 'Bạn chưa hoàn thành các câu: ' + questionNotDoing.slice(0, -2);
  Swal.fire((_Swal$fire = {
    icon: 'question',
    title: 'Nộp bài?',
    text: des
  }, _defineProperty(_Swal$fire, "icon", 'warning'), _defineProperty(_Swal$fire, "showCancelButton", true), _defineProperty(_Swal$fire, "confirmButtonColor", '#3085d6'), _defineProperty(_Swal$fire, "cancelButtonColor", '#d33'), _defineProperty(_Swal$fire, "confirmButtonText", 'Nộp bài'), _defineProperty(_Swal$fire, "cancelButtonText", 'Tiếp tục'), _Swal$fire)).then(function (result) {
    if (result.isConfirmed) {
      axios({
        method: 'POST',
        url: $('#submit-test').data('action'),
        data: {}
      }).then(function (res) {
        if (redirectTo == '') {
          redirectTo = res.data.redirectTo;
        }

        if (redirectTo) {
          window.location.href = redirectTo;
          return;
        }

        window.location.reload();
      })["catch"](function (error) {
        Swal.fire({
          icon: 'error',
          title: 'Error...',
          text: 'Đã xảy ra sự cố, vui lòng thử lại hoặc tải lại trang!'
        });
      });
    }
  });
}
/******/ })()
;