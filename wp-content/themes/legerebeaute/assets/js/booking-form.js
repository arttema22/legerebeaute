/**
 * Кастомный дропдаун для выбора времени
 */
(function ($) {
   'use strict';

   $(document).ready(function () {
      const $dropdown = $('.dropdown');
      const $current = $dropdown.find('.dropdown__current');
      const $content = $dropdown.find('.dropdown__content');
      const $radioInputs = $content.find('input[type="radio"]');

      // Открытие/закрытие дропдауна
      $current.on('click', function (e) {
         e.stopPropagation();
         $dropdown.toggleClass('is-open');
      });

      // Выбор времени
      $radioInputs.on('change', function () {
         const selectedTime = $(this).next('span').text();
         $current.text(selectedTime);
         $dropdown.removeClass('is-open');
      });

      // Закрытие при клике вне дропдауна
      $(document).on('click', function (e) {
         if (!$dropdown.is(e.target) && $dropdown.has(e.target).length === 0) {
            $dropdown.removeClass('is-open');
         }
      });

      // Закрытие при нажатии Escape
      $(document).on('keydown', function (e) {
         if (e.key === 'Escape') {
            $dropdown.removeClass('is-open');
         }
      });
   });
})(jQuery);