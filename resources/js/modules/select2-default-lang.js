export function select2DefaultLang($) {
  $.fn.select2.defaults.set('language', $('html').attr('lang') || 'en');
}
