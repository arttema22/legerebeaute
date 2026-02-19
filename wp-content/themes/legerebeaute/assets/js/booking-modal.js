/**
 * Модальное окно онлайн-записи
 *
 * @package legerebeaute
 */

(function ($) {
   'use strict';

   const LBBookingModal = {
      modal: null,
      overlay: null,
      closeBtn: null,
      serviceTitleEl: null,
      currentService: null,

      init: function () {
         this.cacheElements();
         this.bindEvents();
      },

      cacheElements: function () {
         this.modal = $('#booking-modal');
         this.overlay = this.modal.find('.modal__overlay');
         this.closeBtn = this.modal.find('.modal__close');
         this.serviceTitleField = this.modal.find('input[name="lb-service-01"]');
      },

      bindEvents: function () {
         // Открытие модального окна
         $(document).on('click', '.btn-booking-modal', this.openModal.bind(this));

         // Закрытие по клику на оверлей
         this.overlay.on('click', this.closeModal.bind(this));

         // Закрытие по кнопке
         this.closeBtn.on('click', this.closeModal.bind(this));

         // Закрытие по Escape
         $(document).on('keydown', this.handleKeydown.bind(this));

         // Обработка отправки CF7
         $(document).on('wpcf7mailsent', this.handleFormSuccess.bind(this));
         $(document).on('wpcf7invalid', this.handleFormError.bind(this));
      },

      openModal: function (e) {
         e.preventDefault();

         const button = $(e.currentTarget);
         const serviceId = button.data('service-id');
         const serviceTitle = button.data('service-title');

         this.currentService = {
            id: serviceId,
            title: serviceTitle,
         };

         // Показываем название услуги
         if (this.serviceTitleField.length) {
            this.serviceTitleField.val(serviceTitle).trigger('change');
         }

         // Загружаем данные об услуге через AJAX (опционально)
         this.loadServiceData(serviceId);

         // Открываем модальное окно
         this.modal.addClass('is-open');
      },

      closeModal: function () {
         this.modal.removeClass('is-open');
      },

      handleKeydown: function (e) {
         if (e.key === 'Escape' && this.modal.hasClass('is-open')) {
            this.closeModal();
         }
      },

      loadServiceData: function (serviceId) {
         $.ajax({
            url: lb_booking_modal.ajax_url,
            type: 'POST',
            data: {
               action: 'lb_get_service_data',
               service_id: serviceId,
               nonce: lb_booking_modal.nonce,
            },
            dataType: 'json',
         })
            .done(function (response) {
               if (response.success) {
                  console.log('Данные об услуге:', response.data);
               } else {
                  console.warn('Ошибка сервера:', response.data);
               }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
               console.error('Ошибка AJAX:', textStatus, errorThrown);
            });
      },

      handleFormSuccess: function (e) {
         this.closeModal();
         // Показываем уведомление
         const message =
            e.detail.apiResponse.message ||
            'Спасибо за обращение! Наш специалист свяжется с Вами в ближайшее время.';
         if (typeof window.Toast !== 'undefined') {
            window.Toast.success(message, 5000);
         } else {

            alert(message);
         }
         this.resetForm();
      },

      // Обработчик ошибок
      handleFormError: function (e) {
         const message =
            e.detail.apiResponse.message ||
            'Пожалуйста, заполните все обязательные поля.';

         if (typeof window.Toast !== 'undefined') {
            window.Toast.error(message, 3000);
         }
      },

      resetForm: function () {
         const form = this.modal.find('.wpcf7-form');
         if (form.length) {
            form[0].reset();
            form.find('.wpcf7-not-valid-tip').remove();
            form.find('.wpcf7-response-output').hide();
         }
      },
   };

   $(document).ready(function () {
      LBBookingModal.init();
   });
})(jQuery);