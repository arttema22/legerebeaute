document.addEventListener('DOMContentLoaded', function () {
   const modal = document.querySelector('#main-menu-mobile');
   const toggle = document.querySelector('.mobile-menu-toggle');
   const overlay = modal.querySelector('.modal__overlay');
   const closeBtn = modal.querySelector('.modal__close');

   if (toggle && modal) {
      // Функция открытия меню
      function openMenu() {
         const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
         if (!isExpanded) {
            toggle.setAttribute('aria-expanded', 'true');
            modal.hidden = false;
            modal.classList.add('is-open');
         }
      }
      // Функция для закрытия меню
      function closeMenu() {
         const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
         if (isExpanded) {
            toggle.setAttribute('aria-expanded', 'false');
            modal.hidden = true;
            modal.classList.remove('is-open');
            toggle.focus();
         }
      }
      // Обработчик клика по кнопке открытия
      toggle.addEventListener('click', function (e) {
         e.preventDefault();
         const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
         if (isExpanded) {
            closeMenu();
         } else {
            openMenu();
         }
      });
      // Обработчик клика по оверлею
      if (overlay) {
         overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
               closeMenu();
            }
         });
      }
      // Обработчик клика по кнопке закрытия
      if (closeBtn) {
         closeBtn.addEventListener('click', function (e) {
            e.preventDefault();
            closeMenu();
         });
      }
      // Обработчик нажатия клавиши Escape
      document.addEventListener('keydown', function (e) {
         if (e.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            closeMenu();
         }
      });
   }
});

document.addEventListener('DOMContentLoaded', function () {
   const menu = document.querySelector('.js-main-menu');
   if (!menu) return;

   const items = menu.querySelectorAll('li');
   if (items.length <= 4) return; // ничего не скрываем

   // Добавляем класс контейнеру, чтобы показать кнопку "Ещё"
   const nav = menu.closest('.main-navigation');
   nav.classList.add('has-extra-menu');

   // Берём пункты с 5-го по конец (индексы 4+)
   const extraItems = Array.from(items).slice(4);

   // Перемещаем их в блок "extra"
   const extraMenu = document.querySelector('.js-menu-extra');
   extraItems.forEach(item => {
      extraMenu.appendChild(item);
   });

   // Обработчик кнопки
   const toggleBtn = document.querySelector('.js-menu-toggle');
   const isExpanded = () => toggleBtn.getAttribute('aria-expanded') === 'true';

   toggleBtn.addEventListener('click', () => {
      const expanded = !isExpanded();
      toggleBtn.setAttribute('aria-expanded', expanded);
      extraMenu.hidden = !expanded;
      extraMenu.classList.toggle('expanded', expanded);
   });
});