(()=>{"use strict";function e(e,t){var n=0;return t.forEach((function(t){n+=e.includes(t)})),1===n}const t={titleToSlug:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:70;e=(e=e.replace(/^\s+|\s+$/g,"")).toLowerCase();for(var n="áàảạãăắằẳẵặâấầẩẫậäéèẻẽẹêếềểễệëíìỉĩịïóòỏõọôốồổỗộơớờởỡợöúùủũụưứừửữựüûýỳỷỹỵđñç·/_,:;",a="aaaaaaaaaaaaaaaaaaeeeeeeeeeeeeiiiiiioooooooooooooooooouuuuuuuuuuuuuyyyyydnc------",o=0,i=n.length;o<i;o++)e=e.replace(new RegExp(n.charAt(o),"g"),a.charAt(o));return e=e.replace(/[^a-z0-9 -]/g,"").replace(/\s+/g,"-").replace(/-+/g,"-").replace(/^-/,"").replace(/[^-]-$/,""),t<0?e:e.substring(0,t)},isMobile:function(){return/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)},getMobileOperatingSystem:function(){var e=navigator.userAgent||navigator.vendor||window.opera;return/iPad|iPhone|iPod/.test(e)&&!window.MSStream?"iOS":/android/i.test(e)?"Android":"unknown"},checkImageContent:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",n=[".googleusercontent.",";base64,"];return e(t,n)}};function n(){var e=window.innerHeight-$("header").height();$(".sidenav").css({height:e+"px"})}window.helperFunc=t,$((function(){!function(e){e.fn.select2.defaults.set("language",e("html").attr("lang")||"en")}($),$(".js-select2-ajax").each((function(){var e=$(this),t=e.data("ajax-selected-values");if(t&&e.val()!=t){var n=e.data("ajax-url");$.ajax({url:n,type:"GET",data:{selectedValues:t}}).done((function(t){if(t&&t.results&&t.results.length){for(var n=0;n<t.results.length;n++){var a=t.results[n],o=new Option(a.text,a.id,!0,!0);e.append(o)}e.trigger({type:"select2:select"})}}))}})),$("#grades").select2({minimumInputLength:0,width:"100%",allowClear:!0,ajax:{data:function(e){return{q:e.term,page:e.page}},processResults:function(e,t){return{results:$.map(e.results,(function(e){return{id:e.slug,text:e.text}})),pagination:{more:e.pagination.more}}},cache:!0},escapeMarkup:function(e){return e}}),$("#subjects").select2({minimumInputLength:0,width:"100%",allowClear:!0,ajax:{delay:150,data:function(e){return{q:e.term,page:e.page,grade_slug:$("#grades").val()}},processResults:function(e,t){return{results:$.map(e.results,(function(e){return{id:e.slug,text:e.text}})),pagination:{more:e.pagination.more}}},cache:!0},escapeMarkup:function(e){return e}}),$("#chapters").select2({minimumInputLength:0,width:"100%",allowClear:!0,ajax:{delay:150,data:function(e){return{q:e.term,page:e.page,grade_slug:$("#grades").val(),subject_slug:$("#subjects").val()}},processResults:function(e,t){return{results:$.map(e.results,(function(e){return{id:e.slug,text:e.text}})),pagination:{more:e.pagination.more}}},cache:!0},escapeMarkup:function(e){return e}}),$("#lessons").select2({minimumInputLength:0,width:"100%",allowClear:!0,ajax:{delay:150,data:function(e){return{q:e.term,page:e.page,chapter_slug:$("#chapters").val()}},processResults:function(e,t){return{results:$.map(e.results,(function(e){return{id:e.slug,text:e.text}})),pagination:{more:e.pagination.more}}},cache:!0},escapeMarkup:function(e){return e}}),$("#grades").on("change",(function(){$("#subjects").val(null).trigger("change")})),$("#subjects").on("change",(function(){$("#chapters").val(null).trigger("change")})),$("#chapters").on("change",(function(){$("#lessons").val(null).trigger("change")})),$("#subjects").on("select2:open",(function(){if(!$("#grades").val()||0==$("#grades").val())return toastr.options.positionClass="toast-top-center",toastr.error("Bạn vui lòng chọn một lớp bạn quan tâm."),void $(this).select2("close")})),$("#chapters").on("select2:open",(function(){if(!$("#grades").val()||!$("#subjects").val()||0==$("#subjects").val())return toastr.options.positionClass="toast-top-center",toastr.error("Bạn vui lòng chọn một môn bạn quan tâm."),void $(this).select2("close")})),$("#lessons").on("select2:open",(function(){if(!$("#chapters").val()||0==$("#chapters").val())return toastr.options.positionClass="toast-top-center",toastr.error("Bạn vui lòng chọn một chương bạn quan tâm."),void $(this).select2("close")})),$(".js-submit_filter").on("click",(function(e){e.preventDefault();var t=$(this).closest(".js-filter-exam");if(!t.find("#grades").val())return toastr.options.positionClass="toast-top-center",void toastr.error("Hãy chọn một lớp bạn quan tâm để tìm kiếm các bộ đề.");t.submit()})),$("#sort").select2({minimumInputLength:0,width:"100%"}),n(),$("#dismiss, .sidebar-overlay").on("click",(function(){$(".sidenav").removeClass("active"),$(".sidebar-overlay").fadeOut()})),$("#sidebarCollapse").on("click",(function(){$("ul.content-table").css({"max-height":"calc(100vh)"}),$(".sidenav").addClass("active"),$(".sidebar-overlay").fadeIn(),$("a[aria-expanded=true]").attr("aria-expanded","false")})),$(document).on("click",'[data-toggle="scroll"]',(function(e){void 0!==e&&"function"==typeof e.preventDefault&&e.preventDefault();var t=$(this),n=$(t.data("target"));if(n.length>0){var a=n.offset().top-100,o=800;t.data("duration")&&(o=t.data("duration")),function(e,t){void 0===t&&(t=800);$("body,html").animate({scrollTop:e},t)}(a,o)}}));$(".js-download_app").on("click",(function(e){e.preventDefault(),"iOS"==window.helperFunc.getMobileOperatingSystem()?window.open("https://apps.apple.com/us/app/vietjack/id1490262941","_blank"):window.open("https://play.google.com/store/apps/details?id=com.jsmile.android.vietjack","_blank")})),$(".show-more").on("click",(function(){$(".qas").css("max-height","initial"),$(this).remove()}))})),$(window).bind("resize",(function(){n()})),$(window).scroll((function(){var e=$("header").height();$("footer").height(),$(".sidenav").height(),$(".sidenav .content-table").height();$(window).scrollTop()>e?$("#sidebar").css({position:"fixed",top:"0px",width:"300px"}):($("#sidebar").css({position:"static"}),$(".sidenav").css({bottom:"auto"})),$(window).scrollTop()+$(window).height()>$(document).height()-200&&$("#sidebar, .sidenav").css({position:"absolute",top:"auto",width:"300px",bottom:"0px"})}))})();