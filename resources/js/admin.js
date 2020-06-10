(function ($) {
  $('.copyDataBtn').each(function () {
    $(this).on('click', function () {
      var copyText = $(this).prev('.shareCode');
      copyText.select();
      document.execCommand("copy");
    });
  });
})(jQuery);