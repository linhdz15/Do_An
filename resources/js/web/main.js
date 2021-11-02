/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

import $ from 'jquery';
window.$ = window.jQuery = $;
import 'slick-carousel'
import 'bootstrap';

window.Popper = require('popper.js').default;

require('../common');

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

(function($) {
    'use strict';
    /* ==================================================================
      [ Back to top ] */
    try {
        var windowH = $(window).height() / 2;

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > windowH) {
                $('#myBtn').addClass('show-btn-back-to-top');
            } else {
                $('#myBtn').removeClass('show-btn-back-to-top');
            }
        });

        $('#myBtn').on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 300);
        });
    } catch (er) { console.log(er) }

    /* ==================================================================
      [ Fixed menu ] */
    try {
        var posNav = $('.wrap-main-nav').offset().top;
        var menuDesktop = $('.container-menu-desktop');
        var mainNav = $('.main-nav');
        var lastScrollTop = 0;
        var st = 0;

        $(window).on('scroll', function() {
            fixedHeader();
        });

        $(window).on('resize', function() {
            fixedHeader();
        });

        $(window).on('load', function() {
            fixedHeader();
        });

        var fixedHeader = function() {
            st = $(window).scrollTop();

            if (st > posNav + mainNav.outerHeight()) {
                $(menuDesktop).addClass('fix-menu-desktop');
            } else if (st <= posNav) {
                $(menuDesktop).removeClass('fix-menu-desktop');
            }

            if (st > lastScrollTop) {
                $(mainNav).removeClass('show-main-nav');
            } else {
                $(mainNav).addClass('show-main-nav');
            }

            lastScrollTop = st;
        };
    } catch (er) { console.log(er) }

    /* ==================================================================
      [ Menu mobile ] */
    try {
        $('.btn-show-menu-mobile').on('click', function() {
            $(this).toggleClass('is-active');
            $('.menu-mobile').slideToggle();
        });

        var arrowMainMenu = $('.arrow-main-menu-m');

        for (var i = 0; i < arrowMainMenu.length; i++) {
            $(arrowMainMenu[i]).on('click', function() {
                $(this).parent().find('.sub-menu-m').slideToggle();
                $(this).toggleClass('turn-arrow-main-menu-m');
            });
        }

        $(window).on('resize', function() {
            if ($(window).width() >= 992) {
                if ($('.menu-mobile').css('display') === 'block') {
                    $('.menu-mobile').css('display', 'none');
                    $('.btn-show-menu-mobile').toggleClass('is-active');
                }

                $('.sub-menu-m').each(function() {
                    if ($(this).css('display') === 'block') {
                        $(this).css('display', 'none');
                        $(arrowMainMenu).removeClass('turn-arrow-main-menu-m');
                    }
                });
            }
        });
    } catch (er) { console.log(er) }

    /*==================================================================
    [ Tab mega menu ]*/
    try {
        $(window).on('load', function() {
            $('.sub-mega-menu .nav-pills > a').hover(function() {
                $(this).tab('show');
            });
        });
    } catch (er) { console.log(er); }

    /*==================================================================
    [ Footer menu ]*/
    try {
        let gradeMenuFooter = '';

        $('#grade-menu-m li').each(function() {
            const el = $(this).find('a');
            const text = el.text();
            const href = el.attr('href');

            gradeMenuFooter += renderGradeMenuFooter(text, href);
        });

        $('#grade-menu-footer').html(`
            <div class="row">
                ${gradeMenuFooter}
            </div>
        `)

        function renderGradeMenuFooter(text, href) {
            return `<div class="col-4">
                        <div class="how-bor1 p-b-10">
                            <a href="${href}" class="f1-s-8 cl11 hov-cl10 trans-03 p-tb-8">
                                ${text}
                            </a>
                        </div>
                    </div>`;
        }

        let examTrendingFooter = '';

        $.each($("input[name*='data']"), function() {
            $('#preview').append($(this).val() + ' - ' + $(this).next('input').val() + '$<br>');
        });
    } catch (er) { console.log(er); }

    /*==================================================================
    [ Login form ]*/
    try {
        /*==================================================================
        [ Validate ]*/
        var input = $('.login-box .validate-input .input100');

        $('.login-box .validate-form').on('submit',function(){
            var check = true;

            for(var i=0; i<input.length; i++) {
                if(validate(input[i]) == false){
                    showValidate(input[i]);
                    check=false;
                }
            }

            return check;
        });


        $('.login-box .validate-form .input100').each(function(){
            $(this).focus(function(){
               hideValidate(this);
            });
        });

        function validate (input) {
            if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
                if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                    return false;
                }
            }
            else {
                if($(input).val().trim() == ''){
                    return false;
                }
            }
        }

        function showValidate(input) {
            var thisAlert = $(input).parent();

            $(thisAlert).addClass('alert-validate');
        }

        function hideValidate(input) {
            var thisAlert = $(input).parent();

            $(thisAlert).removeClass('alert-validate');
        }
    } catch (er) { console.log(er); }
})(jQuery);
