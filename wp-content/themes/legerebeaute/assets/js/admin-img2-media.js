// wp-content/themes/legerebeaute/assets/js/admin-img2-media.js

// Используем IIFE для изоляции переменной mediaFrame
(function () {
   let mediaFrame; // Локальная переменная

   document.addEventListener('DOMContentLoaded', function () {
      const selectBtn = document.getElementById('select-image-2');
      // const removeBtn = document.getElementById('remove-image-2'); // УДАЛИЛИ: нельзя получать заранее, может не существовать
      const container = document.getElementById('legerebeaute-image-2-container');
      const hiddenInput = document.getElementById('legerebeaute-image-2-id');

      if (!selectBtn || !hiddenInput) {
         console.error('Кнопка выбора изображения или скрытое поле не найдены.');
         return;
      }

      selectBtn.addEventListener('click', function (e) {
         e.preventDefault();

         const attachmentId = hiddenInput.value;

         // Если фрейм уже существует, просто открываем его
         if (mediaFrame) {
            mediaFrame.open();
            // Устанавливаем начальный выбор, если было изображение
            if (attachmentId) {
               mediaFrame.on('open', function () {
                  const selection = mediaFrame.state().get('selection');
                  selection.reset([wp.media.attachment(attachmentId)]);
               });
            }
            return;
         }

         // Создаем новый фрейм
         mediaFrame = wp.media({
            title: 'Выберите изображение 2',
            button: {
               text: 'Выбрать'
            },
            library: {
               type: 'image' // Только изображения
            },
            multiple: false // Одно изображение
         });

         // Обработчик события выбора изображения
         mediaFrame.on('select', function () {
            const selection = mediaFrame.state().get('selection');
            const attachment = selection.first().toJSON();

            // Обновляем скрытое поле с ID
            hiddenInput.value = attachment.id;

            // Обновляем превью
            container.innerHTML = `<img src="${attachment.sizes.thumbnail.url}" width="150" />`;

            // --- ИСПРАВЛЕНО: Создаём кнопку заново ---
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'button';
            removeBtn.id = 'remove-image-2'; // Присваиваем ID
            removeBtn.textContent = 'X';

            // Добавляем обработчик удаления к новой кнопке
            removeBtn.addEventListener('click', function (e) {
               e.preventDefault();
               // Очищаем скрытое поле
               hiddenInput.value = '';
               // Удаляем превью
               const img = container.querySelector('img');
               if (img) img.remove();
               // Убираем саму кнопку удаления
               removeBtn.remove();
            });

            // Добавляем кнопку удаления в контейнер
            container.appendChild(removeBtn);
            // ---------------------------------------

            // Добавляем скрытое поле и кнопку выбора обратно в контейнер
            container.appendChild(hiddenInput);
            container.appendChild(selectBtn);
         });

         // Открываем фрейм
         mediaFrame.open();
      });

      // ИСПРАВЛЕНО: Обработчик удаления теперь добавляется к кнопке при её создании (см. выше)
      // Нам всё ещё нужно обработать *первоначальную* кнопку "X", если она была в HTML при загрузке страницы.
      const existingRemoveBtn = document.getElementById('remove-image-2');
      if (existingRemoveBtn) {
         existingRemoveBtn.addEventListener('click', function (e) {
            e.preventDefault();
            // Очищаем скрытое поле
            hiddenInput.value = '';
            // Удаляем превью
            const img = container.querySelector('img');
            if (img) img.remove();
            // Убираем саму кнопку удаления
            existingRemoveBtn.remove();
         });
      }

   });

})();