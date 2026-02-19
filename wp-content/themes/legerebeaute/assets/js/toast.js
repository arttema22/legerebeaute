/**
 * Система уведомлений (Toast)
 *
 * @package legerebeaute
 */

(function ($) {
   'use strict';

   const Toast = {
      /**
       * Показать уведомление
       *
       * @param {string} message - Текст уведомления
       * @param {string} type - Тип: 'success', 'error', 'warning', 'info'
       * @param {number} duration - Время показа в мс (0 = не скрывать автоматически)
       */
      show: function (message, type = 'success', duration = 5000) {
         const toast = this.createToast(message, type);
         document.body.appendChild(toast);

         // Показать уведомление
         setTimeout(() => {
            toast.classList.add('show');
         }, 10);

         // Автоматическое скрытие
         if (duration > 0) {
            setTimeout(() => {
               this.hide(toast);
            }, duration);
         }

         return toast;
      },

      /**
       * Создать элемент уведомления
       *
       * @param {string} message - Текст уведомления
       * @param {string} type - Тип уведомления
       */
      createToast: function (message, type) {
         const toast = document.createElement('div');
         toast.className = `toast-notification ${type}`;

         const icon = this.getIcon(type);
         const messageEl = document.createElement('div');
         messageEl.className = 'toast-message';
         messageEl.textContent = message;

         const closeBtn = document.createElement('button');
         closeBtn.className = 'toast-close';
         closeBtn.innerHTML = '×';
         closeBtn.setAttribute('aria-label', 'Закрыть уведомление');
         closeBtn.addEventListener('click', () => this.hide(toast));

         toast.appendChild(icon);
         toast.appendChild(messageEl);
         toast.appendChild(closeBtn);

         return toast;
      },

      /**
       * Получить иконку для типа уведомления
       *
       * @param {string} type - Тип уведомления
       */
      getIcon: function (type) {
         const icon = document.createElement('div');
         icon.className = 'toast-icon';

         const icons = {
            success: `<svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path></svg>`,
            error: `<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>`,
            warning: `<svg viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"></path></svg>`,
            info: `<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>`,
         };

         icon.innerHTML = icons[type] || icons.info;
         return icon;
      },

      /**
       * Скрыть уведомление
       *
       * @param {HTMLElement} toast - Элемент уведомления
       */
      hide: function (toast) {
         if (!toast) return;

         toast.classList.remove('show');
         toast.classList.add('hide');

         // Удалить элемент после анимации
         setTimeout(() => {
            if (toast.parentNode) {
               toast.parentNode.removeChild(toast);
            }
         }, 300);
      },

      /**
       * Показать успешное уведомление
       */
      success: function (message, duration = 5000) {
         return this.show(message, 'success', duration);
      },

      /**
       * Показать уведомление об ошибке
       */
      error: function (message, duration = 5000) {
         return this.show(message, 'error', duration);
      },

      /**
       * Показать предупреждение
       */
      warning: function (message, duration = 5000) {
         return this.show(message, 'warning', duration);
      },

      /**
       * Показать информационное уведомление
       */
      info: function (message, duration = 5000) {
         return this.show(message, 'info', duration);
      },
   };

   // Экспорт в глобальную область видимости
   window.Toast = Toast;

   // Инициализация
   // $(document).ready(function () {
   //    console.log('Toast notifications initialized');
   // });

})(jQuery);