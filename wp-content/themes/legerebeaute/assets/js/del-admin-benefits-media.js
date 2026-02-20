// wp-content/themes/legerebeaute/assets/js/admin-benefits-media.js

// Используем IIFE для изоляции переменной mediaFrame
(function () {
   let mediaFrame; // Локальная переменная

   function initializeBenefitMediaHandlers() {
      // Обработчик для кнопки "Выбрать изображение"
      document.querySelectorAll('.select-benefit-image-btn').forEach(button => {
         button.addEventListener('click', function (e) {
            e.preventDefault();

            const row = this.closest('tr');
            const imageIdInput = row.querySelector('.benefit-image-id-field');
            const imagePreviewDiv = row.querySelector('.benefit-image-preview');

            const attachmentId = imageIdInput.value;

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
               title: 'Выберите изображение для преимущества',
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
               imageIdInput.value = attachment.id;

               // Обновляем превью
               imagePreviewDiv.innerHTML = `<img src="${attachment.sizes.thumbnail.url}" style="width: 100%; height: auto;" />`;

               // Добавляем кнопку "Удалить"
               const removeButton = document.createElement('button');
               removeButton.type = 'button';
               removeButton.className = 'button button-small remove-benefit-image-btn';
               removeButton.textContent = 'Удалить';
               removeButton.onclick = function () {
                  imageIdInput.value = '';
                  imagePreviewDiv.innerHTML = '';
                  this.parentNode.removeChild(this); // Удаляем себя
               };
               this.parentNode.insertBefore(removeButton, this.nextSibling);

            });

            // Открываем фрейм
            mediaFrame.open();
         });
      });

      // Обработчик для кнопки "Удалить" (делегирование, так как кнопки создаются динамически)
      document.querySelector('#benefits-table tbody').addEventListener('click', function (e) {
         if (e.target.classList.contains('remove-benefit-image-btn')) {
            e.preventDefault();
            const row = e.target.closest('tr');
            const imageIdInput = row.querySelector('.benefit-image-id-field');
            const imagePreviewDiv = row.querySelector('.benefit-image-preview');

            // Очищаем поле и превью
            imageIdInput.value = '';
            imagePreviewDiv.innerHTML = '';

            // Удаляем саму кнопку "Удалить"
            e.target.remove();
         }
      });
   }

   // Делаем функцию доступной глобально, если она вызывается из PHP
   window.initializeBenefitMediaHandlers = initializeBenefitMediaHandlers;

})();