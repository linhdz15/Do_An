export function initSelect2SelectedValues() {
  $('.js-select2-ajax').each(function() {
    const $select2 = $(this);
    const selectedValues = $select2.data('ajax-selected-values');

    if (!selectedValues || $select2.val() == selectedValues) {
      return;
    }

    const ajaxUrl = $select2.data('ajax-url');

    $.ajax({
      url: ajaxUrl,
      type: 'GET',
      data: {
        selectedValues: selectedValues,
      },
    }).done(function(data) {
      if (!data || !data.results || !data.results.length) {
        return;
      }

      for (let index = 0; index < data.results.length; index++) {
        const result = data.results[index];
        const option = new Option(result.text, result.id, true, true);
        $select2.append(option);
      }

      $select2.trigger({
        type: 'select2:select',
      });
    });
  });
}
