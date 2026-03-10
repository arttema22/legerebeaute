document.addEventListener('DOMContentLoaded', () => {
   const accordeons = document.querySelectorAll('.lb-accordeon');

   accordeons.forEach(accordeon => {
      const triggers = accordeon.querySelectorAll('.lb-accordeon-trigger');

      triggers.forEach(trigger => {
         trigger.addEventListener('click', () => {
            const content = trigger.nextElementSibling;
            const isActive = trigger.classList.contains('is-active');

            // Опция: закрывать другие открытые пункты в этом Аккордеоне
            const closeOthers = accordeon.dataset.closeOthers !== 'false';

            if (closeOthers) {
               // Закрываем все остальные
               triggers.forEach(otherTrigger => {
                  if (otherTrigger !== trigger) {
                     otherTrigger.classList.remove('is-active');
                     otherTrigger.setAttribute('aria-expanded', 'false');
                     otherTrigger.nextElementSibling.style.maxHeight = null;
                  }
               });
            }

            // Переключаем текущий
            if (!isActive) {
               trigger.classList.add('is-active');
               trigger.setAttribute('aria-expanded', 'true');
               // Вычисляем высоту контента для анимации
               content.style.maxHeight = content.scrollHeight + "px";

               trigger.style.paddingLeft = '30px';
               trigger.style.marginBottom = '1rem';

            } else {
               trigger.classList.remove('is-active');
               trigger.setAttribute('aria-expanded', 'false');
               content.style.maxHeight = null;

               trigger.style.paddingLeft = 0;
               trigger.style.marginBottom = 0;
            }
         });
      });
   });
});